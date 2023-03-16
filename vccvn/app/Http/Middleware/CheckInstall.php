<?php
/**
 * middleware phân quyền
 * @author Doan Le
 * @copyright 2019
 *
 * tác dụng Phân quyền cho các route
 */

namespace App\Http\Middleware;

use App\Repositories\Users\OwnerRepository;
use Closure;

class CheckInstall
{
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

        if($request->user()) return $next($request);

        if(app(OwnerRepository::class)->count(['status' => 1,'type' => ['admin', 'manager']])) return $this->login($request);

        return $this->redirect($request);
    }

    public function login($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Vui lòng đăng nhập để thực hiện hành động này!', 'redirect' => route('login')]);
        }
        return redirect()->route('login');
    }


    // chuyển hướng trang
    public function redirect($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Bạn không thể thực hiện hành động này!', 'redirect' => route('install.form')]);
        }
        return redirect()->route('install.form');
    }
}
