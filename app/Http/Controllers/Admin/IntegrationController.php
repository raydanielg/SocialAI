<?php

namespace App\Http\Controllers\Admin;

use App\Models\Integration;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntegrationRequest;
use App\Http\Requests\UpdateIntegrationRequest;

class IntegrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:integrations');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buttons = [
            [
                'name' => '<i class="bx bx-plus"></i>&nbsp' . __('Add New'),
                'url' => route('admin.integrations.create'),
            ]
        ];

        $integrations = Integration::paginate();
        $total = Integration::count();
        $active = Integration::where('is_active', 1)->count();
        $inActive = Integration::where('is_active', 0)->count();

        return inertia('Admin/Integrations/Index', [
            'integrations' => $integrations,
            'total' => $total,
            'active' => $active,
            'inActive' => $inActive,
            'buttons' => $buttons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Integrations/Create', [
            'buttons' => [
                [
                    'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back to list'),
                    'url' => route('admin.integrations.index'),
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIntegrationRequest $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $newIntegration = $request->validated();
        $newIntegration['meta'] = $request->input('seo');
        Integration::create($newIntegration);
        return to_route('admin.integrations.index')->with('success', 'Saved Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Integration $integration)
    {
        return inertia('Admin/Integrations/Edit', [
            'integration' => $integration,
            'segments' => request()->segments(),
            'buttons' => [
                [
                    'name' => '<i class="fa fa-list"></i>&nbsp' . __('Back to list'),
                    'url' => route('admin.integrations.index'),
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIntegrationRequest $request, Integration $integration)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $newIntegration = $request->validated();
        $newIntegration['meta'] = $request->input('seo');

        $integration->update($newIntegration);

        return to_route('admin.integrations.index')->with('info', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        Integration::findOrFail($id)->delete();
        return to_route('admin.integrations.index')->with('danger', 'Deleted Successfully');
    }
}
