<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('layout', function ($expression) {
            return "@extends(\$_layout.{$expression})";
        });


        // post
        Blade::directive('posts', function ($expression) {
            return "<?php if(\$total = get_posts({$expression}))): ?>";
        });
        Blade::directive('endposts', function ($expression) {
            return "<?php endif; ?>";
        });
        
        Blade::directive('count', function ($expression) {
            $pre = "";
            if(count($t = explode('=', $expression))){
                $a = trim($t[0]);
                $pre = "is_countable($a) && \$__total = count($a)";
            }else{
                $pre = "is_countable($expression) && \$__total = count($expression)";
            }
            return "<?php if(({$expression}) && $pre): ?>";
        });
        Blade::directive('ifcount', function ($expression) {
            $pre = "";
            if(count($t = explode('=', $expression))){
                $a = trim($t[0]);
                $pre = "is_countable($a) && \$__total = count($a)";
            }else{
                $pre = "is_countable($expression) && \$__total = count($expression)";
            }
            return "<?php if(({$expression}) && $pre): ?>";
        });
        Blade::directive('endcount', function ($expression) {
            return "<?php endif; ?>";
        });
        Blade::directive('endifcount', function ($expression) {
            return "<?php endif; ?>";
        });

        Blade::directive('extract', function ($expression) {
            $pre = "";
            $v = $expression;
            if(preg_match('/[\s\t\r\n]*\$[A-z0-9_][\s\t\r\n]*\=.*/si', $expression)){
                $t = explode('=', $expression);
                $a = trim($t[0]);
                $pre = "is_array($a)";
                $v = $a;
            }else{
                $pre = "is_array($expression)";
            }
            return "<?php if(({$expression}) && $pre): 
                extract($v);
            endif; ?>";
        });

        
        

    
    }
}
