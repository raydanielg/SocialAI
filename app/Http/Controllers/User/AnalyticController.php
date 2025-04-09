<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use App\Services\Tiktok;
use App\Services\Toastr;
use App\Services\Twitter;
use App\Services\Facebook;
use App\Services\Instagram;
use App\Helpers\PlanPerks;
use App\Models\BrandPostPlatform;
use App\Http\Controllers\Controller;

class AnalyticController extends Controller
{

    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->validatePlan('analytics');

        $posts = BrandPostPlatform::query()
            ->with(['brandPost','brandPost.platforms'])
            ->whereHas('brandPost', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereNotNull('post_id')
            ->latest()
            ->filterOn(['platform', 'content']);

        $totalPost = $posts->clone()->count();
        $totalReactions = $posts->clone()->sum('reactions');
        $totalComments = $posts->clone()->sum('comments');

        if (request('refresh')) {
            $this->refreshAnalytics();
            $this->refreshTiktokAnalytics();
            Toastr::success('Refreshed successfully');
            return to_route('user.analytics.index');
        }

        return Inertia::render('User/Analytics', [
            'posts' => $posts->latest()->paginate(),
            'segments' => request()->segments(),
            'buttons' => [],
            'totalPost' => $totalPost,
            'totalReactions' => $totalReactions,
            'totalComments' => $totalComments,
        ]);
    }

    protected function refreshAnalytics()
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $error = PlanPerks::checkPlan('analytics');
        if ($error['status'] == 'danger') {
            return to_route('user.dashboard')->with($error['status'], $error['message']);
        }

        $posts = BrandPostPlatform::query()
            ->with('brandPost')
            ->whereHas('brandPost', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereNotNull('post_id')
            ->get();

        $facebook = new Facebook();
        $instagram = new Instagram();
        $twitter = new Twitter();

        foreach ($posts as $post) {
            $accessToken = $post->userPlatform?->access_token;
            if (!$accessToken)
                continue;

            switch ($post->platform) {
                case 'facebook':
                    $facebook->setToken($accessToken);
                    $response = $facebook->getPostAnalytics($post->post_id, ['likes.summary(true),comments.summary(true)']);
                    if ($response->successful()) {
                        $post->reactions = $response->json('likes.summary.total_count', 0);
                        $post->comments = $response->json('comments.summary.total_count', 0);
                    }
                    break;
                case 'instagram':
                    $instagram->setToken($accessToken);
                    $response = $instagram->getPostAnalytics($post->post_id, ['like_count', 'comments_count']);
                    if ($response->successful()) {
                        $post->reactions = $response->json('like_count', 0);
                        $post->comments = $response->json('comments_count', 0);
                    }
                    break;
                case 'twitter':
                    $twitter->setToken($accessToken);
                    $response = $twitter->getPostAnalytics($post->post_id);
                    if ($response->successful()) {
                        $post->reactions = $response->json('favorite_count', 0);
                        $post->comments = $response->json('retweet_count', 0);
                    }
                    break;
            }

            $post->save();
        }
    }

    protected static function refreshTiktokAnalytics()
    {

        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $accessToken = $user->platforms()->where('platform', 'tiktok')->value('access_token');
        if (!$accessToken) {
            return;
        }

        $posts = BrandPostPlatform::query()
            ->whereHas('brandPost', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('platform', 'tiktok')
            ->orWhereNotNull('post_id')
            ->get();

        $tiktok = new Tiktok();
        $tiktok->setToken($accessToken);
        $postIds = $posts->pluck('post_id')->toArray();
        $response = $tiktok->getPostAnalytics($postIds, ['id,title,like_count,comment_count,share_count,view_count']);


        if ($response->successful()) {
            $response->collect('data.videos')->each(function ($video) use ($posts) {
                $post = $posts->where('post_id', $video['id'])->first();
                if ($post) {
                    $post->update([
                        'reactions' => $video['like_count'],
                        'comments' => $video['comment_count'],
                    ]);
                }
            });
        }
    }
}
