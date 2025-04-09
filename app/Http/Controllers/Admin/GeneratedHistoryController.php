<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiGenerate;
use App\Models\AiTemplate;
use App\Models\Brand;
use App\Models\BrandPost;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneratedHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ai-generated-history');
    }
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [];
        $aiGenerated = AiGenerate::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $aiGenerated = $aiGenerated->whereHas('user', function ($q) {
                    return $q->where('email', request('search'));
                });
            } else {
                $aiGenerated = $aiGenerated->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $aiGenerated = $aiGenerated
            ->with(['user:id,name,created_at,role', 'generatable'  => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    AiTemplate::class => function ($query) {
                        $query->select('id', 'title');
                    },
                    Brand::class => function ($query) {
                        $query->select('id', 'name');
                    },
                    BrandPost::class => function ($query) {
                        $query->select('id', 'title', 'created_at');
                    },
                ]);
            }])
            ->paginate(10);

        $total = AiGenerate::query()->count();
        $totalCharges = AiGenerate::query()->sum('charge');
        $totalResults = AiGenerate::query()->sum('result');

        $type = $request->type ?? 'email';

        return Inertia::render('Admin/GeneratedHistory/Index', [
            'aiGenerated' => $aiGenerated,
            'buttons' => $buttons,
            'segments' => $segments,
            'total' => $total ?? [],
            'totalCharges' => $totalCharges ?? [],
            'totalResults' => $totalResults ?? [],
            'request' => $request,
            'type' => $type,
        ]);
    }
}
