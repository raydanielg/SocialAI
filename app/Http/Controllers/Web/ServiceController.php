<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use App\Models\Service;
use App\Helpers\SeoMeta;
use App\Models\Category;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        SeoMeta::init('seo_services');



        $featuredService = Service::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->first();

        if (request('page') > 1) {
            $featuredService = false;
        }

        $services = Service::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('id', '!=', $featuredService?->id ?? 0)
            ->latest()
            ->paginate(10);

        $testimonials = Post::where('type', 'testimonial')->with(['excerpt', 'preview'])->limit(6)->get();

        $faqs = Post::where('type', 'faq')->with(['excerpt', 'faq_categories:id,title'])
            ->latest()
            ->where('lang', App::getLocale())
            ->get();

        return inertia('Web/Services/Index', [
            'featuredService' => $featuredService,
            'services' => $services,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'service_page' => get_option('service_page', true),
            'home_page' => get_option('home_page', true),
        ]);
    }

    public function categoryShow($slug)
    {
        SeoMeta::init('seo_services');

        $category_id = Category::where('slug', $slug)->where('status', 1)->value('id');
        $featuredService = Service::query()
            ->with('category')
            ->where('category_id', $category_id)
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->first();

        $services = Service::query()
            ->with('category')
            ->where('is_active', 1)
            ->where('category_id', $category_id)
            ->whereNot('id', $featuredService?->id ?? 0)
            ->limit(10)
            ->get();

        return inertia('Web/Services/Categories/Index', [
            'services' => $services,
            'service_page' => get_option('service_page', true),
            'featuredService' => $featuredService
        ]);
    }

    public function show(Service $service)
    {
        SeoMeta::set($service->meta);
        $categories = Category::where('status', 1)->where('type', 'service')->latest()->get();
        $servicePage = get_option('service_page', true);
        $testimonials = Post::where('type', 'testimonial')->with(['excerpt', 'preview'])->limit(6)->get();

        return inertia('Web/Services/Show', [
            'service' => $service,
            'testimonials' => $testimonials,
            'categories' => $categories,
            'servicePage' => $servicePage
        ]);
    }
}
