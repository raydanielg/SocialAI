<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploader;
use App\Models\Post;
use App\Models\Postmeta;
use DB;
use Auth;
use Inertia\Inertia;
use Str;

class TeamController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:team');
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
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a team'),
                'url' => route('admin.team.create'),
            ]
        ];
        $posts = Post::where('type', 'team')->with('preview')->latest()->paginate();
        $totalMembers =  Post::where('type', 'team')->count();
        $totalActiveMembers =  Post::where('type', 'team')->where('status', 1)->count();
        $totalInActiveMembers =  Post::where('type', 'team')->where('status', 0)->count();

        return Inertia::render('Admin/Team/Index', [
            'posts' => $posts,
            'totalMembers' => $totalMembers,
            'totalActiveMembers' => $totalActiveMembers,
            'totalInActiveMembers' => $totalInActiveMembers,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.team.index'),
            ]
        ];
        return Inertia::render('Admin/Team/Create', [
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
            'member_name'      => 'required|max:150',
            'member_position'  => 'required|max:100',
            'profile_picture'  => 'required|image|max:2000',
            'about'            => 'required|max:1000',
        ]);


        DB::beginTransaction();
        try {

            $post = new Post;
            $post->title = $request->member_name;
            $post->slug  = $request->member_position;
            $post->status = $request->status ? 1 : 0;
            $post->type  = 'team';
            $post->save();

            $post->excerpt()->create([
                'post_id' => $post->id,
                'key'     => 'excerpt',
                'value'   => json_encode($request->socials),
            ]);

            $post->description()->create([
                'post_id' => $post->id,
                'key'     => 'description',
                'value'   => $request->about,
            ]);

            $preview = $this->saveFile($request, 'profile_picture');

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

        return redirect()->route('admin.team.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.team.index'),
            ]
        ];
        $info = Post::with('description', 'preview', 'excerpt')->where('type', 'team')->findOrFail($id);
        $socials = json_decode($info->excerpt->value ?? '');

        return Inertia::render('Admin/Team/Edit', [
            'buttons' => $buttons,
            'segments' => $segments,
            'info' => $info,
            'socials' => $socials,
        ]);
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
            'team.title'      => 'required|max:150',
            'team.slug'  => 'required|max:100',
            'team.profile_picture'  => 'nullable|image|max:2000',
            'team.description.value' => 'required|max:1000',
        ]);

        DB::beginTransaction();
        try {

            $post =  Post::with('preview')->findOrFail($id);
            $post->title   = $data['team']['title'];
            $post->slug    = $data['team']['slug'];
            $post->type    = 'team';
            $post->status  = $request['team']['status'] ? 1 : 0;
            $post->save();

            $post->excerpt()->update([
                'post_id' => $post->id,
                'key'     => 'excerpt',
                'value'   => json_encode($request->socials),
            ]);

            $post->description()->update([
                'post_id' => $post->id,
                'key'     => 'description',
                'value'   => $data['team']['description']['value'],
            ]);


            if ($request->hasFile('team.preview.value')) {
                $preview = $this->saveFile($request, 'team.preview.value');

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

        return redirect()->route('admin.team.index');
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
        $post = Post::where('type', 'team')->with('preview')->findorFail($id);

        if (!empty($post->preview)) {
            $this->removeFile($post->preview->value);
        }

        $post->delete();

        return redirect()->back();
    }
}
