<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Uploader
{

    //upload file
    private function saveFile(Request $request, $input, $absolutePath = false)
    {
        $file = $request->file($input);
        $ext = $file->extension();
        $filename = Str::random(20) . '.' . $ext;

        $path = 'uploads' . date('/y') . '/' . date('m');

        if (env('APP_ENV') == 'demo') {
            $path = 'demo';
        }

        $filePath = "$path/$filename";

        Storage::put($filePath, file_get_contents($file));

        $url = Storage::url($filePath);

        if ($absolutePath || env('APP_ENV') == 'demo') {
            return '/' . parse_url($filePath, PHP_URL_PATH);
        }
        return $url;
    }
    //upload file from url/link
    private function saveFileFromUrl($url, $ext = '.png', $file = '', $type = 'image')
    {
        if (empty($file)) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "Accept-language: en\r\n"
                ]
            ]);
            $file = fopen($url, 'r', false, $context);
        }
        $filename = $type . '_' . uniqid() . $ext;

        $filePath = "uploads/$filename";
        Storage::put($filePath, $file);

        return Storage::url($filePath);
    }

    //remove file
    public function removeFile($url = null)
    {
        if (empty($url)) {
            return true;
        }

        $fileName = explode('uploads', $url);
        if (isset($fileName[1])) {
            $exists_file = "uploads$fileName[1]";
            if (Storage::exists($exists_file)) {
                Storage::delete($exists_file);
            }
            return true;
        }

        return false;
    }

    private function uploadFile($input, $fallback = null): string|null
    {
        $file = $input;

        if (!($input instanceof UploadedFile)) {
            if (!request()->hasFile($input))
                return $fallback;
            $file = request()->file($input);
        }

        $ext = $file->extension();
        $filename = Str::random(20) . '.' . $ext;
        $path = 'uploads' . date('/y') . '/' . date('m');

        if (env('APP_ENV') == 'demo') {
            $path = 'demo';
        }

        $filePath = "/$path/$filename";
        Storage::put($filePath, file_get_contents($file));
        return Storage::url($filePath);
    }

    public function unlinkPublicFile(string $url = null): void
    {
        if ($url) {
            $file_url = public_path($url);
            if (is_file($file_url)) {
                unlink($file_url);
            }
        }
    }

    function fileSizeInMB($url)
    {
        $fileName = explode('uploads', $url);
        if (isset($fileName[1])) {
            $exists_file = "uploads$fileName[1]";
           
            $sizeInBytes = Storage::size($exists_file);
            return round($sizeInBytes / 1024 / 1024, 3);
        }

        return null;
    }

    public function storeStockMedia(string $media): string
    {
        $ext = pathinfo($media, PATHINFO_EXTENSION);
        $isUnsplash = 'images.unsplash.com' == parse_url($media, PHP_URL_HOST);
        if ($isUnsplash) {
            parse_url($media, PHP_URL_QUERY);
            parse_str($media, $parsedQueryString);
            $ext = $parsedQueryString['fm'];
        }
        $media = $this->saveFileFromUrl($media, ".$ext");
        return $media;
    }

    public function storeBase64Media(string $mediaPath): string
    {
        if (is_string($mediaPath) && Str::startsWith($mediaPath, 'data:')) {
            if (preg_match('/^data:image\/(\w+);base64,/', $mediaPath, $type)) {
                $data = substr($mediaPath, strpos($mediaPath, ',') + 1);
                $type = strtolower($type[1]);
                $uploadedUrl = $this->saveFileFromBase64($data, $type);
                $mediaPath = $uploadedUrl;
            }
        }

        return $mediaPath;
    }

    private function saveFileFromBase64($base64, $ext = 'png'): string
    {
        $filename = Str::random(20) . '.' . $ext;
        $path = 'uploads' . date('/y') . '/' . date('m') . '/';
        if (env('APP_ENV') == 'demo') {
            $path = 'demo/';
        }
        $filePath = $path . $filename;
        Storage::put($filePath, base64_decode($base64));
        return Storage::url($filePath);
    }
}
