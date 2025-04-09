<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminete\Router\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const ADMIN_DASHBOARD = '/admin/dashboard';
    public const USER_DASHBOARD = '/user/dashboard';
    // public const EMPLOYER_DASHBOARD = '/employer/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';


    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware('web')->group([
                base_path('routes/auth.php'),
                base_path('routes/gateway.php'),
                base_path('routes/admin.php'),
                base_path('routes/user.php'),
                base_path('routes/cron.php'),
                base_path('routes/web.php'),
            ]);

            if (app()->isLocal()) {
                Route::middleware('web')->group(base_path('routes/dev.php'));
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
