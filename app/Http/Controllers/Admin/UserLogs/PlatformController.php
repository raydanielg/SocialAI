<?php

namespace App\Http\Controllers\Admin\UserLogs;

use App\Models\UserPlatform;
use App\Helpers\PageHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlatformController extends Controller
{
    public function index()
    {
        $platformQuery = UserPlatform::query()->with(['user'])->latest();

        PageHeader::set()->title("User Platforms")
            ->overviews([
                [
                    'value' => $platformQuery->clone()->where('platform', 'facebook')->count(),
                    'title' => __('Facebook'),
                    'icon' => 'bxl-facebook-circle',
                ],
                [
                    'value' => $platformQuery->clone()->where('platform', 'instagram')->count(),
                    'title' => __('Instagram'),
                    'icon' => 'bxl-instagram-alt',
                ],
                [
                    'value' => $platformQuery->clone()->where('platform', 'twitter')->count(),
                    'title' => __('Twitter'),
                    'icon' => 'bxl-twitter',
                ],
                [
                    'value' => $platformQuery->clone()->where('platform', 'linkedin')->count(),
                    'title' => __('Linkedin'),
                    'icon' => 'bxl-linkedin',
                ],
                [
                    'value' => $platformQuery->clone()->where('platform', 'tiktok')->count(),
                    'title' => __('Tiktok'),
                    'icon' => 'bxl-tiktok',
                ],
            ]);
        return inertia('Admin/UserLog/Platform/Index', [
            'platforms' => $platformQuery->paginate(),
            'countTotal' => $platformQuery->count(),
        ]);
    }

    public function destroy(UserPlatform $userPlatform)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $userPlatform->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
