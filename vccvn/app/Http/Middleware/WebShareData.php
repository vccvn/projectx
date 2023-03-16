<?php

namespace App\Http\Middleware;

use App\Engines\CacheEngine;
use App\Web\Option;
use App\Web\Options;
use Closure;

class WebShareData
{
    static $isShare = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // chay qua cai nay de share data thoi

        if(self::$isShare) return $next($request);
        $owner = get_owner();
        $options = app(Option::class);
        $options->updateCache();
        set_web_data('options', $options);
        $siteinfo = siteinfo();
        $settings = system_setting();
        $urlsettings = $options->urlsettings;
        view()->share(compact('options', 'siteinfo', 'settings', 'urlsettings'));
        self::$isShare = true;
            
        return $next($request);
    }
}