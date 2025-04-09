<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'mime_type' => 'required|string',
        ]);
        $assets = Asset::query()
            ->where('user_id', $request->user()->id)
            ->where('type', $request->type)
            ->where('mime_type', str()->singular(strtolower($request->mime_type)))
            ->paginate(12);

        return response()->json($assets);
    }
}
