<?php

namespace App\Http\Middleware;

use App\Repositories\Orders\CartRepository;
use Closure;

class CheckCart
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

        CartRepository::checkCartID($request);
        return $next($request);
    }

}
