<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Inertia\Inertia;
use App\Helpers\SeoMeta;
use App\Models\Category;
use App\Models\Integration;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{
    public function index()
    {
        SeoMeta::init('seo_integrations');

        $featuredIntegrations = Integration::active()->where('is_featured', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $integrations = Integration::active()
            ->where('is_featured', 0)
            ->limit(10)
            ->get();

        return Inertia::render('Web/Integrations/Index', [
            'home' => get_option('home_page', true),
            'integration_page' => get_option('integration_page', true),
            'integrations' => $integrations,
            'integrations_featured' => $featuredIntegrations
        ]);
    }

    public function show(Integration $integration)
    {
        SeoMeta::set($integration->meta);

        $sidebarIntegrations = Integration::active()
            ->limit(10)
            ->get();

        return inertia('Web/Integrations/Show', [
            'integration' => $integration,
            'sidebarIntegrations' => $sidebarIntegrations,
            'servicePage' => get_option('service_page', true)
        ]);
    }
}
