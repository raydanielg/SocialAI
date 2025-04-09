<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use Inertia\Inertia;
use App\Helpers\Toastr;
use App\Models\Category;
use App\Traits\Uploader;
use App\Helpers\PageHeader;
use Illuminate\Support\str;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class BlogController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:blogs');
    }

    public function index(Request $request)
    {
        PageHeader::set(
            title: "Blogs",
            buttons: [
                [
                    'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a blog post'),
                    'url' => route('admin.blog.create'),
                ]
            ]
        );

        $posts = Post::query();
        if (!empty($request->search)) {
            $posts = $posts->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $posts = $posts->with('preview')
            ->where('type', 'blog')
            ->latest()
            ->paginate(20);

        $type = $request->type ?? '';

        $totalPosts = Post::query()->where('type', 'blog')->count();
        $totalActivePosts = Post::query()->where('type', 'blog')->where('status', 1)->count();
        $totalInActivePosts = Post::query()->where('type', 'blog')->where('status', 0)->count();

        return Inertia::render(
            'Admin/Blog/Index',
            [
                'posts' => $posts,
                'totalPosts' => $totalPosts,
                'totalActivePosts' => $totalActivePosts,
                'totalInActivePosts' => $totalInActivePosts,
                'type' => $type,
                'request' => $request,
            ]
        );
    }

    public function create()
    {
        PageHeader::set(
            title: "Create new blog",
            buttons: [
                [
                    'name' => __('Back'),
                    'url' => route('admin.blog.index'),
                ]
            ]
        );

        $tags = Category::whereType('tags')->pluck('title', 'id');
        $categories = Category::whereType('blog_category')->where('status', 1)->pluck('title', 'id');
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Blog/Create', [
            'tags' => $tags,
            'categories' => $categories,
            'languages' => $languages
        ]);
    }

    public function store(BlogRequest $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
        }

        DB::beginTransaction();
        try {

            $post = new Post();
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->type = 'blog';
            $post->featured = isset($request->featured) ? 1 : 0;
            $post->status = isset($request->status) ? 1 : 0;
            $post->lang = $request->language ?? 'en';
            $post->save();

            $categories = array_merge($request->categories ?? [], $request->tags ?? []);
            if (!empty($categories)) {
                $post->categories()->sync($categories);
            }

            $preview = $this->saveFile($request, 'preview');

            $post->meta()->create([
                'key' => 'preview',
                'value' => $preview
            ]);

            $banner = $this->saveFile($request, 'banner');

            $post->meta()->create([
                'key' => 'banner',
                'value' => $banner
            ]);

            $post->meta()->create([
                'key' => 'short_description',
                'value' => $request->short_description
            ]);

            $post->meta()->create([
                'key' => 'main_description',
                'value' => $request->main_description
            ]);

            $seo['title'] = $request->meta_title;
            $seo['description'] = $request->meta_description;
            $seo['tags'] = $request->meta_tags;

            if ($request->hasFile('meta_image')) {
                $metaPreview = $this->saveFile($request, 'meta_image');
                $seo['image'] = $metaPreview;
            }

            $post->meta()->create([
                'key' => 'seo',
                'value' => json_encode($seo)
            ]);

            Artisan::call('cache:clear');

            DB::commit();

            Toastr::success(__('Blog post created successfully'));
        } catch (Throwable $th) {
            DB::rollback();
            Toastr::danger($th->getMessage());
        }
        return to_route('admin.blog.index');
    }

    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.blog.index'),
            ]
        ];
        $info = Post::where('type', 'blog')->with('postcategories', 'preview', 'seo', 'shortDescription', 'longDescription', 'seo')->findOrFail($id);
        $tags = Category::whereType('tags')->get(['title', 'id']);
        $categories = Category::whereType('blog_category')->get(['title', 'id']);

        $tagsArr = [];
        $cats = [];

        foreach ($info->postcategories as $key => $cat) {
            $category_id = $cat->category_id;

            $tagExists = $tags->where('id', $category_id)->first();

            $categoryExists = $categories->where('id', $category_id)->first();

            if ($tagExists) {
                array_push($tagsArr, $category_id);
            }

            if ($categoryExists) {
                array_push($cats, $category_id);
            }
        }


        $seo = json_decode($info->seo->value ?? '');
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Blog/Edit', [
            'info' => $info,
            'tags' => $tags,
            'categories' => $categories,
            'cats' => $cats,
            'seo' => $seo,
            'languages' => $languages,
            'buttons' => $buttons,
            'segments' => $segments,
            'tagsArr' => $tagsArr,
        ]);
    }

    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'preview' => ['nullable', 'image', 'max:1024'],
            'meta_image' => ['nullable', 'image', 'max:1024'],
            'short_description' => ['required', 'max:500'],
            'main_description' => ['required', 'max:5000'],
            'meta_title' => ['required', 'max:200'],
            'meta_description' => ['max:1000'],
            'meta_tags' => ['max:200'],
            'categories' => ['required'],
            'tags' => ['required'],
        ]);

        DB::beginTransaction();
        try {

            $post = Post::where('type', 'blog')->with('preview', 'seo')->findOrFail($id);
            $post->title = $request['title'];
            $post->slug = Str::slug($request['title']);
            $post->type = 'blog';
            $post->featured = $request['featured'] ? 1 : 0;
            $post->status = $request['status'] ? 1 : 0;
            $post->lang = $request['language'] ?? 'en';
            $post->save();
            $categories = array_merge($request['categories'], $request['tags']);
            $post->categories()->sync($categories ?? []);

            if (request()->hasFile('preview')) {

                $preview = $this->saveFile(request(), 'preview');

                $this->removeFile($post->preview?->value ?? '');

                if ($post->meta()->where('key', 'preview')->exists()) {
                    $post->preview()->update([
                        'key' => 'preview',
                        'value' => $preview
                    ]);
                } else {
                    $post->preview()->create([
                        'key' => 'preview',
                        'value' => $preview
                    ]);
                }
            }

            if (request()->hasFile('banner')) {

                $banner = $this->saveFile(request(), 'banner');

                $this->removeFile($post->banner?->value ?? '');

                if ($post->meta()->where('key', 'banner')->exists()) {
                    $post->banner()->update([
                        'key' => 'banner',
                        'value' => $banner
                    ]);
                } else {
                    $post->banner()->create([
                        'key' => 'banner',
                        'value' => $banner
                    ]);
                }
            }

            if ($post->meta()->where('key', 'short_description')->exists()) {
                $post->shortDescription()->update([
                    'key' => 'short_description',
                    'value' => $request['short_description']
                ]);
            } else {
                $post->shortDescription()->create([
                    'key' => 'short_description',
                    'value' => $request['short_description']
                ]);
            }

            if ($post->meta()->where('key', 'main_description')->exists()) {
                $post->longDescription()->update([
                    'key' => 'main_description',
                    'value' => $request['main_description']
                ]);
            } else {
                $post->longDescription()->create([
                    'key' => 'main_description',
                    'value' => $request['main_description']
                ]);
            }


            $seo['title'] = $request['meta_title'];
            $seo['description'] = $request['meta_description'];
            $seo['tags'] = $request['meta_tags'];


            if (request()->hasFile('blog.meta_image')) {
                $metaPreview = $this->saveFile(request(), 'blog.meta_image');

                $metaSeo = json_decode($post->seo->value ?? '');
                if (isset($metaSeo->image)) {
                    if (!empty($metaSeo->image)) {
                        $this->removeFile($metaSeo->image);
                    }
                }

                $seo['image'] = $metaPreview;
            }

            if ($post->meta()->where('key', 'seo')->exists()) {
                $post->seo()->update([
                    'key' => 'seo',
                    'value' => json_encode($seo)
                ]);
            } else {
                $post->seo()->create([
                    'key' => 'seo',
                    'value' => json_encode($seo)
                ]);
            }


            Artisan::call('cache:clear');

            DB::commit();
            Toastr::success(__('Updated successfully'));
        } catch (Throwable $th) {
            DB::rollback();

            Toastr::danger($th->getMessage());
        }
        return to_route('admin.blog.index');
    }

    public function destroy(Post $blog)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        if (!empty($blog->preview)) {
            $this->removeFile($blog->preview->value);
        }
        if (!empty($blog->seo)) {
            $seo = json_decode($blog->seo->value);
            if (!empty($seo->image ?? '')) {
                $this->removeFile($seo->image);
            }
        }

        $blog->delete();

        Artisan::call('cache:clear');

        return back();
    }

    public function massDestroy(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        $request->validate([
            'id' => ['required', 'array']
        ]);

        Post::whereIn('id', $request->input('id'))->delete();

        return response()->json([
            'message' => __('Blog Posts Deleted Successfully'),
            'redirect' => route('admin.blog.index')
        ]);
    }
}
