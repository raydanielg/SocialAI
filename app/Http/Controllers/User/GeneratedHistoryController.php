<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiGenerate;
use App\Models\AiTemplate;
use App\Models\Brand;
use App\Models\BrandPost;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GeneratedHistoryController extends Controller
{
    public function index(Request $request)
    {
        $aiGenerated = AiGenerate::query();
        $aiGenerated = $aiGenerated
            ->where('user_id', Auth::id())
            ->with(['generatable'  => function (MorphTo $morphTo) {
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
            ->orderBy('created_at', in_array($request->order, ['desc', 'asc']) ? $request->order : 'desc')
            ->paginate(10);

        $total = AiGenerate::query()->where('user_id', Auth::id())->count();
        $totalCharges = AiGenerate::query()->where('user_id', Auth::id())->sum('charge');
        $totalResults = AiGenerate::query()->where('user_id', Auth::id())->sum('result');
        $segments = $request->segments();
        return Inertia::render('User/GeneratedHistory/Index', [
            'aiGenerated' => $aiGenerated,
            'total' => $total ?? [],
            'totalCharges' => $totalCharges ?? [],
            'totalResults' => $totalResults ?? [],
            'segments' => $segments
        ]);
    }

    public function edit($uuid)
    {
        $aiGenerated = AiGenerate::query()
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->firstOrFail();

        return Inertia::render('User/GeneratedHistory/Edit', [
            'aiGenerated' => $aiGenerated,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'content' => 'required|string',
        ]);
        $aiGenerated = AiGenerate::query()
            ->where('user_id', Auth::id())
            ->where('uuid', $uuid)
            ->firstOrFail();

        $aiGenerated->update([
            'content' => $request->content,
        ]);

        return redirect()->route('user.ai-generated-history.index');
    }
}
