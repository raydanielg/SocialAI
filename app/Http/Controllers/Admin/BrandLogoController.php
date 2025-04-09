<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandLogo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandLogoRequest;
use App\Http\Requests\UpdateBrandLogoRequest;
use App\Traits\Uploader;

class BrandLogoController extends Controller
{
    use Uploader;
    public function __construct()
    {
        $this->middleware('permission:brand-logo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => route('admin.brand-logos.create'),
            ]
        ];

        $categories = Category::whereType('brand')->get();
        $logos = BrandLogo::with('category')->latest()->paginate();
        $total = BrandLogo::count();
        $active = BrandLogo::where('status', 'active')->count();
        $inActive = BrandLogo::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandLogos/Index', [
            'logos' => $logos,
            'categories' => $categories,
            'total' => $total,
            'active' => $active,
            'inActive' => $inActive,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shapes = [];
        $dir = public_path('assets/shapes');
        $folders = array_diff(scandir($dir), ['.', '..']);
        foreach ($folders as $folder) {
            $path = $dir . '/' . $folder;
            if (is_dir($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                $shapes[$folder] = $files;
            }
        }
        $categories = Category::whereType('brand')->get();
        return Inertia::render('Admin/BrandLogos/Create', [
            'shapes' => $shapes,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandLogoRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $data = $request->validated();
        if (isset($data['preview'])) {
            $data['preview'] = $this->saveFileFromUrl($data['preview']);
        }

        BrandLogo::create($data);

        return redirect()->route('admin.brand-logos.index')->with('success', 'Saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrandLogo $brandLogo)
    {
        $shapes = [];
        $dir = public_path('assets/shapes');
        $folders = array_diff(scandir($dir), ['.', '..']);
        foreach ($folders as $folder) {
            $path = $dir . '/' . $folder;
            if (is_dir($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                $shapes[$folder] = $files;
            }
        }
        $categories = Category::whereType('brand')->get();
        return Inertia::render('Admin/BrandLogos/Edit', [
            'shapes' => $shapes,
            'categories' => $categories,
            'brandLogo' => $brandLogo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandLogoRequest $request, BrandLogo $brandLogo)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $data = $request->validated();

        if (isset($data['preview'])) {
            $this->removeFile($brandLogo->preview);
            $data['preview'] = $this->saveFileFromUrl($data['preview']);
        }

        $brandLogo->update($data);

        return redirect()->route('admin.brand-logos.index')->with('info', 'Updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandLogo $brandLogo)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $this->removeFile($brandLogo->preview);
        $brandLogo->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
