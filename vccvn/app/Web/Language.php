<?php

namespace App\Web;

use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;
use Illuminate\Support\Facades\Session;
Class Language{
    /**
     * @var array $data 
     */
    protected static $data = [];
    /**
     * @var array $locale
     */
    protected static $locale = 'vi';

    /**
     * @var string $sourceType
     */
    protected static $sourceType = 'php';

    /**
     * @var string $sourcePath
     */
    protected static $sourcePath = '';

    /**
     * boot
     */
    public static function boot(){
        static::$sourcePath = base_path(ltrim(env('LANF_PATH', 'language')));

        static::$sourceType = in_array($type = strtolower(env('LANG_SOUTCE_TYPE', 'text')), ['text', 'json', 'php'])?$type:'text';
        
        static::checkLanguage();
    }

    /**
     * kiểm tra ngôn ngữ
     */
    public static function checkLanguage()
    {
        if(!$language = request('language')){
            if($lang = session('language')){
                $language = $lang;
            }else{
                $language = 'vi';
            }
        }
        static::$locale = $language;
        session(['language' => $language]);
        $data = [];
        $type = static::$sourceType;
        $langPath = static::$sourcePath . '/' . static::$locale . '.'. $type;
        if(file_exists($langPath)){
            if($type == 'php'){
                $data = require($langPath);
            }elseif($type == 'json'){
                $data = json_decode(file_get_contents($langPath), true);
            }else{
                $content = file_get_contents($langPath);
                // lấy key ([^\=\r\n\t]*?)
                // lấy value (.*)?
                if(preg_match_all('/([^\=\r\n\t]*?)\s*\=(.*)?(\r\n|\r|\n|$)/i', $content, $match)){
                    // array_map('trim', $match[1]) => xóa khảng trắng ở 2 đầu key
                    // tương tu75 với value
                    // array_combine trộn 2 mảng với nhau thành 1 mảng key => value
                    $data = array_combine(array_map('trim', $match[1]), array_map('trim', $match[2]));

                }

            }
        }
    }

}