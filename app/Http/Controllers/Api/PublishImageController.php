<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class PublishImageController extends Controller
{
    use Uploader;

    public function process_image(Request $request)
    {
        $requestImage = $request->image;
        if ($request->type == 'stock') {
            $response = Http::get($requestImage)->body();
            $requestImage = $this->saveFileFromUrl('', '.jpg', $response);
        }
        $originalPath = public_path(parse_url($requestImage, PHP_URL_PATH));

        if (!file_exists($originalPath)) {
            return response()->json(['error' => 'Image does not exist']);
        }
        $resizedFileName = uniqid() . '.' . pathinfo(parse_url($requestImage, PHP_URL_PATH), PATHINFO_EXTENSION);

        $resizedPath = public_path('uploads/' . $resizedFileName);

        // Use absolute path instead of URL
        $image = Image::read($originalPath)->cover(1024, 1024);

        $image->save($resizedPath);

        return response()->json(['image' => '/uploads/' . $resizedFileName]);
    }
}
