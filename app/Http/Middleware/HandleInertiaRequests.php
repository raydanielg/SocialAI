<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Inertia\Middleware;
use App\Helpers\SeoMeta;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Helpers\PageHeader;
use App\Services\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Nwidart\Modules\Facades\Module;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    // protected $rootView = 'app';


    public function rootView(Request $request)
    {
        $segments = $request->segments();
        $segment = $segments[0] ?? null;
        $layoutName = in_array($segment, ['admin', 'user']) ? 'admin' : 'default';
        $layoutPath = 'layouts.' . $layoutName;
        return $layoutPath;
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        if (request()->is('install/*') || !file_exists(base_path('public/uploads/installed'))) {
            return [];
        }

        $primaryData = get_option('primary_data', true);

        $locale = current_locale();
        $menu = Cache::remember(
            'menu_' . $locale,
            env('CACHE_LIFETIME', 1800),
            function () use ($locale) {
                return Menu::where('lang', $locale)->where('status', 1)->oldest()->get();
            }
        );

        $app_name = Cache::remember(
            'app_name_' . $locale,
            env('CACHE_LIFETIME', 1800),
            function () {
                return env('APP_NAME', 'Laravel');
            }
        );

        $permissions = [];
        $notifications = [];

        if (Auth::check()) {
            /**
             * @var \App\Models\User
             */
            $user = Auth::user();

            // permissions
            if ($user->isAdmin()) {
                $permissions = $user->getAllPermissions()->pluck('name');
            }

            // notifications
            $notifications = Notification::query()
                ->when($user->role != 'admin', fn($q) => $q->where('user_id', $user->id)->where('for_admin', 0))
                ->when($user->role == 'admin', fn($q) => $q->where('for_admin', 1))
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    $item->title_short = Str::limit($item->title, 30, '...');
                    $item->comment_short = Str::limit($item->comment, 35, '...');
                    return $item;
                }) ?? [];
        }
        $activeModule = null;
        $requestSegmentModule = $request->segments()[1] ?? false;
        $modules = Module::collections()
            ->keys()
            ->map(fn($key) => strtolower($key))
            ->values()
            ->all();


        if (collect($modules)->contains($requestSegmentModule)) {
            $activeModule = $requestSegmentModule;
        } elseif ($request->is('user/*')) {
            $activeModule = 'user';
        }
        return array_merge(parent::share($request), [

            // only auth
            'auth' => [
                'name' => Auth::check() ? Auth::user()->name : null,
            ],
            'user' => Auth::check() ? Auth::user() : null,
            'notifications' => $notifications,

            // static values
            'languages' => get_option('languages', false),
            'currency' => get_option('base_currency', false),
            'primaryData' => $primaryData,
            'app_name' => $app_name,

            // if auth
            'permissions' => $permissions,

            // dynamic values
            'locale' => session('locale', 'en'),
            'toast' => fn() => Toastr::Toast(),
            'pageHeader' => fn() => PageHeader::toArray(),


            // conditional required
            // Web
            'menus' => $menu,
            'seoMeta' => fn() => SeoMeta::get(),
            'homeData' => fn() => $request->is('/') ? get_option('home_page') : [],
            'newsletter_api' => fn() => env('NEWSLETTER_API_KEY', null),

            'activeModule' => $activeModule,
        ]);
    }
}
