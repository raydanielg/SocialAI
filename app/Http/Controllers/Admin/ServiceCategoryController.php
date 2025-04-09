<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:service-categories');
    }

    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => '#',
                'target' => '#addNewCategoryDrawer',
            ]
        ];
        $categories = Category::whereType('service')->with('parent:id,title,slug')->latest()->paginate(10);
        $totalCategories = Category::whereType('service')->count();
        $activeCategories = Category::whereType('service')->where('status', 1)->count();
        $inActiveCategories = Category::whereType('service')->where('status', 0)->count();
        $languages = get_option('languages', true);

        return Inertia::render('Admin/ServiceCategory/Index', [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'activeCategories' => $activeCategories,
            'inActiveCategories' => $inActiveCategories,
            'languages' => $languages,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'title' => ['required', 'min:2', 'max:100'],
            'preview' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp']
        ]);

        if ($request->hasFile('preview')) {
            $preview = $this->saveFile($request, 'preview');
        }
        if ($request->hasFile('icon')) {
            $icon = $this->saveFile($request, 'icon');
        }

        Category::create([
            'title' => $request->title,
            'icon' => $icon ?? null,
            'preview' => $preview ?? null,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'type' => 'service',
        ]);

        return redirect()->back()->with('success', 'Saved successfully');
    }

    public function update(Request $request, $id)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }
        $request->validate([
            'category.title' => ['required', 'min:2', 'max:100'],
            'category.preview' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp'],
            'category.icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp']
        ]);
        $category = Category::findOrFail($id);

        if ($request->hasFile('category.preview')) {
            $this->unlinkPublicFile($category->preview);
            $preview = $this->saveFile($request, 'category.preview');
        }

        if ($request->hasFile('category.icon')) {
            $this->unlinkPublicFile($category->icon);
            $icon = $this->saveFile($request, 'category.icon');
        }


        $category->update([
            'title' => $request->category['title'],
            'category_id' => $request->category['category_id'],
            'icon' => $icon ??  $category->icon,
            'preview' => $preview ??  $category->preview,
            'status' => $request->category['status'],
            'is_featured' => $request->category['is_featured'],
            'slug' => Str::slug($request->category['title'])
        ]);

        return redirect()->back()->with('info', 'Updated successfully');
    }

    public function destroy($id)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $category = Category::findOrFail($id);
        $this->unlinkPublicFile($category->preview);
        $this->unlinkPublicFile($category->icon);
        $category->delete();

        return redirect()->back()->with('danger', 'Deleted successfully');
    }
}
