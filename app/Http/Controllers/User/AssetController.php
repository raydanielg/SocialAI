<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssetController extends Controller
{
    use Uploader;

    public function index()
    {
        $assets = Asset::query()
            ->filterOn(['file_size', 'mime_type'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return Inertia::render('User/Assets', [
            'assets' => $assets,
        ]);
    }

    public function store(Request $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->validatePlan('storage_size');
        if ($request->hasFile('image')) {
            $mime_type = 'image';
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            ]);

            $assetPath = $this->saveFile($request, 'image');
        }

        if ($request->hasFile('video')) {
            $mime_type = 'video';
            $request->validate([
                'video' => 'required|max:10048|mimes:mp4',
            ]);
            $assetPath = $this->saveFile($request, 'video');
        }

        Asset::create([
            'user_id' => auth()->id(),
            'path' => $assetPath,
            'type' => 'uploaded',
            'mime_type' => $mime_type,
            'file_size' => $this->fileSizeInMB($assetPath),
        ]);
        return back();
    }

    public function update(Request $request, $uuid)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->validatePlan('image_editor');
        $asset = Asset::where('uuid', $uuid)->firstOrFail();
        if ($request->filled('image')) {
            $request->validate([
                'image' => 'required|string',
            ]);

            $assetPath = $this->saveFileFromUrl($request->image);
        }
        if ($request->saveType === 'replace') {
            $asset->update([
                'path' => $assetPath,
                'file_size' => $this->fileSizeInMB($assetPath),
            ]);
        }

        if ($request->saveType === 'copy') {
            $asset->create([
                'user_id' => auth()->id(),
                'path' => $assetPath,
                'type' => $asset->type,
                'mime_type' => 'image',
                'file_size' => $this->fileSizeInMB($assetPath),
            ]);
        }
        return redirect()->route('user.assets.index')->with('info', 'Updated Successfully');
    }

    public function destroy(Asset $asset)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $this->removeFile($asset->path);
        $asset->delete();
        return back();
    }
}
