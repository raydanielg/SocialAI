<?php

namespace App\Services;


use App\Models\Asset;
use App\Traits\Uploader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Str;

class StabilityAi
{
    use Uploader;

    private $prompt;

    public function __construct($prompt = null)
    {
        $this->prompt = $prompt;
    }

    public function generateImage(
        $prompt = null,
        $seed = null,
        $negative_prompt = null,
        $aspect_ratio = '16:9'
    ) {
        $outputFormat = 'png';
        $outputFile = Str::random(16) . '.' . $outputFormat;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('STABILITY_AI_API_KEY'),
            'Accept' => 'image/*',
        ])->asMultipart()
            ->post(config('stabilityai.image_api_url'), [
                'prompt' => $prompt ?? $this->prompt,
                'seed' => $seed,
                'negative_prompt' => $negative_prompt,
                'aspect_ratio' => $aspect_ratio,
                'output_format' => $outputFormat,
            ]);

        if ($response->successful()) {
            return $this->saveImage($response->body(), $outputFile);
        }
        throw ValidationException::withMessages([
            'ai_error' => $response->json()['errors'][0] ?? 'Something went wrong, please try again',
        ]);
    }


    private function saveImage($imageData, $outputFile)
    {
        Storage::put('uploads/' . $outputFile, $imageData);
        $image = Storage::url('uploads/' . $outputFile);
        Asset::create([
            'user_id' => Auth::id(),
            'path' => $image,
            'type' => 'generated',
            'mime_type' => 'image',
            'file_size' => $this->fileSizeInMB($image),
        ]);
        return $image;
    }
}
