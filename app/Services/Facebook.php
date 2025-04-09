<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Facebook
{
    protected array $config = [];

    public function __construct(array $config = null, protected ?string $accessToken = null)
    {
        $this->config = $config ?? config('platform.facebook');
        $this->config['redirect_uri'] = secure_url(config('platform.facebook.redirect_uri'));
    }

    private function apiUrl(string $endpoint, array $params = [], bool $isBaseUrl = false)
    {
        $apiUrl = $isBaseUrl ? $this->config['base_url'] : $this->config['api_url'];

        if (str_starts_with($endpoint, '/')) {
            $endpoint = substr($endpoint, 1);
        }

        $v = $this->config['api_version'];
        $versionedUrlWithEndpoint = $apiUrl . '/' . ($v ? ($v . '/') : '') . $endpoint;

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

    // auth
    public static function authRedirect(array $scopes = [])
    {
        $fb = new self();

        if ($scopes) {
            $fb->config['scopes'] = $scopes;
        }

        $scopes = collect($fb->config['scopes'])->join(',');

        $authUri = $fb->apiUrl('dialog/oauth', [
            'response_type' => 'code',
            'client_id' => $fb->config['app_id'],
            'redirect_uri' => $fb->config['redirect_uri'],
            'scope' => $scopes,
        ], true);

        return inertia_location($authUri);
    }

    public function getAccessToken(string $code): \Illuminate\Http\Client\Response
    {
        $fb = new self;
        $apiUrl = $fb->apiUrl('/oauth/access_token', [
            'code' => $code,
            'client_id' => $fb->config['app_id'],
            'client_secret' => $fb->config['app_secret'],
            'redirect_uri' => $fb->config['redirect_uri'],
        ]);

        return Http::post($apiUrl);
    }

    public function refreshAccessToken(): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('/oauth/access_token', [
            'client_id' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'grant_type' => 'fb_exchange_token',
            'fb_exchange_token' => $this->accessToken,
        ]);

        return Http::post($apiUrl);
    }

    // account
    public function getAccountInfo(array $fields = []): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('/me', [
            'access_token' => $this->accessToken,
            'fields' => collect($fields)->join(',')
        ]);

        return Http::get($apiUrl);
    }

    public function getPagesInfo(array $fields = []): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('/me/accounts', [
            'access_token' => $this->accessToken,
            'fields' => collect($fields)->join(',')
        ]);

        return Http::get($apiUrl);
    }

    // publish
    public function publishTextOnPage(int $pageId, string $text): \Illuminate\Http\Client\Response
    {
        return Http::withToken($this->accessToken)
            ->acceptJson()
            ->post(
                $this->apiUrl($pageId . '/feed'),
                [
                    'message' => $text,
                ]
            );
    }

    public function publishPhotoOnPage(int $pageId, string $text, array $photos): \Illuminate\Http\Client\Response
    {
        $attached_media = [];
        foreach ($photos as $url) {
            $res = Http::retry(3, 3000)
                ->withToken($this->accessToken)
                ->post($this->apiUrl($pageId . '/photos'), [
                    'url' => $url,
                    'published' => false
                ]);
            $attached_media[] = ['media_fbid' => $res->json('id')];
        }

        return Http::retry(3, 3000)
            ->withToken($this->accessToken)
            ->post($this->apiUrl($pageId . '/feed'), [
                'message' => $text,
                'attached_media' => $attached_media
            ]);
    }

    public function publishVideoOnPage(string $pageId, string $fileUrl, string $caption = null): \Illuminate\Http\Client\Response
    {
        $postData = [
            'file_url' => $fileUrl,
            'description' => $caption,
            'access_token' => $this->accessToken,
        ];

        return Http::post($this->apiUrl("$pageId/videos"), $postData);
    }

    // analytics
    public function getPostAnalytics(string $postId, array $fields = []): \Illuminate\Http\Client\Response
    {
        return Http::withToken($this->accessToken)
            ->get($this->apiUrl($postId, [
                'fields' => collect($fields)->join(',')
            ]));
    }
}
