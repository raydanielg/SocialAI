<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Uploader;
use App\Models\AiTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAiTemplateRequest;
use App\Http\Requests\UpdateAiTemplateRequest;
use Inertia\Inertia;

class AiTemplateController extends Controller
{
    use Uploader;
    public function __construct()
    {
        $this->middleware('permission:ai-templates');
    }
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('admin.ai-templates.create'),
            ]
        ];

        $templates = AiTemplate::latest()->paginate();
        $totalTemplates = AiTemplate::count();
        $activeTemplates = AiTemplate::where('status', 'active')->count();
        $inActiveTemplates = AiTemplate::where('status', 'inactive')->count();

        return Inertia::render('Admin/AiTemplates/Index', [
            'templates' => $templates,
            'totalTemplates' => $totalTemplates,
            'activeTemplates' => $activeTemplates,
            'inActiveTemplates' => $inActiveTemplates,
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
                'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back'),
                'url' => route('admin.ai-templates.index'),
            ]
        ];
        $models = config('openai.ai_models');
        $voices = config('stablediffusion.voice_clone_ids');
        $image_models = ['stablediffusion', 'stability_ai', 'dalle_3'];
        $image_ratios = ['16:9', '1:1', '21:9', '2:3', '3:2', '4:5', '5:4', '9:16', '9:21'];
        $image_sizes = ['1024x1024', '1024x1792', '1792x1024'];
        $instructions = AiTemplate::INSTRUCTIONS;

        $STABLE_DIFFUSION_API_KEY_EXISTS = !empty(env('STABLE_DIFFUSION_API_KEY')) ? true : false;
        return Inertia::render('Admin/AiTemplates/Create', [
            'buttons' => $buttons,
            'segments' => $segments,
            'models' => $models,
            'image_models' => $image_models,
            'voices' => $voices,
            'image_ratios' => $image_ratios,
            'image_sizes' => $image_sizes,
            'instructions' => $instructions,
            'STABLE_DIFFUSION_API_KEY_EXISTS' => $STABLE_DIFFUSION_API_KEY_EXISTS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAiTemplateRequest $request)
    {
        AiTemplate::create($request->validated());
        return to_route('admin.ai-templates.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AiTemplate $aiTemplate)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back'),
                'url' => route('admin.ai-templates.index'),
            ]
        ];
        $models = config('openai.ai_models');
        $voices = config('stablediffusion.voice_clone_ids');
        $image_models = ['stablediffusion', 'stability_ai', 'dalle_3'];
        $image_ratios = ['16:9', '1:1', '21:9', '2:3', '3:2', '4:5', '5:4', '9:16', '9:21'];
        $image_sizes = ['1024x1024', '1024x1792', '1792x1024'];
        $instructions = AiTemplate::INSTRUCTIONS;
        return Inertia::render('Admin/AiTemplates/Edit', [
            'buttons' => $buttons,
            'segments' => $segments,
            'template' => $aiTemplate,
            'image_models' => $image_models,
            'image_ratios' => $image_ratios,
            'image_sizes' => $image_sizes,
            'models' => $models,
            'voices' => $voices,
            'instructions' => $instructions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAiTemplateRequest $request, AiTemplate $aiTemplate)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $aiTemplate->update($request->validated()); // note: files are auto uploaded via caster
        return to_route('admin.ai-templates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiTemplate $aiTemplate)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $aiTemplate->delete();
        return to_route('admin.ai-templates.index')->with('danger', 'Deleted Successfully');
    }
}
