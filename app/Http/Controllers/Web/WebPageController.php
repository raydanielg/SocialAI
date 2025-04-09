<?php

namespace App\Http\Controllers\Web;

use App\Models\Job;
use App\Models\Plan;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Service;
use App\Models\Category;
use App\Helpers\SeoMeta;
use App\Models\Integration;
use App\Http\Controllers\Controller;

class WebPageController extends Controller
{

    public function home()
    {

        if (request()->is('install/*') || !file_exists(base_path('public/uploads/installed'))) {
            return redirect('/install');
        }

        SeoMeta::init('seo_home');

        $featuredService = Service::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->first();

        $services = Service::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->where('id', '!=', $featuredService?->id ?? 0)
            ->limit(10)
            ->get();


        $blogs = Post::query()
            ->with('categories', 'preview')
            ->where('type', 'blog')
            ->where('status', 1)
            ->limit(3)
            ->get();

        $testimonials = Post::where('type', 'testimonial')
            ->with('excerpt', 'preview')
            ->latest()
            ->get();

        $integrations = Integration::active()->inRandomOrder()->limit(4)->get();

        return Inertia::render('Web/Home/Index', [
            'home' => get_option('home_page', true),
            'featuredService' => $featuredService,
            'services' => $services,
            'blogs' => $blogs,
            'testimonials' => $testimonials,
            'integrations' => $integrations,
        ]);
    }

    public function about()
    {
        SeoMeta::init('seo_about');
        $about = get_option('about_page', true);

        $brands = Category::whereType('partner')->where('status', 1)->latest()->get();
        $teams = Post::with('description', 'preview', 'excerpt')
            ->where('type', 'team')
            ->latest()
            ->where('status', 1)
            ->limit(4)
            ->get();

        return Inertia::render('Web/About/Index', [
            'about' => $about,
            'brands' => $brands,
            'teams' => $teams,
            'jobs' => Job::where('is_active', 1)->latest()->take(5)->get(),
        ]);
    }

    public function projects()
    {
        SeoMeta::init('seo_projects');
        return Inertia::render('Web/Projects/Index', []);
    }

    public function team()
    {
        SeoMeta::init('seo_team');

        $teams = Post::where('type', 'team')->with('preview', 'excerpt')->where('status', 1)->latest()->get();
        return Inertia::render('Web/Team', [
            'teams' => $teams
        ]);
    }

    public function pricing()
    {
        SeoMeta::init('seo_pricing');

        $plans = Plan::query()
            ->where('status', 1)
            ->orderBy('price', 'asc')
            ->where('is_default', 0)
            ->get();

        $about = get_option('about_page', true);
        $home = get_option('home_page', true);
        $brands = Category::whereType('partner')->latest()->get();

        $faqs = Post::where('type', 'faq')->with(['excerpt', 'faq_categories:id,title'])
            ->latest()
            ->get();

        $testimonials = Post::where('type', 'testimonial')->with(['excerpt', 'preview'])->limit(6)->get();

        $planSettings = get_option('plan');
        $planByDays = $plans->map(function ($plan) {
            return [
                'days' => $plan->days,
                'duration' => $plan->days == 30 ? 'monthly' : ($plan->days == 365 ? 'yearly' : 'lifetime')
            ];
        })->sortBy('days')->unique()->values();

        return Inertia::render('Web/Pricing', [
            'plans' => $plans,
            'home' => $home,
            'about' => $about,
            'brands' => $brands,
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'planSettings' => $planSettings,
            'planByDays' => $planByDays
        ]);
    }

    public function faq()
    {
        SeoMeta::init('seo_faq');

        $faqs = Post::where('type', 'faq')->with(['excerpt', 'faq_categories:id,title'])
            ->latest()
            ->get();

        return Inertia::render('Web/Faq', compact('faqs'));
    }

    public function page($slug)
    {
        $page = Post::with('description', 'seo')->where(['slug' => $slug, 'status' => 1])->firstOrFail();

        $seo = (array) json_decode($page->seo?->value ?? []);

        SeoMeta::set($seo);

        return Inertia::render('Web/CustomPage', compact('page'));
    }
}
