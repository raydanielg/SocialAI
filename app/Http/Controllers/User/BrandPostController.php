<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\Design;
use App\Models\Prompt;
use App\Services\Toastr;
use App\Traits\Uploader;
use Carbon\CarbonPeriod;
use App\Models\BrandPost;
use App\Services\BrandAi;
use Illuminate\Support\Str;
use App\Models\UserPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\BrandPostPlatform;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PostPublisherService;
use Illuminate\Support\Facades\Auth;

class BrandPostController extends Controller
{
    use Uploader;

    /**
     * Retrieves the user's brand posts and scheduled items for the current week.
     *
     * @return \Inertia\Response The rendered view with the user's brand posts, scheduled items, and week details.
     */
    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        $hasBrand = boolval($user->brand()->count());

        $contents = BrandPost::query()
            ->latest()
            ->where('user_id', $user->id)
            ->filterOn(['title', 'status'])
            ->with(['platforms:id,brand_post_id,platform,published_at,media_type,status,data', 'brand:id,name'])
            ->paginate(11);


        $startDate = now()->createFromDate(request('start_at') ?? today());
        $weekStartDate = $startDate->clone()->startOfWeek(Carbon::SUNDAY);
        $weekEndDate = $startDate->clone()->endOfWeek(Carbon::SATURDAY);
        $weekDates = CarbonPeriod::between($weekStartDate, $weekEndDate)->toArray();

        $scheduledItems = $user->brandPosts()
            ->whereHas('platforms', function ($query) use ($weekStartDate, $weekEndDate) {
                $query;
            })
            ->get();

        $items = collect($weekDates)->map(function ($date) use ($scheduledItems) {
            return [
                'date' => Carbon::make($date)->format('D, M d'),
                'contents' => $scheduledItems->map(function ($brandPost) use ($date) {
                    $contents = $brandPost->platforms()->with('brandpost:id,uuid,created_at')->whereDate('scheduled_at', $date)->get();
                    return $contents->count() ? $contents : null;
                })
                    ->filter()
                    ->flatten()
                    ->values()
            ];
        });

        $totalBrandPost = $user->brandPosts()->count();
        $brands = Brand::query()
            ->where('user_id', $user->id)->get();

