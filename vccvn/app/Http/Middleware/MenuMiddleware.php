<?php

namespace App\Http\Middleware;

use Closure;

use Crazy\Files\Filemanager;
use App\Repositories\Menus\MenuRepository;
use App\Repositories\Menus\ItemRepository;

class MenuMiddleware
{
    protected static $checked = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(static::$checked || static::check($request)) return $next($request);
        // chay qua cai nay de share data thoi
        return redirect()->route('errors', ['code' => 404]);
    }

    public static function check($request)
    {
        if(static::$checked) return true;

        if(($menu_id = $request->route('menu_id')) && $menu = app(MenuRepository::class)->first(['id' => $menu_id, 'deleted' => 0])){
            ItemRepository::setMenuID($menu->id);
            set_web_data('menu', $menu);
            view()->share('menu', $menu);
            static::$checked = true;
            return true;
        }
        return false;
    }
}