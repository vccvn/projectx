<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Users\BranchRepository;
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
        $setting = new SettingRepository();
        // nếu có subdomain
        $domain = get_non_www_domain();
        if ($subdomain = get_sys_subdomain()) {
            $sdm = strtolower($subdomain);
            set_web_data('___domain_type', 'subdomain');
            $manager = ['webmaster', 'webadmin', 'manager', 'quantri', 'trangquantri'];
            // neu subdomain ko nam trong danh sach datc biet
            $inManager = in_array($sdm, $manager);
            if (in_array($sdm, ['cpanel', 'webadmin'])) {
                $this->mapCPanelRoutes();
            } elseif (in_array($sdm, ['wp', 'wordpress'])) {
                $this->mapWPRoutes();
            } elseif (in_array($sdm, ['payments', 'thanhtoan', 'thanh-toan'])) {
                $this->mapPaymentRoutes();
            } elseif (!$inManager && !in_array($subdomain, ['api', 'www'])) {

                // neu tim duoc tai khoan co subdomain tuong ung
                if ($owner_web_setting = $setting->getActiveUserBySubDomain($subdomain)) {
                    if ($owner_web_setting->account_type != 'demo'  || ($owner_web_setting->expired_at && strtotime($owner_web_setting->expired_at) > time())) {
                        set_web_data('__owner_web_setting', $owner_web_setting);
                        if ($owner_web_setting->web_type == 'branch') {
                            //
                            BranchRepository::setMasterId($owner_web_setting->user_id);
                            $this->mapBranchRoutes();
                        } else{
                            
                            $setting->setOwnerID($owner_web_setting->owner_id);
                            // dd($owner_web_setting);
                            if ($owner_web_setting->web_type == 'wordpress') {
                                $this->mapWPClientRoutes();
                            } else {
                                $this->mapWebApiRoutes();
                                $this->mapAdminRoutes();
                                $this->mapWebRoutes();
                            }
                        }
                    } else {
                        $this->expiredMap();
                    }
                }
                // nếu không có tài khoản thì trỏ đến trang ko tim thay
                else {
                    $this->mapNotFoundRoutes();
                }
            }
            // nếu có trong danh sach cac trang quan tri
            elseif ($inManager) {
                $this->mapManagerRoutes();
            }
            // sub domain la api
            elseif (in_array($subdomain, ['api', 'support'])) {
                $this->mapApiRoutes();
                $this->mapSupportRoutes();
            }
            // trang gioi thieu cong ti
            else {
                $this->mapLandingPageRoutes();
            }
        } elseif ($domain != 'localhost') {
            // neu tim duoc tai khoan co subdomain tuong ung
            if ($owner_web_setting = $setting->getActiveUserByPrimaryDomain($domain)??$setting->getActiveUserByAliasDomain($domain)) {
                if ($owner_web_setting->account_type == 'demo' || ($owner_web_setting->expired_at && strtotime($owner_web_setting->expired_at) > time())) {
                    set_web_data('__owner_web_setting', $owner_web_setting);
                    // set id cua tai khoan
                    $setting->setOwnerID($owner_web_setting->owner_id);

                    $this->mapWebApiRoutes();
                    $this->mapAdminRoutes();
                    $this->mapWebRoutes();
                } else {
                    $this->expiredMap();
                }
            }
            // nếu không có tài khoản thì trỏ đến trang ko tim thay
            elseif (!in_array($domain, get_system_config('domain_list'))) {
                $this->mapNotFoundRoutes();
            } else {
                $this->mapLandingPageRoutes();
            }
            //
        }
    }


    public function expiredMap()
    {
        if (get_domain() != 'localhost') {
            abort(419, "Hết hạn hoạt đông");
        }
    }

    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapNotFoundRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\NotFound')
            ->group(base_path('routes/notfound.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapManagerRoutes()
    {
        Route::middleware(['web', 'manager.share'])
            ->namespace($this->namespace . '\Manager')
            ->group(base_path('routes/manager.php'));
    }

    protected function mapBranchRoutes()
    {
        Route::middleware(['web', 'branch.share'])
            ->namespace($this->namespace . '\Branch')
            ->group(base_path('routes/branch.php'));
    }
    protected function mapPaymentRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace . '\Apis\Payments')
            ->group(base_path('routes/api/payments.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapWPRoutes()
    {
        Route::middleware(['web', 'wp.share'])
            ->namespace($this->namespace . '\Wordpress')
            ->group(base_path('routes/wp.php'));
    }
    protected function mapWPClientRoutes()
    {
        Route::middleware(['web', 'wp.share'])
            ->namespace($this->namespace . '\Wordpress')
            ->group(base_path('routes/wp-client.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapCPanelRoutes()
    {
        Route::middleware(['web', 'cpanel.share'])
            ->namespace($this->namespace . '\CPanel')
            ->group(base_path('routes/cpanel.php'));
    }
    /**
     * dinh nghia cac route
     * @return void
     */
    protected function mapLandingPageRoutes()
    {
        Route::middleware('web')
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
            ->middleware(['web', 'auth', 'https.redirect', 'permission', 'admin.share'])
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
        Route::middleware(['web', 'https.redirect', 'access.log'])
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
    protected function mapWebApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Apis\Clients')
            ->group(base_path('routes/client/api.php'));
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
        Route::middleware('api')
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
    protected function mapSupportRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Support')
            ->group(base_path('routes/support.php'));
    }
}
