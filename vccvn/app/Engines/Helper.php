<?php
namespace App\Engines;
use Illuminate\Support\Str;
use Mobile_Detect;

Class Helper{
    protected static $device = null;
    public static function _device(){
        if(!static::$device) static::$device = app(Mobile_Detect::class);
        return static::$device;
    }
    public function __call($name, $arguments)
    {
        $n = strtolower($name);
        $is = substr($n, 0, 2);
        if($is == 'is' && in_array(substr($n, 2), ['mobile', 'tablet', 'desktop']) ){
            return static::_device()->{$name}(...$arguments);
        }
        elseif(in_array($n, ['device', 'getDevice'])) return static::_device();
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
        $n = strtolower($name);
        $is = substr($n, 0, 2);
        if($is == 'is' && in_array(substr($n, 2), ['mobile', 'tablet', 'desktop']) ){
            return static::_device()->{$name}(...$arguments);
        }
        elseif(in_array($n, ['device', 'getdevice'])) return static::_device();
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