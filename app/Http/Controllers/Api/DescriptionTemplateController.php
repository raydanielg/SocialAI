<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DescriptionTemplate;
use Illuminate\Http\Request;

class DescriptionTemplateController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->filled('service')) {
            $data = DescriptionTemplate::query()
                ->where('type', request('type'))
                ->whereHas('categories', function ($query) {
                    $query->where('category_templates.category_id', request('service'));
                })->inRandomOrder()->get();
        }
        return response()->json($data);
    }
}
