<?php
namespace App\Engines;

Class CacheEngine{
    protected static $domain = null;
    /**
     * get domain
     * @return string
     */
    public static function getDomain()
    {
        if(!static::$domain){
            static::$domain = get_domain();
        }
        return static::$domain;
    }
    

    /**
     * lấy thông tin key
     *
     * @param string $key
     * @param array $params
     * @return string
     */
    public static function getKey($key, $params = [])
    {
        $accessKey = static::getDomain() . '-'. str_slug($key);
        if($params){
            if(is_array($params)){
                $accessKey .= '-' . md5(json_encode($params));
            }else{
                $accessKey .= '-' . md5($params);
            }
        }
        return md5($accessKey);
    }

    /**
     * get cache
     * @param string $key
     * @param int $time (minute)
     * @param array $params
     * @return mixed
     */
    public static function get($key, $params = [])
    {
        return cache(static::getKey($key, $params));
    }

    public static function set($key, $value = null, $time = 0, $params = [])
    {
        $key = static::getKey($key, $params);
        if($time){
            cache([$key => $value], $time * 60);
        }
    }

    /**
     * lấy và lư chu cache
     *
     * @param string $key
     * @param integer $time
     * @param \Cloure $callback
     * @param array $params
     * @return mixed
     */
    public static function remember($key, $time = 0, $callback = null, $params = [])
    {
        $kay = static::getKey($key, $params);
        if(!($data = cache($key))){
            if(is_callable($callback)){
                $data = $callback();
                if($time){
                    cache([$kay=>$data], $time * 60);
                }
            }else{
                $data = null;
            }
        }
        return $data;
    }
}