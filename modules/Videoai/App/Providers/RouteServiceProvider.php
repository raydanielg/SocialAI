<?php

namespace Modules\Videoai\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminete\Router\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Modules\Videoai\App\Http\Controllers';
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware(['web', 'auth', 'user'])
            ->prefix('user/videoai')
            ->name('user.videoai.')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Videoai', '/routes/user.php'));

        Route::middleware(['web', 'auth', 'admin'])
            ->prefix('admin/videoai')
            ->as('admin.videoai.')
            ->group(module_path('Videoai', '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api/videoai')
            ->name('videoai.api.')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Videoai', '/routes/api.php'));
    }
}
