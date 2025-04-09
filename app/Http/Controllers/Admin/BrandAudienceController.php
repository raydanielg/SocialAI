<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandAudience;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandAudienceRequest;
use App\Http\Requests\UpdateBrandAudienceRequest;

class BrandAudienceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:brand-audience');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => '#',
                'target' => '#addNewItemDrawer',
            ]
        ];
        $categories = Category::whereType('brand')->get();
        $brandAudiences = BrandAudience::with('category')->latest()->paginate();
        $total = BrandAudience::count();
        $active = BrandAudience::where('status', 'active')->count();
        $inActive = BrandAudience::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandAudience/Index', [
            'brandAudiences' => $brandAudiences,
            'categories' => $categories,
            'total' => $total,
            'active' => $active,
            'inActive' => $inActive,
            'buttons' => $buttons,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandAudienceRequest $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        BrandAudience::create($request->validated());
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandAudienceRequest $request, BrandAudience $brandAudience)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $brandAudience->update($request->validated());
        return back()->with('info', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandAudience $brandAudience)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $brandAudience->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
