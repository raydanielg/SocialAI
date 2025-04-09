<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromptRequest;
use App\Http\Requests\UpdatePromptRequest;
use App\Models\Prompt;
use App\Traits\Uploader;
use Inertia\Inertia;

class PromptController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:prompts');
    }
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('admin.prompts.create'),
            ]
        ];
        $totalPrompts = Prompt::count();
        $activePrompts = Prompt::where('status', 'active')->count();
        $inActivePrompts = Prompt::where('status', 'inactive')->count();
        $prompts = Prompt::latest()->paginate();
        return Inertia::render('Admin/Prompt/Index', [
            'prompts' => $prompts,
            'totalPrompts' => $totalPrompts,
            'activePrompts' => $activePrompts,
            'inActivePrompts' => $inActivePrompts,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-arrow-left"></i>&nbsp' . __('Back'),
                'url' => route('admin.prompts.index'),
            ]
        ];
        $models = config('openai.ai_models');
        $image_models = ['stablediffusion', 'stability_ai', 'dalle_3'];

        $image_ratios = ['16:9', '1:1', '21:9', '2:3', '3:2', '4:5', '5:4', '9:16', '9:21'];
        $image_sizes = ['1024x1024', '1024x1792', '1792x1024'];
        return Inertia::render('Admin/Prompt/Create', [
            'buttons' => $buttons,
            'segments' => $segments,
            'models' => $models,
            'image_models' => $image_models,
            'image_ratios' => $image_ratios,
            'image_sizes' => $image_sizes
        ]);
    }

    public function store(StorePromptRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $validated = $request->validated();

        if ($validated['status'] == 'active') {
            Prompt::where('prompt_type', $validated['prompt_type'])
                ->update(['status' => 'inactive']);
        }

        Prompt::create($validated);

        return redirect()->route('admin.prompts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prompt = Prompt::findOrFail($id);
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-arrow-left"></i>&nbsp' . __('Back'),
                'url' => route('admin.prompts.index'),
            ]
        ];
        $models = config('openai.ai_models');
        $image_models = ['stablediffusion', 'stability_ai', 'dalle_3'];

        $image_ratios = ['16:9', '1:1', '21:9', '2:3', '3:2', '4:5', '5:4', '9:16', '9:21'];
        $image_sizes = ['1024x1024', '1024x1792', '1792x1024'];
        return Inertia::render('Admin/Prompt/Edit', [
            'buttons' => $buttons,
            'segments' => $segments,
            'prompt' => $prompt,
            'models' => $models,
            'image_models' => $image_models,
            'image_ratios' => $image_ratios,
            'image_sizes' => $image_sizes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $validated = $request->validated();

        if ($validated['status'] == 'active') {
            Prompt::where('prompt_type', $validated['prompt_type'])
                ->where('id', '!=', $prompt->id)
                ->update(['status' => 'inactive']);
        }

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prompt $prompt)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $prompt->delete();
        return to_route('admin.prompts.index')->with('danger', 'Deleted Successfully');
    }
}
