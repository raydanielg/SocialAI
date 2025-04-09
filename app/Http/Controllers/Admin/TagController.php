<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Inertia\Inertia;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-tags');
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
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a Tag'),
                'url' => '#',
                'target' => '#addNewTagDrawer',
            ]
        ];
        $tags = Category::whereType('tags')->withCount('postcategories')->latest()->paginate(10);
        $totalTags = Category::whereType('tags')->count();
        $activeTags = Category::whereType('tags')->where('status', 1)->count();
        $inActiveTags = Category::whereType('tags')->where('status', 0)->count();
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Tag/Index', [
            'tags' => $tags,
            'totalTags' => $totalTags,
            'activeTags' => $activeTags,
            'inActiveTags' => $inActiveTags,
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
            'language' => ['required']
        ]);

        Category::create([
            'title' => $request->title,
            'type' => 'tags',
            'slug' => Str::slug($request->title),
            'status' => $request->status,
            'lang' => $request->language,
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
            'lang' => ['required']
        ]);

        $tag = Category::findOrFail($id);

        $tag->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'status' => $request->status,
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
        $tag = Category::findOrFail($id);
        $tag->delete();

        return redirect()->back();
    }
}
