<?php

namespace App\Http\Middleware;

use Closure;

use Crazy\Files\Filemanager;
use App\Repositories\Sliders\SliderRepository;
use App\Repositories\Sliders\ItemRepository;

class SliderMiddleware
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

        if(($slider_id = $request->route('slider')) && $slider = (new SliderRepository)->first(['id' => $slider_id, 'deleted' => 0])){
            // dd($slider_id);
            ItemRepository::setSliderID($slider->id);
            set_web_data('slider', $slider);
            view()->share('slider', $slider);
            static::$checked = true;
            return true;
        }
        return false;
    }
}