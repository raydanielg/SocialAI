<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role == 'user' && $request->user()->status == 1) {
            $menu = Cache::remember(
                'menu_sidebar' . 'user_menu',
                env('CACHE_LIFETIME', 1800),
                fn() => MenuService::getMenu('user')
            );
            Inertia::share(['sidebar_menu'  => $menu]);
            return $next($request);
        } elseif ($request->user()->status != 1) {
            Auth::logout();
            Session::flash('danger', __('Your Account Has Disabled By Admin Please Contact Us'));
            return redirect('/login');
        }
        return redirect(route($request->user()->getDashboardRoute()));
    }
}
