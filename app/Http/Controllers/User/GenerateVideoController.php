<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Services\BrandAi;
use App\Services\StableDiffusion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GenerateVideoController extends Controller
{
    public function fetchVideo()
    {
        $stableDiffusion = new StableDiffusion();

        $video = $stableDiffusion->fetchVideo();
        return response($video);
    }

    public function video(Request $request)
    {
        if (env('DEMO_MODE') || env('AI_MOCK_DATA', false)) {
            $video = url('/assets/ai_demo.mp4');
            Asset::create([
                'user_id' => Auth::id(),
                'path' => $video,
                'type' => 'generated',
                'mime_type' => 'video',
                'file_size' => '1.2',
            ]);
            $data = [
                'output' => [$video],
                'status' => 'success',
            ];
            return $data;
        }
        $brand = Brand::query()->findOrFail($request->brand_id);

        $categories = $brand->categories->pluck('name')->toArray();
        $brandAi = new BrandAi($categories, $request->description);
        $response = $brandAi->video();

        return response($response);
    }

    public function stockVideo()
    {
        $response = Http::withHeaders([
            'Authorization' => env('PEXELS_API_KEY'),
        ])->get('https://api.pexels.com/videos/search', [
            'query' => request('query'),
            'size' => 'medium',
            'per_page' => 6
        ]);

        return response($response->json());
    }
}
