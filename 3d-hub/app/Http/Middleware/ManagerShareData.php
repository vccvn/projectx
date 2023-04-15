<?php

namespace App\Http\Middleware;

use Closure;
use App\Engines\MenuEngine;

class ManagerShareData
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
        
        $filename = 'sidebar-menu';
        $menu = new MenuEngine('manager/menus');
        $sidebar_menu = $menu->get($filename);

        add_js_data('crazyweb','get_notice_url', route('notices.get-json'));
        view()->share(compact('sidebar_menu'));
        self::$isShare = true;
            
        return $next($request);
    }
}
