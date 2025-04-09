<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Helpers\PageHeader;
use App\Services\Toastr;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BrandCategoryController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:brand-category');
    }

    public function index()
    {
        PageHeader::set()
            ->title(__("Brand Categories"))
            ->buttons([
                [
                    'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                    'url' => '#',
                    'target' => '#addNewCategoryDrawer',
                ]
            ]);

        $categories = Category::whereType('brand')->latest()->paginate(10);
        $totalCategories = Category::whereType('brand')->count();
        $activeCategories = Category::whereType('brand')->where('status', 1)->count();
        $inActiveCategories = Category::whereType('brand')->where('status', 0)->count();
        $languages = get_option('languages', true);

        return Inertia::render('Admin/BrandCategory/Index', [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'activeCategories' => $activeCategories,
            'inActiveCategories' => $inActiveCategories,
            'languages' => $languages,
        ]);
    }

    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $request->validate([
            'title' => ['required', 'min:2', 'max:100'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp'],
            'preview' => ['required', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp']
        ]);

        if ($request->hasFile('icon')) {
            $icon = $this->saveFile($request, 'icon');
        }

        if ($request->hasFile('preview')) {
            $preview = $this->saveFile($request, 'preview');
        }

        Category::create([
            'title' => $request->title,
            'icon' => $icon ?? null,
            'preview' => $preview ?? null,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'type' => 'brand',
            'slug' => Str::slug($request->title),
        ]);

        Toastr::success('Created Successfully');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $request->validate([
            'category.title' => ['required', 'min:2', 'max:100'],
            'category.icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp'],
            'category.preview' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp']
        ]);

        if ($request->hasFile('category.preview')) {
            $preview = $this->saveFile($request, 'category.preview');
        }

        if ($request->hasFile('category.icon')) {
            $icon = $this->saveFile($request, 'category.icon');
        }

        $category = Category::findOrFail($id);

        $category->update([
            'title' =>  $request->category['title'],
            'status' => $request->category['status'],
            'icon' => $icon ?? $category->icon,
            'preview' => $preview ?? $category->preview,
            'is_featured' => $request->category['is_featured'],
            'slug' => Str::slug($request->category['title']),
        ]);
        Toastr::success('Updated Successfully');

        return redirect()->back();
    }

    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $category = Category::findOrFail($id);
        $this->removeFile($category->preview);
        $category->delete();
        Toastr::danger('Deleted Successfully');
        return redirect()->back();
    }
}
