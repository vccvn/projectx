<?php
/**
 * middleware phân quyền
 * @author Doan Le
 * @copyright 2019
 * 
 * tác dụng Phân quyền cho các route
 */

namespace App\Http\Middleware;

use Closure;

class FpolyManager
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
        
        if(!($user = $request->user()) || !in_array($user->type, ['admin', 'manager', 'fpoly-manager'])) return $this->redirect($request);
        

        return $next($request);
    }


    // chuyển hướng trang
    public function redirect($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Bạn không thể thực hiện hành động này!'], 403);
        }
        return redirect()->route('errors', ['code' => 403]);
    }
}
