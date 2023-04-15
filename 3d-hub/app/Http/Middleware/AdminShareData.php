<?php

namespace App\Http\Middleware;

use Closure;

class AdminShareData
{
    public static $isShare = false;
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
        $sidebar_menu = get_admin_menu(get_web_type());
        add_js_data('crazyweb','get_notice_url', route('admin.notices.get-json'));
        add_js_data('location_data','urls', [
            'region_options' => route("client.location.regions.options"),
            'district_options' => route("client.location.districts.options"),
            'ward_options' => route("client.location.wards.options")
        ]);
        view()->share(compact('sidebar_menu'));
        self::$isShare = true;
            
        return $next($request);
    }
}