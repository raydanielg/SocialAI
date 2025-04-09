<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageEditorController extends Controller
{
    public function edit($uuid)
    {
        /**
         * @var \App\Models\User
         */
        $user = auth()->user();
        $user->validatePlan('image_editor');

        $shapes = [];
        $dir = public_path('assets/shapes');
        $folders = array_diff(scandir($dir), ['.', '..']);
        foreach ($folders as $folder) {
            $path = $dir . '/' . $folder;
            if (is_dir($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                $shapes[$folder] = $files;
            }
        }
        $image = Asset::query()->where('mime_type', 'image')
            ->where('uuid', $uuid)
            ->firstOrFail();
        return Inertia::render('User/ImageEditor/Edit', [
            'image' => $image,
            'shapes' => $shapes,
        ]);
    }
}
