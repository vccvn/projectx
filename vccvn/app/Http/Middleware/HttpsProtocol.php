<?php

namespace App\Http\Middleware;

use App\Web\Option;
use App\Web\Options;
use Closure;

class HttpsProtocol
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
        $options = app(Options::class);
        
        if($urls = $options->urlsettings){
            
            if (($general = $urls->general) && $general->https_redirect && !$request->secure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        

        return $next($request);
    }
}
