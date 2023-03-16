<?php
namespace App\Engines;
use Illuminate\Support\Str;

Class HelperEngine{
    public function __call($name, $arguments)
    {
        if(is_callable($name)){
            return $name(...$arguments);
        }
        if(is_callable($fun = Str::snake($name))){
            return $fun(...$arguments);
        }
        if(is_callable($func = Str::camel($name))){
            return $func(...$arguments);
        }
        return null;
    }

    public static function __callStatic($name, $arguments)
    {
        if(is_callable($name)){
            return $name(...$arguments);
        }
        if(is_callable($fun = Str::snake($name))){
            return $fun(...$arguments);
        }
        if(is_callable($func = Str::camel($name))){
            return $func(...$arguments);
        }
        return null;
    }

    public function __get($name)
    {
        if(is_callable($name)){
            return $name();
        }
        if(is_callable($fun = Str::snake($name))){
            return $fun();
        }
        if(is_callable($func = Str::camel($name))){
            return $func();
        }
        return null;
    }

    public function __set($name, $value)
    {
        
    }
}