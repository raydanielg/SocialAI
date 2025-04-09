<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Toastr;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class AdminMiddleware
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
        if (Auth::check() && Auth::user()->role == 'admin' &&  Auth::user()->status == 1) {
            $menu = Cache::remember(
                'menu_sidebar' . 'admin_menu',
                env('CACHE_LIFETIME', 1800),
                fn() => MenuService::getMenu('admin')
            );
            Inertia::share(['sidebar_menu'  => $menu]);
            return $next($request);
        } elseif (Auth::check() && Auth::user()->status != 1) {
            Auth::logout();
            Toastr::danger(__('Your Account Is Deactivated'));
        }

        return redirect('/login');
    }
}
