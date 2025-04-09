<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Services\TwitterService;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\BrandPost;
use App\Models\AiGenerate;
use App\Models\UserPlatform;
use Illuminate\Support\Carbon;
use App\Models\BrandPostPlatform;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $user = User::with('plan')->findOrFail(auth()->id());

        $brands = Brand::query()
            ->where('user_id', $user->id)->get();
        $totalPosts = BrandPost::query()
            ->where('user_id', $user->id)->count();
        // likes,comment,storage,credits,social_accounts
        $totalReactions = BrandPostPlatform::query()
            ->whereHas('brandPost', function ($query) {
                $query->where('user_id', auth()->id());
            })->sum('reactions');
        $totalComments = BrandPostPlatform::query()
            ->whereHas('brandPost', function ($query) {
                $query->where('user_id', auth()->id());
            })->sum('comments');

        $totalStorage = Asset::query()
            ->where('user_id', $user->id)->sum('file_size');
        $socialAccounts = UserPlatform::query()
            ->where('user_id', $user->id)->count();
        $totalCredits = AiGenerate::query()
            ->where('user_id', $user->id)->sum('charge');

        // schedule calendar

        $startDate = now()->createFromDate(request('start_at') ?? today());
        $weekStartDate = $startDate->clone()->startOfWeek(Carbon::SUNDAY);
        $weekEndDate = $startDate->clone()->endOfWeek(Carbon::SATURDAY);

        $schedulePosts = BrandPostPlatform::query()
            ->whereHas('brandPost', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('brandPost')
            ->scheduled()
            ->whereBetween('scheduled_at', [$weekStartDate, $weekEndDate])
            ->limit(10)
            ->get();


        $contents = BrandPost::query()
            ->with(['platforms:id,brand_post_id,platform,published_at,media_type,status,data', 'brand:id,name'])
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->take(10)
            ->get();

        return Inertia::render('User/Dashboard', [
            'user' => $user,
            'contents' => $contents,
            'schedulePosts' => $schedulePosts,
            'totalBrands' => $brands->count(),
            'totalPosts' => $totalPosts,
            'totalReactions' => $totalReactions,
            'totalComments' => $totalComments,
            'totalStorage' => $totalStorage,
            'socialAccounts' => $socialAccounts,
            'totalCredits' => $totalCredits,
            'brands' => $brands
        ]);
    }
}
