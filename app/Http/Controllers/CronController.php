<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Services\Tiktok;
use App\Models\BrandPost;
use App\Services\Twitter;
use App\Services\Facebook;
use App\Services\Linkedin;
use App\Services\Instagram;
use App\Models\UserPlatform;
use App\Traits\Notifications;
use App\Mail\RefreshTokenFailMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\PostPublisherService;
use App\Http\Controllers\User\BrandPostController;
use App\Models\BrandPostPlatform;

class CronController extends Controller
{
    use Notifications;


    /**
     * notify to subscribers before expire the subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function notifyToUser()
    {
        $willExpire = today()->addDays(7)->format('Y-m-d');
        $users = User::whereHas('subscription')->with('subscription')->where('will_expire', $willExpire)->latest()->get();

        foreach ($users as $key => $user) {
            $this->sentWillExpireEmail($user);
        }

        return "Cron job executed";
    }

    public function refreshPlatformTokens()
    {
        $add24hFromNow = now()->addDay()->format('Y-m-d h:i:s');

        /**
         * @var \App\Models\UserPlatform[] $platforms
         */
        $platforms = UserPlatform::query()
            ->with('user')
            ->where('access_token_expire_at', '<=', $add24hFromNow)
            ->get();


        foreach ($platforms as $platform) {
            $isSuccess = $this->refreshAccessToken($platform);

        }
        return $platforms;
    }

    private function refreshAccessToken(UserPlatform $platform)
    {
        $accessToken = $platform->refresh_token ?? $platform->access_token;
        $platformName = $platform->platform;

        if ($platformName == 'facebook') {
            $facebook = new Facebook(accessToken: $accessToken);
            $response = $facebook->refreshAccessToken($accessToken);

            if ($response->successful()) {
                $newAccessToken = $response->json('access_token');
                $platform->update([
                    'access_token' => $newAccessToken,
                    'access_token_expire_at' => now()->addMonths(2)
                ]);
                return true;
            }
        }
        if ($platformName == 'instagram') {
            $instagram = new Instagram(accessToken: $accessToken);
            $response = $instagram->refreshAccessToken($accessToken);
            if ($response->successful()) {
                $tokenData = $response->json();
                $platform->update([
                    'access_token' => $tokenData['access_token'],
                    'access_token_expire_at' => now()->addMonths(2)
                ]);
            }
        }
        if ($platformName == 'twitter') {
            $twitter = new Twitter(accessToken: $accessToken);
            $response = $twitter->refreshAccessToken($accessToken);
            if ($response->successful()) {
                $platform->update([
                    'access_token' => $response->json('data.access_token'),
                    'access_token_expire_at' => now()->addMonths(2),

                    'refresh_token' => $response->json('data.refresh_token'),
                    'refresh_token_expire_at' => now()->addMonths(2),
                ]);
                return true;
            }
        }
        if ($platformName == 'linkedin') {
            $linkedin = new Linkedin(accessToken: $accessToken);
            $response = $linkedin->refreshAccessToken($accessToken);
            if ($response->successful()) {
                $tokenData = $response->json();
                $platform->update([

                    'access_token' => $tokenData['access_token'],
                    'access_token_expire_at' => now()->seconds($tokenData['expires_in']),

                    'refresh_token' => $tokenData['refresh_token'],
                    'refresh_token_expire_at' => now()->seconds($tokenData['refresh_token_expires_in']),
                ]);
                return true;
            }
        }
        if ($platformName == 'tiktok') {
            $tiktok = new Tiktok(accessToken: $accessToken);
            $response = $tiktok->refreshAccessToken($accessToken);
            if ($response->successful()) {
                $tokenData = $response->object();
                $platform->update([
                    'access_token' => $tokenData->access_token ?? '',
                    'access_token_expire_at' => now()->addSeconds($tokenData->expires_in ?? 0),

                    'refresh_token' => $tokenData->refresh_token ?? $tokenData->access_token ?? '',
                    'refresh_token_expire_at' => now()->addSeconds($tokenData->refresh_expires_in ?? 0),
                ]);
                return true;
            }
        }


        return false;
    }
    private function sendRefreshTokenFailNotifyEmail(UserPlatform $platform)
    {
        $userMail = $platform->user?->email ?? null;

        if ($platform->failed_mail_send_at == null || $platform->failed_mail_send_at->addWeek()->isPast()) {
            if ($userMail) {
                $queue = Mail::to($userMail)
                    ->queue(
                        new RefreshTokenFailMail(
                            platformName: $platform->platform
                        )
                    );

                $platform->update([
                    'failed_mail_send_at' => now()
                ]);

                return $queue;
            }
        }

        return false;
    }

    public function dispatchSchedulePosts()
    {
        ini_set('max_execution_time', 0);

        $today = Carbon::now();
        $now = Carbon::parse($today)->tz(env('TIME_ZONE', 'UTC'));

        $brandPosts = BrandPost::query()
            ->whereHas('platforms', function ($query) use ($now) {
                $query
                    ->whereIn('status', ['scheduled'])
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '<=', $now)
                    ->whereNull(['post_id', 'published_at']);
            })
            ->get();

        $publishResult = collect([]);
        foreach ($brandPosts as $brandPost) {

            $brandPostPlatforms = $brandPost
                ->platforms
                ->whereIn('status', ['scheduled'])
                ->where('scheduled_at', '<=', $now)
                ->whereNotNull('scheduled_at')
                ->whereNull(['post_id', 'published_at']);

            foreach ($brandPostPlatforms as $platform) {

                if (in_array($platform->status, ['publishing']))
                    continue;

                try {

                    DB::beginTransaction();
                    $platform->update([
                        'status' => 'publishing'
                    ]);

                    $result = $this->publishPost($platform);

                    $publishResult->push($result);

                    DB::commit();

                } catch (\Exception $exception) {
                    DB::rollBack();

                    $platform->update([
                        'status' => 'failed',
                        'message' => $exception->getMessage()
                    ]);
                }
            }

            $brandPost->update([
                'status' => 'published',
            ]);
        }

        $publishSummery = [
            'total_executed' => $publishResult->count(),
            'published' => $publishResult->where('status', 'published')->count(),
            'failed' => $publishResult->where('status', 'failed')->count(),
        ];

        return response()->json($publishSummery);
    }

    public function cleanupTemporaryBrandPostData()
    {
        // delete all files from public/temp
        $files = glob(public_path('temp') . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        Log::info('Cleanup temporary files');
    }

    private function publishPost(BrandPostPlatform $platform): array
    {

        $brandPost = $platform->brandPost;
        $userPlatform = $platform->userPlatform;

        // check if all exists
        if (!$brandPost || !$userPlatform) {
            $platform->update([
                'status' => 'failed',
                'data' => [
                    'failed_at' => now()->toDateTimeLocalString(),
                    'message' => 'Post or user platform not found',
                ]
            ]);

            return [
                'status' => 'failed',
                'data' => [
                    'failed_at' => now()->toDateTimeLocalString(),
                    'message' => 'Post or user platform not found',
                ]
            ];
        }

        $postPublisher = new PostPublisherService(
            $brandPost,
            $platform,
            $userPlatform
        );

        return $postPublisher->publish()->finalizeResponse();
    }
}
