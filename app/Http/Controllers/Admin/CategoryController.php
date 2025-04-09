<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $categories = Category::whereType('blog_category')->latest()->paginate(10);
        $totalCategories = Category::whereType('blog_category')->count();
        $activeCategories = Category::whereType('blog_category')->where('status', 1)->count();
        $inActiveCategories = Category::whereType('blog_category')->where('status', 0)->count();
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Category/Index', [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'activeCategories' => $activeCategories,
            'inActiveCategories' => $inActiveCategories,
            'languages' => $languages,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'type' => 'blog_category',
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'slug' => Str::slug($request->title),
            'lang' => $request->lang,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
