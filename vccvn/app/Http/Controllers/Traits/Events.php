<?php

namespace App\Http\Controllers\Traits;

use Closure;

/**
 * các phương thúc với event
 * @method static on(string $event, Closure $closure) lắng nghe sự kiện
 * @method static addEventListener(string $event, Closure $closure) lắng nghe sự kiện
 * @method static trigger(string $event, ...$params) Kích hoạt sự kiện
 * @method static fire(string $event, ...$params) Kích hoạt sự kiện
 * 
 * 
 */
trait Events
{
    protected static $events = [];

    /**
     * khai báo mảng chứa các event cho class
     *
     * @return void
     */
    public static function makeEventContainerByCurrentClassName()
    {
        $classname = static::class;
        if (!array_key_exists($classname, static::$events)) {
            static::$events[$classname] = [];
        }
    }

    /**
     * lắng nghe sự kiện
     *
     * @param string $event
     * @param \Closure $closure
     * @return bool
     */
    protected static function _on($event, $closure)
    {
        if (is_string($event) && is_callable($closure)) {
            $event = strtolower($event);
            static::makeEventContainerByCurrentClassName();
            if(!array_key_exists($event, static::$events[static::class])){
                static::$events[static::class][$event] = [];
            }
            static::$events[static::class][$event][] = $closure;
            return true;
        }
        return false;
    }
    /**
     * lắng nghe sự kiện
     *
     * @param string $event
     * @param \Closure $closure
     * @return bool
     */

    public function addEvent($event, $closure)
    {
        return static::_on($event, $closure);
    }
    /**
     * lắng nghe sự kiện
     *
     * @param string $event
     * @param \Closure $closure
     * @return bool
     */

    public function addEventListener($event, $closure)
    {
        return static::_on($event, $closure);
    }

    /**
     * gọi sự kiện
     *
     * @param string $event
     * @param mixed ...$params
     * @return mixed
     */
    public static function callEvent($event, ...$params)
    {
        if (is_string($event)) {
            $event = strtolower($event);
            static::makeEventContainerByCurrentClassName();
            if(array_key_exists($event, static::$events[static::class]) && count(static::$events[static::class][$event])){
                $arr = [];
                foreach (static::$events[static::class][$event] as $closure) {
                    $arr[] = $closure(...$params);
                }
                return $arr;
            }
        }
        return null;
    }

    /**
     * Kiểm tra event có tồn tại hay chưa
     *
     * @param string $event
     * @return bool
     */
    public static function eventExists($event)
    {
        if (is_string($event)) {
            $event = strtolower($event);
            static::makeEventContainerByCurrentClassName();
            if(array_key_exists($event, static::$events[static::class]) && count(static::$events[static::class][$event])){
                return true;
            }
        }
        return false;
    }

    /**
     * kiểm tra event có tồn tại hay không
     *
     * @param string $event
     * @return boolean
     */
    public function hasEvent($event)
    {
        return static::eventExists($event);
    }
    
    /**
     * gọi sự kiện
     *
     * @param string $event
     * @param mixed ...$params
     * @return mixed
     */
    public function fire($event, ...$params)
    {
        return static::callEvent($event, ...$params);
    }

    
    /**
     * gọi sự kiện
     *
     * @param string $event
     * @param mixed ...$params
     * @return mixed
     */

    public function trigger($event, ...$params)
    {
        return static::callEvent($event, ...$params);
    }

    
    /**
     * gọi sự kiện
     *
     * @param string $event
     * @param mixed ...$params
     * @return mixed
     */

    public function emit($event, ...$params)
    {
        return static::callEvent($event, ...$params);
    }

    
}
