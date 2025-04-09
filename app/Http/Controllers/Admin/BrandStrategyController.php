<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandStrategyRequest;
use App\Http\Requests\UpdateBrandStrategyRequest;

class BrandStrategyController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:brand-strategy');
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
        $strategies = BrandStrategy::with('category')->latest()->paginate();
        $total = BrandStrategy::count();
        $active = BrandStrategy::where('status', 'active')->count();
        $inActive = BrandStrategy::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandStrategies/Index', [
            'strategies' => $strategies,
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
    public function store(StoreBrandStrategyRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        BrandStrategy::create($request->validated());
        return back()->with('success', 'Saved successfully');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandStrategyRequest $request, BrandStrategy $brandStrategy)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandStrategy->update($request->validated());
        return back()->with('info', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandStrategy $brandStrategy)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandStrategy->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
