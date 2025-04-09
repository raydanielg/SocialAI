<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use App\Helpers\SeoMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with([
            'preview',
            'shortDescription',
            'categories' => function ($query) {
                $query->select('id', 'title', 'slug');
            }
        ])
            ->when(request('s'), function ($query) {
                $query->where('title', 'like', '%' . request('s') . '%');
            })
            ->where('status', 1)
            ->where('lang', current_locale())
            ->where('type', 'blog')
            ->latest()
            ->paginate(4);

        $categories = Category::where('type', 'blog_category')->whereHas('postCategories')->withCount('postCategories')->where('status', 1)->where('lang', app()->getLocale())->get();
        $tags = Category::where('type', 'tags')->whereHas('postCategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $recent_posts = Post::where('type', 'blog')
            ->where('lang', app()->getLocale())
            ->with([
                'shortDescription',
                'preview',
                'categories' => function ($query) {
                    $query->select('title');
                }
            ])
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $seo = SeoMeta::init('seo_blogs');

        return Inertia::render('Web/Blog/Index', compact('posts', 'categories', 'tags', 'recent_posts'));
    }


    public function show(Post $blog)
    {

        $blog->load('shortDescription', 'longDescription', 'tags', 'preview','banner', 'seo', 'categories');

        $categories = Category::where('type', 'blog_category')->whereHas('postCategories')->withCount('postCategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $tags = Category::where('type', 'tags')->whereHas('postCategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $recent_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('preview')->where('status', 1)->latest()->take(4)->get();

        $categoryIds = $blog->categories()->pluck('id');

        $related_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('preview')->where('status', 1)
            ->whereHas('postCategories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->with('categories:id,title')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $meta = (array) json_decode($blog->seo->value ?? '');
        $seo = SeoMeta::set($meta);

        $nextBlog = Post::with('preview')->where('type', 'blog')->where('id', '>', $blog->id)->where('status', 1)->first();
        $prevBlog = Post::with('preview')->where('type', 'blog')->where('id', '<', $blog->id)->where('status', 1)->first();

        return Inertia::render('Web/Blog/Show', compact('blog', 'categories', 'tags', 'recent_blogs', 'related_blogs', 'nextBlog', 'prevBlog'));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('type', 'blog_category')
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        $posts = Post::where('type', 'blog')
            ->where('lang', app()->getLocale())
            ->whereHas('postCategories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->with('shortDescription', 'preview', 'categories:id,title')
            ->where('status', 1)
            ->latest()
            ->paginate(4);

        $recent_posts = Post::where('type', 'blog')
            ->where('lang', app()->getLocale())
            ->with('shortDescription', 'preview', 'categories:id,title')
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::where('type', 'blog_category')
            ->where('status', 1)
            ->whereHas('postCategories')
            ->withCount('postCategories')
            ->get();

        $tags = Category::where('type', 'tags')
            ->whereHas('postCategories')
            ->where('status', 1)
            ->get();

        $seo = SeoMeta::init('seo_blog_category', $category->title);

        return Inertia::render('Web/Blog/Index', compact('posts', 'request', 'recent_posts', 'categories', 'tags', 'seo'));
    }

    public function tag(Request $request, $slug)
    {
        $tag = Category::where('type', 'tags')
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        $tags = Category::where('type', 'tags')
            ->whereHas('postCategories')
            ->where('status', 1)
            ->get();

        $posts = Post::where('type', 'blog')
            ->where('lang', app()->getLocale())
            ->with('shortDescription', 'preview', 'categories:id,title')
            ->whereHas('postCategories', function ($query) use ($tag) {
                $query->where('category_id', $tag->id);
            })
            ->where('status', 1)
            ->latest()
            ->paginate(4);

        $recent_posts = Post::where('type', 'blog')
            ->where('lang', app()->getLocale())
            ->with('shortDescription', 'preview')
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::where('type', 'blog_category')
            ->whereHas('postCategories')
            ->withCount('postCategories')
            ->where('status', 1)
            ->where('lang', app()->getLocale())
            ->get();

        $seo = SeoMeta::set(['title' => $tag->title]);

        return Inertia::render('Web/Blog/Index', compact('posts', 'recent_posts', 'categories', 'tags'));
    }

}
