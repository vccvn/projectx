<?php

namespace App\Http\Middleware;

use Closure;

class BranchMiddleware
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
        
        if(!($user = $request->user()) || !in_array($user->type, ['admin', 'manager', 'branch-manager', 'branch-master']) || ($user->id != web_setting('owner_id'))) return $this->redirect($request);
        

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
