<?php

namespace App\Services;

use App\Models\Asset;
use App\Traits\Uploader;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StableDiffusion
{
    use Uploader;
    private $prompt;

    public function __construct($prompt = null)
    {
        $this->prompt = $prompt;
    }

    public function generateImage(
        $prompt = null,
        $width = 512,
        $height = 512,
        $qty = 1,
        $guidance_scale = null,
        $seed = null,
        $negative_prompt = null,
    ) {
        $response = $this->sendImageRequest(
            $prompt,
            $width,
            $height,
            $qty,
            $guidance_scale,
            $seed,
            $negative_prompt,
        );
        if ($response->successful() && $response->json()['status'] === 'success') {
            return $this->saveImage($response);
        }

        return $response->json();
    }

    private function sendImageRequest(
        $prompt = null,
        $width = 512,
        $height = 512,
        $qty = 1,
        $guidance_scale = null,
        $seed = null,
        $negative_prompt = null,

    ) {
        if (!env('STABLE_DIFFUSION_API_KEY')) {
            throw new  Exception('STABLE_DIFFUSION_API_KEY cannot be empty');
        }
        if (env('DEMO_MODE') || env('AI_MOCK_DATA', false)) {
            $video = url('/assets/images/ai_demo.jpeg');
            $data = [
                'output' => [$video],
                'status' => 'success',
            ];
            return $data;
        }
        return Http::post(config('stablediffusion.image_api_url'), [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
            'prompt' => $prompt ?? $this->prompt,
            'width' => $width,
            'height' => $height,
            'samples' => $qty,
            'guidance_scale' => $guidance_scale,
            'seed' => $seed,
            'negative_prompt' => $negative_prompt,
        ]);
    }

    private function saveImage($response)
    {
        $images = [];

        foreach ($response->json()['output'] as $url) {
            $image = $this->saveFileFromUrl($url);
            Asset::create([
                'user_id' => Auth::id(),
                'path' => $image,
                'type' => 'generated',
                'mime_type' => 'image',
                'file_size' => $this->fileSizeInMB($image),
            ]);
            $images[] = $image;
        }

        return $images;
    }

    public function fetchVideo()
    {
        $url = config('stablediffusion.fetch_api_url') . request('id');

        $response = Http::post($url, [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
        ]);
        $data = $response->json();

        if ($response->successful() && $data['status'] === 'success') {
            return  $this->saveVideo($response);
        }
        return $data;
    }

    public function sendVideoRequest($prompt = null, $seconds = 2)
    {
        if (!env('STABLE_DIFFUSION_API_KEY')) {
            throw new  Exception('STABLE_DIFFUSION_API_KEY cannot be empty');
        }

        $response = Http::post(config('stablediffusion.video_api_url'), [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
            'prompt' => $prompt ?? $this->prompt,
            'seconds' => $seconds,
        ]);

        $data = $response->json();

        return $data;
    }


    public function saveVideo($response)
    {
        $video = $this->saveFileFromUrl($response['output'][0], '.mp4', '', 'video');
        Asset::create([
            'user_id' => Auth::id(),
            'path' => $video,
            'type' => 'generated',
            'mime_type' => 'video',
            'file_size' => $this->fileSizeInMB($video),
        ]);

        return $response;
    }

    public function fetchVoice()
    {
        $url = config('stablediffusion.fetch_api_url') . request('id');

        $response = Http::post($url, [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
        ]);
        $data = $response->json();

        if ($response->successful() && $response['status'] === 'success') {
            $this->saveVoice($response);
        }
        return $data;
    }

    public function sendVoiceRequest($prompt = null, $voice_id = 'jack_sparrow', $decoder_iterations = null)
    {
        if (!env('STABLE_DIFFUSION_API_KEY')) {
            throw new  Exception('STABLE_DIFFUSION_API_KEY cannot be empty');
        }
        $response = Http::post(config('stablediffusion.voice_clone_api_url'), [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
            'prompt' => $prompt ?? $this->prompt,
            'voice_id' => $voice_id,
            'decoder_iterations' => $decoder_iterations,
        ]);
        if ($response->successful() && $response['status'] === 'success') {
            $this->saveVoice($response);
        }
        $data = $response->json();

        return $data;
    }
    public function sendAudioRequest($prompt = null, $init_audio = null, $decoder_iterations = null)
    {
        if (!env('STABLE_DIFFUSION_API_KEY')) {
            throw new  Exception('STABLE_DIFFUSION_API_KEY cannot be empty');
        }
        $response = Http::post(config('stablediffusion.audio_api_url'), [
            'key' => env('STABLE_DIFFUSION_API_KEY'),
            'prompt' => $prompt ?? $this->prompt,
            'init_audio' => $init_audio,
            'decoder_iterations' => $decoder_iterations,
            'language' => 'english',
        ]);
        if ($response->successful() && $response['status'] === 'success') {
            $this->saveVoice($response);
        }
        $data = $response->json();

        return $data;
    }
    public function saveVoice($response)
    {
        $voice = $this->saveFileFromUrl($response['output'][0], '.wav', '', 'voice');
        Asset::create([
            'user_id' => Auth::id(),
            'path' => $voice,
            'type' => 'generated',
            'mime_type' => 'audio',
            'file_size' => $this->fileSizeInMB($voice),
        ]);

        return $voice;
    }
}
