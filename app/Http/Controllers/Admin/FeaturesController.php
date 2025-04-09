<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploader;
use App\Models\Post;
use App\Models\Postmeta;
use DB;
use Auth;
use Str;
use Inertia\Inertia;

class FeaturesController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:features');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::where('type', 'feature')->with('excerpt', 'preview')->latest()->paginate(20);
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New Step'),
                'url' => route('admin.features.create')
            ]
        ];

        return Inertia::render('Admin/Feature/Index', compact('posts', 'segments', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = get_option('languages', true);

        $segments = request()->segments();
        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.features.index')
            ]
        ];

        return  Inertia::render('Admin/Feature/Create', compact('languages', 'segments', 'buttons'));
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
            'title'          => 'required|max:150',
            'description'    => 'required|max:500',
            'main_description'    => 'required|max:5000',
            'preview_image'  => 'required|image|max:1024',
            'banner_image'  => 'required|image|max:2048',
        ]);


        DB::beginTransaction();
        try {

            $post = new Post;
            $post->title = $request->title;
            $post->slug  = Str::slug($request->title);
            $post->type  = 'feature';
            $post->lang  = $request->language ?? 'en';
            $post->status  = $request->status ? 1 : 0;
            $post->featured  = $request->featured ? 1 : 0;
            $post->save();

            $post->excerpt()->create([
                'post_id' => $post->id,
                'key' => 'excerpt',
                'value' => $request->description,
            ]);

            $post->longDescription()->create([
                'post_id' => $post->id,
                'key' => 'main_description',
                'value' => $request->main_description,
            ]);

            $preview = $this->saveFile($request, 'preview_image');

            $post->preview()->create([
                'post_id' => $post->id,
                'key' => 'preview',
                'value' => $preview,
            ]);

            $banner = $this->saveFile($request, 'banner_image');

            $post->banner()->create([
                'post_id' => $post->id,
                'key' => 'banner',
                'value' => $banner,
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return to_route('admin.features.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Post::where('type', 'feature')->with('excerpt', 'preview', 'longDescription', 'banner')->findOrFail($id);

        $languages = get_option('languages', true);

        $segments = request()->segments();
        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.features.index')
            ]
        ];

        return  Inertia::render('Admin/Feature/Edit', compact('languages', 'segments', 'buttons', 'info'));
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
            'title'          => 'required|max:150',
            'description'    => 'required|max:500',
        ]);

        DB::beginTransaction();
        try {

            $post =  Post::with('preview')->findorFail($id);
            $post->title = $request->title;
            $post->slug  = Str::slug($request->title);
            $post->type  = 'feature';
            $post->lang  = $request->language ?? 'en';
            $post->status  = $request->status ? 1 : 0;
            $post->featured  = $request->featured ? 1 : 0;
            $post->save();

            $post->excerpt()->update([
                'post_id' => $post->id,
                'key' => 'excerpt',
                'value' => $request->description,
            ]);


            $post->longDescription()->update([
                'post_id' => $post->id,
                'key' => 'main_description',
                'value' => $request->main_description,
            ]);

            if ($request->hasFile('preview_image')) {
                $preview = $this->saveFile($request, 'preview_image');

                !empty($post->preview) ? $this->removeFile($post->preview->value) : '';

                $post->preview()->update([
                    'post_id' => $post->id,
                    'key' => 'preview',
                    'value' => $preview,
                ]);
            }

            if ($request->hasFile('banner_image')) {
                $banner = $this->saveFile($request, 'banner_image');

                !empty($post->banner) ? $this->removeFile($post->banner->value) : '';

                $banner = $post->banner()->update([
                    'post_id' => $post->id,
                    'key' => 'banner',
                    'value' => $banner,
                ]);
            }

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return to_route('admin.features.index');
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
        $post = Post::where('type', 'feature')->with('preview', 'banner')->findorFail($id);

        if (!empty($post->preview)) {
            $this->removeFile($post->preview->value);
        }

        if (!empty($post->banner)) {
            $this->removeFile($post->banner->value);
        }

        $post->delete();

        return back();
    }
}
