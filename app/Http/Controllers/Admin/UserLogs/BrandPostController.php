<?php

namespace App\Http\Controllers\Admin\UserLogs;

use App\Models\BrandPost;
use App\Helpers\PageHeader;
use App\Http\Controllers\Controller;

class BrandPostController extends Controller
{
    public function index()
    {
        PageHeader::set()->title("User Brand Posts");

        $posts = BrandPost::query()->with(['user','brand:id,name'])->latest()->paginate();

        return inertia('Admin/UserLog/BrandPost/Index', [
            'posts' => $posts,
            'countTotal' => BrandPost::query()->count(),
            'countUnpublished' => BrandPost::query()->where('status', 'draft')->count(),
            'countPublished' => BrandPost::query()->where('status', 'published')->count(),
        ]);
    }

    public function destroy(BrandPost $brand_post)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brand_post->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
