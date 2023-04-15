<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Web\SettingRepository;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebApiRoutes();
        $this->mapApiRoutes();
        $this->mapAdminRoutes();
        $this->mapWebRoutes();
        
        
    }



    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapNotFoundRoutes()
    {
        Route::middleware(['web', 'secure'])
            ->namespace($this->namespace . '\NotFound')
            ->group(base_path('routes/notfound.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapManagerRoutes()
    {
        Route::middleware(['web', 'manager.share', 'secure'])
            ->namespace($this->namespace . '\Manager')
            ->group(base_path('routes/manager.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapLandingPageRoutes()
    {
        Route::middleware(['web', 'secure'])
            ->namespace($this->namespace . 'Landing')
            ->group(base_path('routes/landing.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth', 'permission', 'admin.share', 'secure'])
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'access.log', 'secure'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('apiv2')
        ->middleware(['api', 'secure'])
            ->namespace($this->namespace . '\Apis')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebApiRoutes()
    {
        Route::prefix('api')
        ->middleware(['api', 'secure'])
            ->namespace($this->namespace . '\Apis\Clients')
            ->group(base_path('routes/client/api.php'));
    }
}
