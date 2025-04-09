<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Linkedin
{
    protected $config = [];

    public function __construct(array $config = null, protected ?string $accessToken = null)
    {
        $this->config = $config ?? config('platform.linkedin');
        $this->config['redirect_uri'] = url($this->config['redirect_uri']);
    }

    private function apiUrl(string $endpoint, array $params = [], bool $isBaseUrl = false)
    {
        $apiUrl = $isBaseUrl ? $this->config['base_url'] : $this->config['api_url'];

        if (str_starts_with($endpoint, '/')) {
            $endpoint = substr($endpoint, 1);
        }

        $v = $this->config['api_version'] ?? null;
        $versionedUrlWithEndpoint = $apiUrl . '/' . (!$isBaseUrl && $v ? ($v . '/') : '') . $endpoint;

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

    public static function authRedirect(array $scopes = [])
    {
        $linkedin = new static;
        $linkedin->config['scopes'] = $scopes ?? config('platform.linkedin.scopes', []);
        $scopes = collect($linkedin->config['scopes'])->join(' ');

        $apiUrl = $linkedin->apiUrl('oauth/v2/authorization', [
            'response_type' => 'code',
            'client_id' => $linkedin->config['app_id'],
            'redirect_uri' => $linkedin->config['redirect_uri'],
            // 'state' => '',
            'scope' => $scopes,
        ], true);

        return inertia_location($apiUrl);
    }

    public function getAccessToken(string $code): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('oauth/v2/accessToken', [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
        ], true);

        return Http::post($apiUrl);
    }

    public function refreshAccessToken(): \Illuminate\Http\Client\Response
    {
        $apiUrl = $this->apiUrl('oauth/v2/accessToken', [
            'refresh_token' => $this->accessToken,
            'grant_type' => 'refresh_token',
            'client_id' => $this->config['app_id'],
            'client_secret' => $this->config['app_secret'],
        ], true);

        return Http::post($apiUrl);
    }

    public function getAccountInfo()
    {
        $apiUrl = $this->apiUrl('v2/userinfo');
        return Http::withToken($this->accessToken)->get($apiUrl);
    }

    public function publishText(string $userId, string $text): \Illuminate\Http\Client\Response
    {
        $post = [
            "author" => "urn:li:person:{$userId}",
            "commentary" => $text,
            "visibility" => config('platform.linkedin.options.visibility', 'PUBLIC'),
            "distribution" => [
                "feedDistribution" => config('platform.linkedin.options.feedDistribution', 'MAIN_FEED'),
                "targetEntities" => [],
                "thirdPartyDistributionChannels" => []
            ],
            "lifecycleState" => "PUBLISHED",
            "isReshareDisabledByAuthor" => false
        ];

        $response = $this->apiClient()->post($this->apiUrl('rest/posts'), $post);

        return $response;
    }

    public function publishImage(string $userId, array $images, string $text): \Illuminate\Http\Client\Response
    {
        $uploadedMedia = collect([]);
        foreach ($images as $imagePath) {
            $imageContainer = $this->apiClient()
                ->post($this->apiUrl('rest/images', [
                    'action' => 'initializeUpload'
                ]), [
                    "initializeUploadRequest" => ["owner" => "urn:li:person:{$userId}"]
                ])
                ->json('value');


            $response = $this->apiClient()
                ->attach('file', fopen($imagePath, 'r'))
                ->post($imageContainer['uploadUrl']);

            if ($response->created()) {
                $uploadedMedia->push($imageContainer);
            }
        }

        $postImages = $uploadedMedia->map(function ($item) {
            return ['id' => $item['image']];
        });

        $attachMediaObj = ($postImages->count() > 1) ? [
            "content" => [
                "multiImage" => [
                    "images" => $postImages->toArray()
                ]
            ]
        ] : [
            "content" => [
                "media" => [
                    "id" => $postImages->value('id')
                ]
            ]
        ];


        $post = [
            "author" => "urn:li:person:{$userId}",
            "commentary" => $text,
            "visibility" => config('platform.linkedin.options.visibility', 'PUBLIC'),
            "distribution" => [
                "feedDistribution" => config('platform.linkedin.options.feedDistribution', 'MAIN_FEED'),
                "targetEntities" => [],
                "thirdPartyDistributionChannels" => []
            ],
            "lifecycleState" => "PUBLISHED",
            "isReshareDisabledByAuthor" => false,
            ...$attachMediaObj
        ];

        $response = $this->apiClient()->post($this->apiUrl('rest/posts'), $post);

        return $response;
    }


    /**
     * Publish a video on LinkedIn.
     *
     * @param string $userId The id of the user who will publish the post.
     * @param string $videoPath The path to the video file that will be uploaded.
     * @param string $text The text that will be used as the caption for the post.
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function publishVideo(string $userId, string $videoPath, string $text): \Illuminate\Http\Client\Response
    {
        // First, we need to check if the file exists.
        throw_unless(Storage::exists($videoPath), "File not found: $videoPath");

        // Get the size of the video.
        $mediaFileSize = Storage::size($videoPath);
        $mediaName = basename($videoPath);

        $mediaContainerData = [
            "mediaLibraryMetadata" => [
                "owner" => "urn:li:person:{$userId}",
                "assetName" => $mediaName
            ],
            "initializeUploadRequest" => [
                "owner" => "urn:li:person:{$userId}",
                "fileSizeBytes" => $mediaFileSize,
                "uploadCaptions" => false,
                "uploadThumbnail" => false
            ]
        ];

        // Initialize the video upload.
        $mediaContainerRes = $this->apiClient()
            ->asJson()
            ->post($this->apiUrl('rest/videos', ['action' => 'initializeUpload']), $mediaContainerData);


        // Check if the initialization was successful.
        if ($mediaContainerRes->failed()) {
            return $mediaContainerRes;
        }

        // Get the video container.
        $mediaContainer = $mediaContainerRes->json('value');


        $videoSplitService = new FileSplitService($videoPath, 4);

        // break the video into its max size 4mb then upload each chunks
        $videoChunks = $videoSplitService->splitAndUpload();

        $uploadedParts = [];
        foreach ($videoChunks as $key => $chunk) {

            // 1. Get the upload url.
            $uploadUrl = $mediaContainer['uploadInstructions'][$key]['uploadUrl'];

            // 2. option for uploading the video with the chunks
            $fileContent = file_get_contents($chunk);
            $uploadMediaRes = Http::withHeaders([
                'Content-Type' => 'application/octet-stream'
            ])
                ->withBody($fileContent, 'application/octet-stream')
                ->put($uploadUrl);

            // Get the video id and the ETag.
            $videoId = $mediaContainer['video'];
            $eTag = $uploadMediaRes->headers()['ETag'] ?? [];
            array_push($uploadedParts, ...$eTag);
        }

        $finalizeMediaData = [
            'finalizeUploadRequest' => [
                "video" => $videoId,
                "uploadToken" => "",
                "uploadedPartIds" => $uploadedParts
            ]
        ];

        // Finalize the video upload.
        $this->apiClient()->asJson()
            ->post($this->apiUrl('rest/videos', ['action' => 'finalizeUpload']), $finalizeMediaData)
            ->throw();

        // Get the status of the video.
        $videoStatus = $this->apiClient()->get($this->apiUrl("rest/videos/" . urlencode($videoId)))->throw();

        // throw and exception if the video status is processing failed
        throw_if(
            $videoStatus->json('status') == 'PROCESSING_FAILED ',
            new Exception('Video processing failed. Reason: ' . $videoStatus->json('processingFailureReason' ?? 'unknown'))
        );

        // check if video status is processed for 10 times
        $isVideoAllowed = false;
        $maxAttempts = 10;
        $attempt = 0;
        $delay = 2;
        while (!$isVideoAllowed && $attempt < $maxAttempts) {
            $videoStatus = $this->apiClient()->get($this->apiUrl("rest/videos/" . urlencode($videoId)))->throw();

            if ($videoStatus->json('status') == 'AVAILABLE') {
                $isVideoAllowed = true;
                break;
            }

            $attempt++;
            sleep($delay);
        }

        // Create the post.
        $post = [
            "author" => "urn:li:person:{$userId}",
            "commentary" => $text,
            "visibility" => config('platform.linkedin.options.visibility', 'PUBLIC'),
            "distribution" => [
                "feedDistribution" => config('platform.linkedin.options.feedDistribution', 'MAIN_FEED'),
                "targetEntities" => [],
                "thirdPartyDistributionChannels" => []
            ],
            "lifecycleState" => "PUBLISHED",
            "isReshareDisabledByAuthor" => false,
            "content" => [
                "media" => [
                    "id" => $videoId
                ]
            ]
        ];

        $videoSplitService->cleanup();

        return $this->apiClient()->post($this->apiUrl('rest/posts'), $post)->throw();

    }

    // analytics
    public function getPostAnalytics(string $urn): \Illuminate\Http\Client\Response
    {
        $urn = urlencode($urn);
        $apiUrl = $this->apiUrl("rest/socialMetadata/{$urn}");
        return $this->apiClient()->get($apiUrl);
    }

    public function getVideo(string $urn): \Illuminate\Http\Client\Response
    {
        return $this->apiClient()->get($this->apiUrl("rest/videos/{$urn}"));
    }

    private function apiClient(): PendingRequest
    {
        return Http::withHeaders([
            'X-Restli-Protocol-Version' => config('platform.linkedin.restli_protocol_version'),
            'LinkedIn-Version' => config('platform.linkedin.header_version'),
        ])->withToken($this->accessToken)->retry(1, 3000);
    }
}
