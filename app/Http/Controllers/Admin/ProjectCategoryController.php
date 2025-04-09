<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:project-categories');
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
        $categories = Category::whereType('project')->with('parent:id,title,slug')
            ->latest()->paginate(10);
        $totalCategories = Category::whereType('project')->count();
        $activeCategories = Category::whereType('project')->where('status', 1)->count();
        $inActiveCategories = Category::whereType('project')->where('status', 0)->count();
        $languages = get_option('languages', true);
        $allServices = Category::whereType('service')->get();

        return Inertia::render('Admin/ProjectCategory/Index', [
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
            'category_id' => $request->category_id,
            'icon' => $icon ?? null,
            'preview' => $preview ?? null,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'type' => 'project',
        ]);

        return to_route('admin.project-categories.index');
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

        if ($request->hasFile('category.preview')) {
            $preview = $this->saveFile($request, 'category.preview');
        }

        if ($request->hasFile('category.icon')) {
            $icon = $this->saveFile($request, 'category.icon');
        }

        $category = Category::findOrFail($id);

        $category->update([
            'title' => $request->category['title'],
            'category_id' => $request->category['category_id'],
            'icon' => $icon ??  $category->icon,
            'preview' => $preview ??  $category->preview,
            'status' => $request->category['status'],
            'is_featured' => $request->category['is_featured'],
            'slug' => Str::slug($request->category['title'])
        ]);

        return to_route('admin.project-categories.index');
    }

    public function destroy($id)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $category = Category::findOrFail($id);
        $this->removeFile($category->preview);
        $category->delete();

        return to_route('admin.project-categories.index');
    }
}
