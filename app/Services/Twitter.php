<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Twitter
{
    protected array $config = [];

    public function __construct(array $config = null, protected ?string $accessToken = null)
    {
        $this->config = $config ?? config('platform.twitter');
        $this->config['redirect_uri'] = url(config('platform.twitter.redirect_uri'));
    }

    private function apiUrl(string $endpoint, array $params = [], bool $isBaseUrl = false)
    {
        $baseOrApiUrl = $isBaseUrl ? $this->config['base_url'] : $this->config['api_url'];

        if (str_starts_with($endpoint, '/')) {
            $endpoint = substr($endpoint, 1);
        }

        $v = $this->config['api_version'];
        $versionedUrlWithEndpoint = $baseOrApiUrl . '/' . ($v ? ($v . '/') : '') . $endpoint;

        if (count($params)) {
            $versionedUrlWithEndpoint .= '?' . http_build_query($params);
        }
        return $versionedUrlWithEndpoint;
    }

    public function setToken(string $bearerToken)
    {
        $this->accessToken = $bearerToken;
        return $this;
    }
    public function authRedirect()
    {
        $client_id = $this->config['app_id'];
        $redirect_uri = $this->config['redirect_uri'];
        $scope = 'tweet.read tweet.write users.read offline.access';
        $codeChallenge = 'challenge';
        $state = 'state';
        $authorizationUri = "https://twitter.com/i/oauth2/authorize?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&state=$state&code_challenge=$codeChallenge&code_challenge_method=plain";
        return inertia_location($authorizationUri);
    }

    public function getAccessToken($code): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('oauth2/token', [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => $this->config['app_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'code_verifier' => 'challenge',
        ]);

        $basicAuthCredential = base64_encode($this->config['app_id'] . ':' . $this->config['client_secret']);

        return Http::withHeaders([
            'Authorization' => "Basic $basicAuthCredential",
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
        ])->post($apiUrl);
    }

    public function refreshAccessToken(): \Illuminate\Http\Client\Response
    {
        $params = [
            'refresh_token' => $this->accessToken,
            'grant_type' => 'refresh_token',
            'client_id' => $this->config['app_id'],
        ];
        $apiUrl = $this->apiUrl('oauth2/token', $params);
        return Http::asForm()->post($apiUrl);
    }

    public function getUserInfo(): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('users/me', [
            'user.fields' => 'name,profile_image_url,username,verified,verified_type',
        ]);
        return Http::withToken($this->accessToken)->get($apiUrl, );
    }


    public function publishTweet(string $text): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('tweets');
        return Http::withToken($this->accessToken)
            ->post($apiUrl, [
                'text' => $text
            ]);
    }

    public function publishMediaPost(array $files, ?string $message = null, $mediaType = 'image')
    {
        $consumerKey = config('platform.twitter.consumer_api_key');
        $consumerSecret = config('platform.twitter.consumer_api_secret');
        $access_token = config('platform.twitter.access_token');
        $access_token_secret = config('platform.twitter.access_token_secret');

        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $access_token, $access_token_secret);
        $twitter->setApiVersion(1.1);
        $mediaIds = [];

        foreach ($files as $key => $filePath) {

            if ($mediaType == 'video' && $key == 1) {
                continue;
            }

            $fileLocalPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, parse_url($filePath, PHP_URL_PATH)));
            throw_if(!file_exists($fileLocalPath));

            switch ($mediaType) {
                case 'image':
                    $media = $twitter->upload('media/upload', ['media' => $fileLocalPath]);
                    break;
                case 'video':
                    $mediaMimeType = File::mimeType($fileLocalPath);
                    $parameters = [
                        'media' => $fileLocalPath,
                        'media_type' => $mediaMimeType,
                        'media_category' => 'tweet_video',
                    ];
                    $media = $twitter->upload('media/upload', $parameters, ['chunkedUpload' => true]);

                    retry(3, function () use ($twitter, $media) {
                        $mediaId = $media?->media_id_string;
                        $response = (array) $twitter->mediaStatus($mediaId);
                        $status = data_get($response, 'processing_info.state');
                        throw_if(
                            $status !== 'succeeded',
                            "Video upload failed with status $status",
                        );

                    }, 3000);

                    break;
            }


            if ($mediaId = $media?->media_id_string ?? null) {
                $mediaIds[] = $mediaId;
            } else {
                throw_if(true, "Media id is not found");
            }
        }

        $twitter->setApiVersion(2);
        $parameters = [
            'text' => str($message)->limit(280)->toString(),
            'media' => ['media_ids' => $mediaIds]
        ];

        $res = $twitter->post('tweets', $parameters);

        $success = in_array(
            $twitter->getLastHttpCode(),
            [200, 201]
        );

        throw_unless(
            $success,
            data_get((array) $res, 'detail', "Failed to publish tweet!")
        );

        return $res;

    }

    // analytics
    public function getPostAnalytics(string $tweetId): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl("tweets/{$tweetId}", [
            'tweet.fields' => 'public_metrics,organic_metrics,non_public_metrics'
        ]);

        return Http::withToken($this->accessToken)->post($apiUrl);
    }
}
