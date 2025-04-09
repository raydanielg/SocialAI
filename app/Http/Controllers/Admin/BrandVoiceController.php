<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandVoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandVoiceRequest;
use App\Http\Requests\UpdateBrandVoiceRequest;

class BrandVoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:brand-voice');
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
        $brandVoices = BrandVoice::with('category')->latest()->paginate();
        $total = BrandVoice::count();
        $active = BrandVoice::where('status', 'active')->count();
        $inActive = BrandVoice::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandVoice/Index', [
            'brandVoices' => $brandVoices,
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
    public function store(StoreBrandVoiceRequest $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        BrandVoice::create($request->validated());
        return back()->with('success', 'Saved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandVoiceRequest $request, BrandVoice $brandVoice)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandVoice->update($request->validated());
        return back()->with('info', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandVoice $brandVoice)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $brandVoice->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
