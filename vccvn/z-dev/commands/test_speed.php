<?php
if(!function_exists('test_speed')){
    /**
     * test_speed
     * 
     */
    function test_speed($first, $second, $time=10000, $firstArgs = null, $secondArgs = null)
    {
        
        $firstEnd = 0;
        if(function_exists($first)){
            if(!is_array($firstArgs)) $firstArgs = explode(',', $firstArgs);
            echo "first Args\n";
            print_r($firstArgs);
            $firstStart = microtime(true);
            for ($i=0; $i < $time; $i++) { 
                call_user_func_array($first, $firstArgs);
            }
            $firstEnd = microtime(true) - $firstStart;
        }
        $secondEnd = 0;
        if(function_exists($second)){
            if(!is_array($secondArgs)) $secondArgs = explode(',', $secondArgs);
            echo "second Args\n";
            print_r($secondArgs);
            $secondStart = microtime(true);
            for ($i=0; $i < $time; $i++) { 
                call_user_func_array($second, $secondArgs);
            }
            $secondEnd = microtime(true) - $secondStart;
        }

        

        echo "$first run in $firstEnd\n$second run in $secondEnd";
    }
}