        return Inertia::render('User/Content/Index', [
            'hasBrand' => $hasBrand,
            'contents' => $contents,
            'scheduledItems' => $scheduledItems,
            'items' => $items,
            'weekStartDate' => $weekStartDate,
            'weekEndDate' => $weekEndDate,
            'totalBrandPost' => $totalBrandPost,
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the brand is not found.
     */
    public function store(Request $request)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        if (env('DEMO_MODE') && $user->id == 3) {
            return back()->with('danger', __('Permission disabled for demo mode..! Create new account to use this feature.'));
        }
        $user->validatePlan('posts');

        $data = $request->validate([
            'title' => 'required|string',
            'input' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image',
        ], [
            'brand_id.required' => 'Select Brand',
        ]);


        $brand = Brand::query()
            ->where('id', $data['brand_id'])->where('user_id', $user->id)
            ->firstOrFail();

        $categories = $brand->categories->pluck('name')->toArray();
        $brandAi = new BrandAi($categories, $data['input'], $brand);
        $data['image'] = url('/assets/images/ai_demo.jpeg');
        if ($request->hasFile('image') && !env('DEMO_MODE', false)) {
            $uploadedFile = $this->uploadFile('image');
            $data['image'] = [$uploadedFile];
           
            Asset::create([
                'user_id' => Auth::id(),
                'path' => $data['image'][0],
                'type' => 'uploaded',
                'mime_type' => 'image',
                'file_size' => $this->fileSizeInMB($uploadedFile),
            ]);
        } else {
            $image = $brandAi->image();
            $data['image'] = is_array($image) ? $image : [$image];
        }
        DB::beginTransaction();
        $brandPost = $user->brandPosts()
            ->create([
                'title' => $data['title'],
                'input' => $data['input'],
                'brand_id' => $data['brand_id'],
            ]);

        $appPlatforms = activePlatforms()->filter()->keys();

        $platformContent = $brandAi->posts($appPlatforms[0], $brandPost->id);
        foreach ($appPlatforms as $platform) {

            if (env('AI_MOCK_DATA', false)) {
                $platformContent = "$platformContent for $platform";
            }

            $brandPost->platforms()->create([
                'platform' => $platform,
                'content' => $platformContent,
                'media' => $data['image'] ?: null,
                'media_type' => $data['image'] ? 'image' : null,
                'published_at' => null,
                'post_id' => null,
                'reactions' => 0,
                'comments' => 0,
            ]);
        }
        DB::commit();

        return to_route('user.publish', $brandPost);
    }

    /**
     * Display the specified BrandPost.
     *
     * @param BrandPost $brandPost The BrandPost to be displayed.
     * @return \Inertia\Response The rendered Inertia response.
     */
    public function show(BrandPost $brandPost)
    {

        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        $platformNames = activePlatforms()->filter()->keys();


        $brandPost->load('brand', 'platforms');

        $isPublished = $brandPost->platforms
            ->whereNotNull('post_id')
            ->whereNotNull('published_at')
            ->where('status', 'published')
            ->count();

        if ($isPublished) {
            $brandPost->update([
                'status' => 'published'
            ]);
        }

        $uploadedAssetImages = Asset::query()
            ->where('user_id', $user->id)
            ->where('type', 'uploaded')
            ->where('mime_type', 'image')
            ->latest()
            ->paginate(12);

        $generatedAssetImages = Asset::query()
            ->where('user_id', $user->id)
            ->where('type', 'generated')
            ->where('mime_type', 'image')
            ->latest()
            ->paginate(12);

        $uploadedAssetVideos = Asset::query()
            ->where('user_id', $user->id)
            ->where('type', 'uploaded')
            ->where('mime_type', 'video')
            ->latest()
            ->paginate(12);

        $generatedAssetVideos = Asset::query()
            ->where('user_id', $user->id)
            ->where('type', 'generated')
            ->where('mime_type', 'video')
            ->latest()
            ->paginate(12);

        $designs = Design::query()->get();

        $isVideoPromptActive = Prompt::where('prompt_type', 'video')->where('status', 'active')->exists();


        // TODO: trim the props here

        return Inertia::render('User/Publish/Index', [
            'content' => $brandPost,
            'uploadedAssetImages' => $uploadedAssetImages,
            'generatedAssetImages' => $generatedAssetImages,
            'uploadedAssetVideos' => $uploadedAssetVideos,
            'generatedAssetVideos' => $generatedAssetVideos,
            'userPlatforms' => $user->platforms,
            'platforms' => $platformNames,
            'designs' => $designs,
            'isVideoPromptActive' => $isVideoPromptActive
        ]);
    }

    /**
     * Updates a BrandPost based on the provided request and returns a redirect response or an array.
     *
     * @param Request $request The HTTP request object containing the updated BrandPost data.
     * @param BrandPost $brandPost The existing BrandPost to be updated.
     * @return \Illuminate\Http\RedirectResponse|array The redirect response or an array containing the updated BrandPost data.
     */
    public function update(Request $request, BrandPost $brandPost): \Illuminate\Http\RedirectResponse|array
    {
        $request->validate([
            'status' => ['required', Rule::in(['draft', 'schedule', 'publish', 'save_and_publish'])],
        ]);

        $newBrandPost = (object) $request->newBrandPost;

        return match ($request->input('status')) {
            'draft' => $this->saveAsDraft($brandPost, $newBrandPost),
            'schedule' => $this->scheduleBrandPost($brandPost, $newBrandPost),
            'publish' => $this->publishNow($brandPost, $newBrandPost),
            'save_and_publish' => $this->saveAndPublish($brandPost, $newBrandPost),
        };
    }

    /**
     * Saves the given BrandPost as a draft.
     *
     * @param BrandPost $oldBrandPost The existing BrandPost to be updated
     * @param object $newBrandPost The new BrandPost object containing the updated data
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page
     */
    private function saveAsDraft(BrandPost $oldBrandPost, object $newBrandPost, bool $showAlert = true)
    {
        if (env('DEMO_MODE')) {
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        DB::transaction(function () use ($oldBrandPost, $newBrandPost) {
            $oldBrandPost->update([
                'input' => $newBrandPost->input,
                'title' => $newBrandPost->title,
                'slogan' => $newBrandPost->slogan,
                'status' => 'draft',
            ]);

            $oldBrandPost->platforms->each(function ($platform) use ($newBrandPost) {
                $updatedPlatform = collect($newBrandPost->platforms)->where('platform', $platform->platform);

                if (!$updatedPlatform->count())
                    return;

                $medias = $this->processMedia($updatedPlatform->value('media', []), $updatedPlatform->value('media_type'));
                $newPlatformData = [
                    'content' => $updatedPlatform->value('content'),
                    'media_type' => empty($medias) ? null : $updatedPlatform->value('media_type') ?? $updatedPlatform->value('media_type'),
                    'media' => $medias,
                ];

                $platform->update($newPlatformData);
            });

            // create newly added platforms
            $newPlatforms = collect($newBrandPost->platforms)->whereNotIn('platform', $oldBrandPost->platforms->pluck('platform'));
            $newPlatforms->each(function ($platform) use ($oldBrandPost) {
                $oldBrandPost->platforms()->create([
                    'platform' => $platform['platform'],
                    'content' => $platform['content'],
                    'media_type' => $platform['media_type'] ?? null,
                    'media' => $this->processMedia($platform['media'] ?? [], $platform['media_type'] ?? null),
                ]);
            });
        });

        if ($showAlert) {
            Toastr::success('Saved successfully');
        }
        return back();
    }

    private function processMedia(array $media = [], ?string $mediaType = 'image')
    {
        return collect($media)
            ->map(function ($mediaPath) use ($mediaType) {
                $isBase64 = is_string($mediaPath) && Str::startsWith($mediaPath, 'data:');
                $isStock = is_string($mediaPath) && in_array(parse_url($mediaPath)['host'] ?? '', ['images.unsplash.com', 'videos.pexels.com']);

                if ($isBase64 || $isStock) {
                    $mediaPath = $isBase64 ? $this->storeBase64Media($mediaPath) : $this->storeStockMedia($mediaPath);
                    Asset::create([
                        'user_id' => Auth::id(),
                        'path' => $mediaPath,
                        'type' => 'uploaded',
                        'mime_type' => $mediaType,
                        'file_size' => $this->fileSizeInMB($mediaPath),
                    ]);
                }
                return $mediaPath;
            })->toArray();
    }

    /**
     * Schedules a brand post.
     *
     * @param BrandPost $brandPost The brand post to be scheduled.
     * @param object $newBrandPost The new brand post object.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    private function scheduleBrandPost(BrandPost $brandPost, object $newBrandPost): \Illuminate\Http\RedirectResponse
    {
        request()->validate(
            [
                'newBrandPost.scheduled_at' => ['required', 'after:today'],
                'user_platforms' => ['required', 'array'],
                'timezone' => ['required'],
            ],
            [],
            [
                'newBrandPost.scheduled_at' => 'schedule date'
            ]
        );

        $timeZone = request()->get('timezone', config('app.timezone'));
        $scheduleDate = date('Y-m-d H:i:s', strtotime($newBrandPost->scheduled_at));
        $systemScheduleTime = Carbon::createFromFormat('Y-m-d H:i:s', $scheduleDate, $timeZone);
        $systemScheduleTime = $systemScheduleTime->copy()->tz(config('app.timezone'));

        DB::transaction(function () use ($brandPost, $newBrandPost, $systemScheduleTime) {
            $brandPost->update([
                'input' => $newBrandPost->input,
                'title' => $newBrandPost->title,
                'slogan' => $newBrandPost->slogan,
                'status' => 'published',
            ]);

            $userPlatforms = request()->collect('user_platforms');
            $selectedPlatforms = $brandPost->platforms()
                ->whereIn('platform', $userPlatforms->pluck('platform')->toArray())
                ->whereIn('status', ['draft', 'failed'])
                ->get();

            if ($selectedPlatforms->isEmpty()) {
                Toastr::info('Selected platforms aren\'t able to be scheduled');
                return back();
            } else {

                foreach ($selectedPlatforms as $platform) {
                    $updatedPlatform = collect($newBrandPost->platforms)->where('platform', $platform->platform);
                    $newPlatformData = [
                        'user_platform_id' => $userPlatforms->where('platform', $platform->platform)->value('id'),
                        'content' => $updatedPlatform->value('content'),
                        'media_type' => $updatedPlatform->value('media_type'),
                        'media' => $updatedPlatform->value('media'),
                        'scheduled_at' => $systemScheduleTime,
                        'status' => 'scheduled',
                        // resetter
                        'post_id' => null,
                        'reactions' => 0,
                        'comments' => 0,
                        'published_at' => null,
                        'data' => [
                            'message' => 'Scheduled at ' . $systemScheduleTime->format('d-M-Y H:i:s'),
                        ],
                    ];

                    $platform->update($newPlatformData);
                    Toastr::success(__('Scheduled successfully'));
                }
            }
        });

        return back();
    }

    /**
     * Publishes the given BrandPost immediately.
     *
     * @param BrandPost $brandPost The BrandPost to be published.
     * @throws \Throwable If an error occurs during the publishing process.
     * @return array The result of the publishing process.
     */
    private function publishNow(BrandPost $brandPost, object $newBrandPost): array
    {
        request()->validate([
            'platform_id' => ['required', 'exists:user_platforms,id'],
        ]);

        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        $userPlatform = $user->platforms()->findOrFail(request()->get('platform_id'));
        $brandPostPlatform = $brandPost->platforms()->where('platform', $userPlatform->platform)->firstOrFail();
        if ($userPlatform->platform === 'tiktok') {
            $brandPostPlatform->update([
                'data' => [
                    'options' => $newBrandPost->tiktokOptions ?? []
                ]
            ]);
        }

        try {

            if ($brandPostPlatform->status === 'published') {
                $brandPostPlatform->update([
                    'data' => [
                        'message' => trans('Published successfully'),
                    ],
                ]);
                $publishResult = $brandPostPlatform->toArray();
            } else {
                $publishResult = $this->publishBrandPost($brandPost, $brandPostPlatform, $userPlatform);
            }
        } catch (\Throwable $th) {
            $brandPostPlatform->update([
                'status' => 'failed',
                'data' => [
                    'failed_at' => now()->toDayDateTimeString(),
                    'message' => $th->getMessage(),
                ]
            ]);

            $publishResult = $brandPostPlatform->toArray();
        }

        return $publishResult;
    }

    /**
     * Saves the brand post as draft and then publishes it.
     *
     * @param BrandPost $brandPost The brand post to save and publish
     * @param object $newBrandPost The new brand post object
     * @return array The result of publishing the brand post
     */
    private function saveAndPublish(BrandPost $brandPost, object $newBrandPost): array
    {
        $this->saveAsDraft($brandPost, $newBrandPost, false);
        return $this->publishNow($brandPost, $newBrandPost);
    }

    /**
     * Publishes a brand post with the given BrandPost and BrandPostPlatform.
     *
     * @param BrandPost $brandPost The BrandPost to be published.
     * @param BrandPostPlatform $platform The platform to publish the BrandPost to.
     * @return array The result of the publishing process.
     */
    private function publishBrandPost(BrandPost $brandPost, BrandPostPlatform $postPlatform, UserPlatform $userPlatform): array
    {
        $postPublisher = new PostPublisherService($brandPost, $postPlatform, $userPlatform);
        return $postPublisher->publish()->finalizeResponse();
    }


    /**
     * Deletes a brand post and its associated platforms, and updates the brand post's schedule information.
     *
     * @param int $id The ID of the brand post to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the brand post with the given ID is not found.
     */
    public function destroy($id)
    {
        $brandPost = BrandPost::findOrFail($id);
        $brandPost->platforms()->delete();
        $brandPost->update([
            "is_schedule" => false,
            "scheduled_at" => null,
            "status" => "draft"
        ]);

        Toastr::success('Brand post schedule removed successfully');
        return back();
    }

    public function removeSchedule(BrandPostPlatform $brandPostPlatform)
    {
        $brandPostPlatform->update([
            'status' => 'draft',
            'post_id' => null,
            'published_at' => null,
            'scheduled_at' => null,
            'data' => [
                'removed_at' => now()->toDayDateTimeString(),
                'message' => 'Schedule Removed successfully',
            ]
        ]);

        Toastr::success('Schedule Removed successfully');
        return back();
    }
}
