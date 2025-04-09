<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Tiktok
{
    protected array $config = [];

    public function __construct(array $config = null, protected ?string $accessToken = null)
    {
        $this->config = $config ?? config('platform.tiktok');
        $this->config['redirect_uri'] = secure_url($this->config['redirect_uri']);
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

    public static function authRedirect()
    {
        $tiktok = new self;
        $client_key = $tiktok->config['app_key'];
        $scope = collect($tiktok->config['scope'])->join(',');
        $response_type = 'code';
        $state = '';
        $redirect_uri = $tiktok->config['redirect_uri'];

        $apiUri = "{$tiktok->config['base_url']}/{$tiktok->config['api_version']}/auth/authorize?client_key=$client_key&response_type=$response_type&scope=$scope&redirect_uri=$redirect_uri&state=$state";

        return inertia_location($apiUri);
    }

    public function getAccessToken($code)
    {
        $apiUri = $this->apiUrl('oauth/token/');

        return Http::asForm()->post(
            $apiUri,
            [
                'client_key' => $this->config['app_key'],
                'client_secret' => $this->config['app_secret'],
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->config['redirect_uri'],
            ]
        );
    }
    public function refreshAccessToken()
    {
        $apiUri = $this->apiUrl('oauth/token/');

        return Http::asForm()->post(
            $apiUri,
            [
                'client_key' => $this->config['app_key'],
                'client_secret' => $this->config['app_secret'],
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->accessToken,
            ]
        );
    }

    public function getAccountInfo(array $fields = null)
    {
        $apiUri = $this->apiUrl('user/info/', [
            'fields' => collect($fields)->join(',')
        ]);

        return Http::withToken($this->accessToken)->get($apiUri);
    }

    public function getCreatorInfo(): array
    {
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer $this->accessToken"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl('post/publish/creator_info/query/'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public function postVideo(array $postData): \Illuminate\Http\Client\Response
    {
        return Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8'
            ])
            ->post($this->apiUrl('post/publish/video/init/'), $postData);
    }

    public function postPhoto(array $postData)
    {
        return Http::withToken($this->accessToken)
            ->acceptJson()
            ->post($this->apiUrl('post/publish/content/init/'), $postData);
    }

    public function getPostAnalytics(array $videoIds, array $fields = [])
    {
        $apiUri = $this->apiUrl('video/query/', ['fields' => collect($fields)->join(',')]);
        return Http::withToken($this->accessToken)
            ->post($apiUri, [
                'filters' => [
                    'video_ids' => $videoIds
                ]
            ]);
    }
}
