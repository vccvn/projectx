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

class AccessDenied
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->user()) return $this->home($request, $next);

        if(app(OwnerRepository::class)->count(['status' => 1,'type' => ['admin', 'manager']])) return $this->redirect($request);

        return $next($request);
    }

    public function home($request)
    {
        if (0 === strpos($request->headers->get('Accept'), 'application/json'))
        {
            return response()->json(['status' => false, 'message'=>'Thao tác không hợp lệ', 'redirect' => route('home')]);
        }
        return redirect()->route('home');
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
