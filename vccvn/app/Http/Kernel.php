<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'manager.share' => \App\Http\Middleware\ManagerShareData::class,
        'install.check' => \App\Http\Middleware\CheckInstall::class,
        'cart.check' => \App\Http\Middleware\CheckCart::class,
        'install.denied' => \App\Http\Middleware\AccessDenied::class,
        'cpanel.share' => \App\Http\Middleware\CPanelShare::class,
        'cpanel.manager' => \App\Http\Middleware\CPanelManager::class,
        'wp.share' => \App\Http\Middleware\WPShare::class,
        'wp.manager' => \App\Http\Middleware\WPManager::class,
        'admin.share' => \App\Http\Middleware\AdminShareData::class,
        'manager' => \App\Http\Middleware\Manager::class,
        'permission' => \App\Http\Middleware\Permission::class,
        'dynamic.post' => \App\Http\Middleware\DynamicPost::class,
        'slider.item' => \App\Http\Middleware\SliderMiddleware::class,
        'menu.item' => \App\Http\Middleware\MenuMiddleware::class,
        'next' => \App\Http\Middleware\NextMiddleware::class,
        'web.share' => \App\Http\Middleware\WebShareData::class,
        'client.auth' => \App\Http\Middleware\ClientAuth::class,
        '2fa' => \PragmaRX\Google2FALaravel\Middleware::class,
        'access.log' => \App\Http\Middleware\AccessLog::class,
        'https.redirect' => \App\Http\Middleware\HttpsProtocol::class,
        'branch.manager' => \App\Http\Middleware\BranchMiddleware::class,
        'branch.share' => \App\Http\Middleware\BranchShare::class,


    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
        \App\Http\Middleware\CheckInstall::class,
        \App\Http\Middleware\HttpsProtocol::class,
        \App\Http\Middleware\Manager::class,
        \App\Http\Middleware\Permission::class,
        \PragmaRX\Google2FALaravel\Middleware::class,
        \App\Http\Middleware\ManagerShareData::class,
        \App\Http\Middleware\AdminShareData::class,
        \App\Http\Middleware\DynamicPost::class,
        \App\Http\Middleware\SliderMiddleware::class,
        \App\Http\Middleware\AccessLog::class,
    ];
}
