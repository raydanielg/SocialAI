<?php

namespace Modules\Videoai\App\Http\Controllers\Admin;

use App\Helpers\PageHeader;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Videoai\App\Models\PromptPreset;

class PromptPresetController extends Controller
{
    use Uploader;
    public function __construct()
    {
        $this->middleware('permission:ai-templates');
    }
    public function index()
    {
        $hasUserType = request()->filled('type') && request('type') === 'user';

        $buttons = [
            [
                'name' => sprintf('<i class="fa fa-plus"></i>&nbsp;%s', __('Add New')),
                'url' => route('admin.videoai.prompt-preset.create'),
            ],
            [
                'name' => $hasUserType ? __('Admin Presets') : __('User Presets'),
                'url' => route('admin.videoai.prompt-preset.index', $hasUserType ? [] : ['type' => 'user']),
            ]
        ];

        $query = PromptPreset::query()
            ->when(
                $hasUserType,
                fn($q) => $q->whereNotNull('user_id'),
                fn($q) => $q->whereNull('user_id')
            );

        PageHeader::set()
            ->title(__('Prompt Preset'))
            ->buttons($buttons)
            ->overviews([
                [
                    'title' => 'Total Presets',
                    'value' => $query->clone()->count(),
                    'icon' => 'bx:bar-chart',
                ],
                [
                    'title' => 'Active Presets',
                    'value' => $query->clone()->where('status', 'active')->count(),
                    'icon' => 'bx:check-circle',
                ],
                [
                    'title' => 'Inactive Presets',
                    'value' => $query->clone()->where('status', 'inactive')->count(),
                    'icon' => 'bx:x-circle',
                ],
            ]);

        $promptPresets = $query
            ->latest()
            ->with('user:id,name')
            ->paginate();

        return Inertia::render('Admin/PromptPreset/Index', [
            'promptPresets' => $promptPresets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buttons = [
            [
                'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back'),
                'url' => route('admin.videoai.prompt-preset.index'),
            ]
        ];
        PageHeader::set()->title(__('Create Prompt Preset'))
            ->buttons($buttons);
        return Inertia::render('Admin/PromptPreset/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:active,inactive'],
            'prompt' => ['required', 'string', 'max:1000'],
            'meta' => ['nullable', 'array'],
        ]);
        PromptPreset::create($validated);
        return to_route('admin.videoai.prompt-preset.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromptPreset $promptPreset)
    {
        $buttons = [
            [
                'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back'),
                'url' => route('admin.videoai.prompt-preset.index'),
            ]
        ];
        PageHeader::set()->title(__('Edit Prompt Preset'))
            ->buttons($buttons);
        return Inertia::render('Admin/PromptPreset/Edit', [
            'promptPreset' => $promptPreset,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromptPreset $promptPreset)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:active,inactive'],
            'prompt' => ['required', 'string', 'max:1000'],
            'meta' => ['nullable', 'array'],
        ]);
        $promptPreset->update($validated);
        return to_route('admin.videoai.prompt-preset.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromptPreset $promptPreset)
    {
        $promptPreset->delete();
        return to_route('admin.videoai.prompt-preset.index')->with('success', 'Deleted Successfully');
    }
}
