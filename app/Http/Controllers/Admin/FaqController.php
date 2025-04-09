<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Postmeta;
use Inertia\Inertia;
use DB;
use Auth;
use Str;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:faq');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Post::where('type', 'faq')->with(['excerpt', 'faq_categories:id,title'])
            ->latest()->paginate(20);
        $languages = get_option('languages', true);

        $segments = request()->segments();
        $categories = Category::whereType('faq_category')
            ->where('status', 1)
            ->select('id', 'title', 'status')
            ->get();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create FAQ'),
                'url' => '#',
                'target' => '#addNewFaqDrawer',
            ]
        ];
        return Inertia::render('Admin/Faq/Index', [
            'faqs' => $faqs,
            'languages' => $languages,
            'segments' => $segments,
            'buttons' => $buttons,
            'categories' => $categories,
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
            'question'  => 'required|max:150',
            'answer'    => 'required|max:500',
        ]);


        DB::beginTransaction();
        try {

            $post = new Post;
            $post->title = $request->question;
            $post->slug  = str()->slug($request->question);
            $post->type  = 'faq';
            $post->lang  = $request->language ?? 'en';
            $post->save();
            $post->faq_categories()->sync($request->categories);
            $post->excerpt()->create([
                'post_id' => $post->id,
                'key' => 'excerpt',
                'value' => $request->answer,
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return back();
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
            'question'  => 'required|max:150',
            'answer'    => 'required|max:500',
        ]);


        DB::beginTransaction();
        try {

            $post =  Post::findorFail($id);
            $post->title = $request->question;
            $post->slug  = str()->slug($request->question);
            $post->type  = 'faq';
            $post->lang  = $request->language ?? 'en';
            $post->save();
            $post->faq_categories()->sync($request->categories ?? []);
            $post->excerpt()->update([
                'post_id' => $post->id,
                'key' => 'excerpt',
                'value' => $request->answer,
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return back();
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
        $post = Post::where('type', 'faq')->findorFail($id);
        $post->delete();

        return back();
    }
}
