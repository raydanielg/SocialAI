<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploader;
use App\Models\Post;
use App\Models\Postmeta;
use DB;
use Inertia\Inertia;

class TestimonialsController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:testimonials');
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
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Testimonial'),
                'url' => '#',
                'target' => '#addNewTestimonialDrawer',
            ]
        ];
        $posts = Post::where('type', 'testimonial')->with('excerpt', 'preview')->latest()->paginate(20);


        return Inertia::render('Admin/Testimonial/Index', [
            'posts' => $posts,
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
            'reviewer_name'    => 'required|max:150',
            'reviewer_position' => 'required|max:100',
            'star'             => 'required|max:100',
            'comment'          => 'required|max:500',
            'reviewer_avatar'  => 'required|image|max:1024',
        ]);


        DB::beginTransaction();
        try {

            $post = new Post;
            $post->title = $request->reviewer_name;
            $post->slug  = $request->reviewer_position;
            $post->type  = 'testimonial';
            $post->lang  = $request->star;
            $post->save();

            $post->excerpt()->create([
                'post_id' => $post->id,
                'key'     => 'excerpt',
                'value'   => $request->comment,
            ]);

            $preview = $this->saveFile($request, 'reviewer_avatar');

            $post->preview()->create([
                'post_id' => $post->id,
                'key'     => 'preview',
                'value'   => $preview,
            ]);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

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
        $data = $request->validate([
            'testimonial.title'    => 'required|max:150',
            'testimonial.slug' => 'required|max:100',
            'testimonial.lang'             => 'required|max:100',
            'testimonial.excerpt.value'          => 'required|max:500',
            'testimonial.preview.value'  => 'nullable|image|max:1024',
        ]);

        DB::beginTransaction();
        try {

            $post =  Post::with('preview')->findOrFail($id);
            $post->title = $data['testimonial']['title'];
            $post->slug  = $data['testimonial']['slug'];
            $post->type  = 'testimonial';
            $post->lang  = $data['testimonial']['lang'];
            $post->save();

            $post->excerpt()->update([
                'post_id' => $post->id,
                'key' => 'excerpt',
                'value' => $data['testimonial']['excerpt']['value'],
            ]);

            if ($request->hasFile('testimonial.preview.value')) {

                $preview = $this->saveFile($request, 'testimonial.preview.value');

                !empty($post->preview) ? $this->removeFile($post->preview->value) : '';

                $post->preview()->update([
                    'post_id' => $post->id,
                    'key'     => 'preview',
                    'value'   => $preview,
                ]);
            }

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

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

        $post = Post::where('type', 'testimonial')->with('preview')->findOrFail($id);

        if (!empty($post->preview)) {
            $this->removeFile($post->preview->value);
        }

        $post->delete();

        return redirect()->back();
    }
}
