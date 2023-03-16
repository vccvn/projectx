<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($request->isMethod('post')){
                if(0 === strpos($request->headers->get('Accept'), 'application/json')){
                    return response()->json([
                        'status' => true,
                        'data' => ['redirect' => route('dashboard')]
                    ], 200);
                }
                return redirect()->route('home');
                
            }
            return redirect('/home');
        }

        return $next($request);
    }
}
