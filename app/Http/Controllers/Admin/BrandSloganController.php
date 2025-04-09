<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandSlogan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandSloganRequest;
use App\Http\Requests\UpdateBrandSloganRequest;

class BrandSloganController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:brand-slogan');
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
        $slogans = BrandSlogan::with('category')->latest()->paginate();
        $total = BrandSlogan::count();
        $active = BrandSlogan::where('status', 'active')->count();
        $inActive = BrandSlogan::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandSlogans/Index', [
            'slogans' => $slogans,
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
    public function store(StoreBrandSloganRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        BrandSlogan::create($request->validated());
        return back()->with('success', 'Saved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandSloganRequest $request, BrandSlogan $brandSlogan)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandSlogan->update($request->validated());
        return back()->with('info', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandSlogan $brandSlogan)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandSlogan->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
