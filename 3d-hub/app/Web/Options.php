<?php

namespace App\Web;

use App\Models\Page;
use App\Repositories\Themes\ThemeRepository;
use Crazy\Helpers\Arr;

class Options{
    /**
     * mảng các group dưới dạng
     *
     * @var Option[]
     */
    protected static $_options = [];
    

    public static function check()
    {
        if(count(static::$_options)) return true;
        $list = [
            [
                'slug' => 'settings',
                'ref_id' => 0
            ]
        ];

        foreach ($list as $option) {
            static::$_options[$option['slug']] = new Option($option);
        }
        if($theme = get_active_theme()){
            set_web_data('theme', $theme);
            static::$_options['theme'] = new Option(['ref' => 'theme', 'ref_id' => $theme->id]);
        }
        
    }
    /**
     * khoi tao doi tuong option de truy cap cho de
     *
     * @param array $args
     */
    public function __construct()
    {
        static::check();
    }

    public static function _get($name, $default = null)
    {
        $value = null;
        if(strlen($name)){
            $nameArr = explode('.', $name);
            $optionSlug = array_shift($nameArr);
            if(array_key_exists($optionSlug, static::$_options)){
                $option = static::$_options[$optionSlug];
                if(count($nameArr)){
                    $value = $option->get(implode('.', $nameArr), $default);
                }else{
                    $value = $option;
                }
            }else{
                $value = new Arr();
            }
        }else{
            $value = $default;
        }
        return $value;
    }

    public function get($name, $default = null)
    {
        return static::_get($name, $default);
    }

    /**
     * truy cập group
     */
    public function __get($name)
    {
        return static::_get($name);
    }

    /**
     * gọi hàm mặc định
     */
    public function __call($name, $arguments)
    {
        return static::_get($name, ...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        static::check();
        return static::_get($name, ...$arguments);
    }

    public function updateCache()
    {
        if(static::$_options){
            foreach (static::$_options as $key => $option) {
                $option->updateCache();
            }
        }
    }
}