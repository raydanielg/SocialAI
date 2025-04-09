<?php

namespace App\Services;

use App\Services\Tiktok;
use App\Traits\Uploader;
use App\Models\BrandPost;
use App\Services\Twitter;
use App\Services\Facebook;
use App\Services\Linkedin;
use App\Services\Instagram;
use App\Models\BrandPostPlatform;
use App\Models\UserPlatform;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PostPublisherService
{
    use Uploader;

    private array|string|null|\Illuminate\Http\Client\Response $publishResponse = null;
    private array $publishResult = [];

    /**
     * @param BrandPost $brandPost
     * @param BrandPostPlatform|null $postPlatform
     */
    public function __construct(
        public BrandPost $brandPost,
        public BrandPostPlatform $postPlatform,
        public UserPlatform $userPlatform
    ) {
    }

    public function publish(): self
    {
        // get the brand post and user platform info
        $brandPost = $this->brandPost;
        $postPlatform = $this->postPlatform;
        $userPlatform = $this->userPlatform;

        // get info from user platform model
        $socialPlatform = $userPlatform->platform;
        $platformId = $userPlatform->platform_id;
        $accessToken = $userPlatform->access_token;

        $message = $postPlatform->content;
        $media = $postPlatform->media ?? [];
        $mediaType = $postPlatform->media_type;

        $response = null;

        /* Publish on Facebook */
        if ($socialPlatform == 'facebook') {
            // initialize the Facebook API class
            $fb = new Facebook();
            // set the access token for the Facebook API class
            $fb->setToken($accessToken);
            // call the appropriate method to publish the post
            $response = match ($mediaType) {
                // post an image if the brand post has images
                'image' => $fb->publishPhotoOnPage($platformId, $message, $media),
                // post a video if the brand post has videos
                'video' => $fb->publishVideoOnPage($platformId, $media[0], $message),
                // post text content if the brand post has no media
                default => $fb->publishTextOnPage($platformId, $message),
            };

            // set the publish response
            return $this->setPublishResponse($response);
        }

        /* Publish on Instagram */
        if ($socialPlatform == 'instagram') {
            // initialize the Instagram API class
            $instagram = new Instagram();
            // set the access token for the Instagram API class
            $instagram->setToken($accessToken);

            // check if the brand post has no media or more than 10 media
            if ($mediaType === null || count($media) == 0) {
                // cannot post text only content to Instagram
                return $this->setPublishResponse('Instagram doesn\'t support text only content yet');
            } elseif (count($media) > 10) {
                // cannot post more than 10 media at a time on Instagram
                return $this->setPublishResponse('Instagram doesn\'t support more than 10 media at a time');
            }

            // single post
            elseif (count($media) == 1) {
                $postData = [
                    // set the post content
                    'caption' => $message,
                ];

                // check if the brand post has images or videos
                switch ($mediaType) {
                    case 'image':
                        $postData['image_url'] = $media[0];
                        break;
                    case 'video':
                        $postData['media_type'] = 'REELS';
                        $postData['share_to_feed'] = true;
                        $postData['video_url'] = $media[0];
                        break;
                }

                // call the Instagram API to publish the post
                $response = $instagram->publishSingleMediaPost($platformId, $postData);

                // carousel post
            } elseif (count($media) > 1) {
                $response = $instagram->publishCarouselPost(
                    $platformId,
                    $media,
                    $mediaType,
                    $message
                );
            }

            // set the publish response
            return $this->setPublishResponse($response);
        }

        /* Publish on Twitter */
        if ($socialPlatform == 'twitter') {
            // initialize the Twitter API class
            $twitter = new Twitter();
            // set the access token for the Twitter API class
            $twitter->setToken($accessToken);

            // call the appropriate method to publish the post
            $response = match ($mediaType) {
                'image' => $twitter->publishMediaPost($media, $message),
                'video' => $twitter->publishMediaPost($media, $message, 'video'),
                default => $twitter->publishTweet($message),
            };

            if (!($response instanceof \Illuminate\Http\Client\Response)) {
                $response = json_decode(json_encode($response), true);
            }

            // set the publish response
            return $this->setPublishResponse($response);
        }

        /* Publish on Linkedin */
        if ($socialPlatform == 'linkedin') {
            // initialize the Linkedin API class
            $linkedin = new Linkedin();
            // set the access token for the Linkedin API class
            $linkedin->setToken($accessToken);

            // check if the brand post has images or videos
            switch ($mediaType) {
                case 'image':
                    $response = $linkedin->publishImage($platformId, $media, $message);
                    break;
                case 'video':
                    $videoPath = $media[0];
                    $absoluteUrl = parse_url($videoPath, PHP_URL_PATH);
                    $videoPath = str($absoluteUrl)->replaceFirst('/', '')->replace('/', DIRECTORY_SEPARATOR)->toString();

                    $response = $linkedin->publishVideo($platformId, $videoPath, $message);
                    break;
                default:
                    $response = $linkedin->publishText($platformId, $message);
                    break;
            }

            // set the publish response
            return $this->setPublishResponse($response);
        }

        /* Publish on Tiktok */
        if ($socialPlatform == 'tiktok') {
            // initialize the Tiktok API class
            $tiktok = new Tiktok();
            // set the access token for the Tiktok API class
            $tiktok->setToken($accessToken);

            // get the media and content for the brand post
            $title = $brandPost->slogan;

            $options = $postPlatform->data['options'] ?? [];

            throw_if(empty($options), 'Invalid option selected');


            // check if the brand post has no media
            if ($mediaType === null) {
                // cannot post text only content to Tiktok
                $response = 'Tiktok doesn\'t support text only content yet';
            } else if ($mediaType == 'video') {
                // post a video if the brand post has videos

                $postData = [
                    "post_info" => [
                        "title" => str($message)->limit(150)->toString(),
                        "privacy_level" => $options['privacy_level'] ?? config('platform.tiktok.options.privacy_level'),
                        "disable_duet" => $options['disable_duet'] ?? config('platform.tiktok.options.disable_duet'),
                        "disable_comment" => $options['disable_comment'] ?? config('platform.tiktok.options.disable_comment'),
                        "disable_stitch" => $options['disable_stitch'] ?? config('platform.tiktok.options.disable_stitch'),
                        "video_cover_timestamp_ms" => $options['video_cover_timestamp_ms'] ?? config('platform.tiktok.options.video_cover_timestamp_ms')
                    ],
                    "source_info" => [
                        "source" => "PULL_FROM_URL",
                        "video_url" => $media[0],
                    ]
                ];

                $response = $tiktok->postVideo($postData);
            } else if ($mediaType == 'image') {
                // post an image if the brand post has images

                $postData = [
                    'post_info' => [
                        'title' => str($title)->limit(90)->toString(),
                        'description' => str($message)->limit(4000)->toString(),
                        "privacy_level" => $options['privacy_level'] ?? config('platform.tiktok.options.privacy_level'),
                        "disable_comment" => $options['disable_comment'] ?? config('platform.tiktok.options.disable_comment'),
                        'auto_add_music' => $options['auto_add_music'] ?? config('platform.tiktok.options.auto_add_music')
                    ],
                    'source_info' => [
                        'source' => 'PULL_FROM_URL',
                        'photo_cover_index' => 0,
                        'photo_images' => collect($media)->take(35)->toArray()
                    ],
                    'post_mode' => 'DIRECT_POST',
                    'media_type' => 'PHOTO'
                ];

                $response = $tiktok->postPhoto($postData);
            }

            // set the publish response
            return $this->setPublishResponse($response);
        }

        // api not integrated yet for the selected platform
        return $this->setPublishResponse('api not integrated yet for:' . $socialPlatform);
    }

    public function setPublishResponse($response): self
    {
        $this->publishResponse = $response;
        return $this;
    }

    public function getPublishResult(): array
    {
        return $this->publishResult;
    }

    public function convertMediaUrlToLocalPath(array $media = []): array
    {

        $result = [];

        foreach ($media as $path) {
            $isLocalhost = parse_url($path, PHP_URL_HOST) == parse_url(request()->url(), PHP_URL_HOST);
            if ($isLocalhost) {
                $path = parse_url($path, PHP_URL_PATH);
                $result[] = public_path(str_replace('/', DIRECTORY_SEPARATOR, $path));
            } else {
                $filename = basename($path);
                $filePath = "temp/$filename";
                if (!Storage::disk('public')->exists($filePath)) {

                    $fileContent = Http::get($path);
                    Storage::disk('public')->put($filePath, $fileContent);
                }

                $result[] = Storage::url($filePath);
            }
        }

        return $result;
    }

    public function finalizeResponse(): array
    {
        $isPublished = false;
        $publishId = null;
        $error = null;

        $response = $this->publishResponse;

        if ($response instanceof \Illuminate\Http\Client\Response) {
            if ($response->successful()) {
                $publishId = match ($this->postPlatform->platform) {
                    'linkedin' => $response->header('x-restli-id'),
                    'tiktok' => $response->json('data.id'),
                    'twitter' => $response->json('data.id'),
                    default => $response->json('id'),
                };

                $this->postPlatform->update([
                    'post_id' => $publishId,
                    'user_platform_id' => $this->userPlatform->id,
                    'published_at' => now(),
                    'scheduled_at' => null,
                    'status' => 'published',
                    'data' => [
                        'message' => 'published successfully',
                    ],
                ]);
                $isPublished = true;
            } else {
                $error = match ($this->postPlatform->platform) {
                    'facebook' => $response->json('error.message'),
                    'instagram' => $response->json('error.error_user_msg'),
                    'twitter' => $response->json('title'),
                    'tiktok' => $response->json('error'),
                    default => $response->json(),
                };
            }
        } else if (is_array($response)) {
            $publishId = data_get($response, 'data.id');
            if ($publishId) {
                $this->postPlatform->update([
                    'post_id' => $publishId,
                    'user_platform_id' => $this->userPlatform->id,
                    'published_at' => now(),
                    'scheduled_at' => null,
                    'status' => 'published',
                ]);
                $isPublished = true;
            } else {
                $error = $response['title'] ?? 'Something went wrong, please try again.';
            }
        } else if (is_string($response)) {
            $error = $response;
        }

        if ($error || !$isPublished) {
            $this->postPlatform->update([
                'status' => 'failed',
                'post_id' => null,
                'published_at' => null,
                // 'scheduled_at' => null,
                'data' => [
                    'message' => $error,
                    'failed_at' => now()->toDayDateTimeString(),
                ]
            ]);
        }

        $this->publishResult = $this->postPlatform->toArray();

        return $this->getPublishResult();
    }
}
