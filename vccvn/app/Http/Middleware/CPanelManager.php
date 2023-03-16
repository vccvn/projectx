<?php
/**
 * middleware phân quyền
 * @author Doan Le
 * @copyright 2019
 *
 * tác dụng Phân quyền cho các route
 */

namespace App\Http\Middleware;

use App\Engines\MenuEngine;
use App\Repositories\Profiles\ProfileRepository;
use Closure;

class CPanelManager
{
    public static $isShare = false;

    protected static $checkedModules = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if(!($user = $request->user())) return $this->redirect($request);
        
        $userWebSettings = $user->userWebSetting;
        if(!$userWebSettings || $userWebSettings->web_type != 'vcchosting') return $this->redirect($request);
        ProfileRepository::addOwnerID($user->id);
        $filename = 'sidebar-menu';
        $menu = new MenuEngine('cpanel/menus');
        $sidebar_menu = $menu->get($filename);

        add_js_data('crazyweb','get_notice_url', route('notices.get-json'));
        view()->share(compact('sidebar_menu'));
        self::$isShare = true;

        return $next($request);
    }


    // chuyển hướng trang
    public function redirect($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Bạn không thể thực hiện hành động này!'], 403);
        }
        abort(403, "Truy cập bị từ chối");
        return redirect()->route('errors', ['code' => 403]);
    }
}
