<?php

namespace App\Engines;

/**
 * @method string crypt($str) mã hóa
 * @method string decrypt(string $str) giải mã
 * @method static string crypt( $str,  string $key = null) mã hóa
 * @method static string decrypt(string $str,  string $key = null) giải mã
 * 
 * 
 */
class CrazyHashEngine
{
    # code here...
    protected $_key = null;
    public function __construct(string $key = '')
    {
        $this->_key = base64_encode($key);
    }

    protected function _crypt($value = null)
    {
        $type = gettype($value);
        $input = '';
        $outType = $type;
        switch ($type) {
            case 'object':
                $input = serialize($value);
                break;
            case 'array':
                $input = json_encode($value);
                break;
            case 'boolean':
                $input = $value ? '1' : '0';
            case 'number':
                $input = (string) $value;
                break;
            default: 
                $outType = 'string';
                $input = str_rev_case($value);
        }
        $a = base64_encode($input);
        
        $a = base64_encode(substr(md5(uniqid()), 10, 8). $this->_key . strrev($a));
        
        $a = str_rev_case($a);
        
        
        $a = strrev(substr($a, 0, 10)) . strrev(substr($a, 10)) . substr(md5(uniqid().time()), rand(0, 14), 16);
        
        
        $a = number_th_all($a);
        
        
        $a = '$'. base64_encode($outType . ' : '. $a);
        $a = str_rev_case($a);
        $a = base64_encode(strrev($a));
        $a = '$'. number_th_all($a);
        $a = str_rev_case($a);
        $a = base64_encode(strrev($a));
        // $a = '$'. number_th_all($a);
        
        return $a;
    }


    protected function _decrypt(string $str)
    {
        $a = $str;
        $a = strrev(base64_decode($a));
        $a = str_rev_case($a);
        $a = substr($a, 1);
        $a = un_number_th_all($a);
        $a = strrev(base64_decode($a));

        // $a = substr($a, 1);
        // $a = un_number_th_all($a);
        // $a = strrev(base64_decode($a));
        
        $a = str_rev_case($a);
        $a = base64_decode(substr($a, 1));

        // return un_number_th_all($a);
        $arr = explode(' : ', $a);
        if(count($arr) < 2) return null;
        $type = $arr[0];
        $a = $arr[1];
        
        $a = un_number_th_all($a);
        // echo $a;
        
        $a = strrev(substr($a, 0, 10)) . strrev(substr($a, 10, strlen($a)-26));
        
        $a = str_rev_case($a);
        
        $a = strrev(substr(base64_decode($a), strlen($this->_key) + 8));
        $raw = base64_decode($a);
        // echo $raw;
        $out = null;
        switch ($type) {
            case 'object':
                $out = unserialize($raw);
                break;
            case 'array':
                $out = json_decode($raw, true);
                break;
            case 'boolean':
                $out = $raw == '1'? true: false;
            case 'number':
                $out = to_number($raw);
                break;
            default: 
                $out = str_rev_case($raw);
        }
        return $out;
        
    }

    public function __call($name, $arguments)
    {
        if(method_exists($this, '_'.$name)){
            return call_user_func_array([$this, '_'.$name], $arguments);
        }
        return null;
    }

    protected static $instances = [];
    /**
     * get instance of Crazy Has
     * @param string $key Chuỗi khóa
     * @return CrazyHashEngine
     */
    public static function getInstance($key = null)
    {
        if($key){
            if(array_key_exists($key, static::$instances)){
                return static::$instances[$key];
            }
            static::$instances[$key] = new static($key);
            return static::$instances[$key];
        }
        if(count(static::$instances)){
            foreach (static::$instances as $key => $instance) {
                return $instance;
            }
        }
        $key = 'default';
        static::$instances[$key] = new static($key);
        return static::$instances[$key];
    }
        /**
     * get instance of Crazy Has
     * @param string $key Chuỗi khóa
     * @return CrazyHashEngine
     */
    public static function setKey($key)
    {
        if($key){
            if(array_key_exists($key, static::$instances)){
                return static::$instances[$key];
            }
            static::$instances[$key] = new static($key);
            return static::$instances[$key];
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if(count($arguments) > 1){
            $key = $arguments[1];
            $instance = static::getInstance($key);
            return call_user_func_array([$instance, $name], $arguments);
        }
        return call_user_func_array([static::getInstance(), $name], $arguments);
        
    }
}