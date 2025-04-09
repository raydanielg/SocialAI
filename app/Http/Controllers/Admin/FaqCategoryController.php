<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:faq-category');
    }

    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a category'),
                'url' => '#',
                'target' => '#addNewCategoryDrawer',
            ]
        ];
        $categories = Category::whereType('faq_category')->latest()->paginate(10);
        $totalCategories = Category::whereType('faq_category')->count();
        $activeCategories = Category::whereType('faq_category')->where('status', 1)->count();
        $inActiveCategories = Category::whereType('faq_category')->where('status', 0)->count();
        $languages = get_option('languages', true);

        return Inertia::render('Admin/FaqCategory/Index', [
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
            'language' => ['required'],
        ]);

        Category::create([
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->language,
            'type' => 'faq_category',
            'slug' => str()->slug($request->title),
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'title' => ['required', 'min:2', 'max:100'],
            'lang' => ['required'],
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'title' => $request->title,
            'status' => $request->status,
            'slug' => str()->slug($request->title),
            'lang' => $request->lang,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back();
    }
}
