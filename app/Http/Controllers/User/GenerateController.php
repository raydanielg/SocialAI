<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\Prompt;
use App\Services\BrandAi;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GenerateController extends Controller
{
    use Uploader;
    public function content(Request $request)
    {
        $brand = Brand::query()->findOrFail($request->brand_id);

        $categories = $brand->categories->pluck('title')->toArray();

        $brandAi = new BrandAi($categories, $request->description, $brand);

        if ($request->type === 'content') {
            $response = $brandAi->posts($request->platform, $request->post_id);
        }

        if ($request->type === 'slogan') {
            $response = $brandAi->post_slogan($request->post_id);
        }

        return $response;
    }

    public function image(Request $request)
    {
        $brand = Brand::query()->findOrFail($request->brand_id);
        $categories = $brand->categories->pluck('title')->toArray();
        $brandAi = new BrandAi($categories, $request->description, $brand);
        $brandAi->image(true);
        return back();
    }

    public function stockImage()
    {
        $response = Http::get('https://api.unsplash.com/search/photos', [
            'client_id' => env('UNSPLASH_API_KEY'),
            'query' => request('query')
        ]);

        return response()->json($response->json());
    }
}
