<?php

namespace App\Http\Controllers\Admin\UserLogs;

use App\Models\Asset;
use App\Helpers\PageHeader;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function index()
    {
        $assetQuery = Asset::query()->with(['user'])->latest();

        PageHeader::set()->title("User Assets")
            ->overviews([
                [
                    'value' => $assetQuery->clone()->count(),
                    'title' => __('Total'),
                    'icon' => 'bx-grid-alt',
                ],
                [
                    'value' => $assetQuery->clone()->where('mime_type', 'image')->count(),
                    'title' => __('Images'),
                    'icon' => 'bx-image',
                ],
                [
                    'value' => $assetQuery->clone()->where('mime_type', 'video')->count(),
                    'title' => __('Videos'),
                    'icon' => 'bx-video',
                ],
                [
                    'value' => $assetQuery->clone()->where('mime_type', 'document')->count(),
                    'title' => __('Documents'),
                    'icon' => 'bx-file',
                ],
            ]);


        return inertia('Admin/UserLog/Asset/Index', [
            'assets' => $assetQuery->paginate(),
            'countTotal' => $assetQuery->count(),
        ]);
    }

    public function destroy(Asset $asset)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $asset->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
