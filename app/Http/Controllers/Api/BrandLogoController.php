<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BrandLogo;
use Illuminate\Http\Request;

class BrandLogoController extends Controller
{
    public function index(Request $request)
    {
        if (env('DEMO_MODE')) {
            return response()->json(['logo' => null]);
        }
        $logo = BrandLogo::query()
            ->whereIn('category_id', $request->categories)->inRandomOrder()->first();
        if (!$logo) {
            return response()->json(['error' => 'Not found'], 400);
        }
        return response()->json(['logo' => $logo]);
    }
}
