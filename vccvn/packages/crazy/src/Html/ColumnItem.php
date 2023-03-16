<?php
namespace Crazy\Html;

use Crazy\Files\Filemanager;
use Crazy\Helpers\Arr;

class ColumnItem{
    protected static $item;
    protected static $config;
    protected static $options = [];
    protected static $data = [];
    protected static $moduleRoute = '';
    protected static $columnTag = 'td';
    protected static $baseView = 'admin';
    
    /**
     * tao doi tuong hiển thị
     */
    public static function show($item, $config, $options = [], $route = '', $base_view_path = 'admin', $columm_tag = null)
    {
        static::$item = $item;
        static::$config = $config;
        static::$options = $options;
        static::$moduleRoute = $route;
        static::$baseView = $base_view_path;
        if($columm_tag){
            static::$columnTag = $columm_tag;
        }
        
        return static::render();
    }

    /**
     * render
     * @return string
     */
    public static function render()
    {
        $content = '';
        $options = new Arr(static::$options);
        $type = $options->type;
        if($type == 'text' || $options->text){
            $content = htmlentities(static::getDataFromString($options->text));
        }
        elseif($type == 'data' && $options->data_key && $options->value_key){
            $vkey = static::getDataFromString($options->value_key);
            $content = static::$config->get('data.'.$options->data_key.'.'.$vkey);
        }
        elseif($options->data_access){
            $key = str_eval($options->data_access, array_merge(static::$item->toArray(), static::parseTemplateData($options->data)), 0, '');
            $content = static::$config->get('data.'.$key);
        }
        elseif($type == 'template' || $options->template){
            $content = str_eval($options->template, array_merge(static::$item->toArray(), static::parseTemplateData($options->data)), 0, '');
        }
        elseif (in_array(str_replace('_', '', $type), ['html', 'htmldom', 'htmltag']) || $options->html) {
            $ob = new Arr($options->html);
            $content = new HtmlDom($ob->tag_name??'div', $ob->content, static::parseParams($ob->attrs));
        }
        elseif ($type == 'input' || $options->input) {
            $args = static::parseTemplateData($options->input);
            $input = new Input($args);
            if($input->template && is_support_template($input->template, $input->type)){
                $content = view(static::$baseView . 'forms.templates.' . $input->template, ['input' => $input])->render();
            }else{
                $content = $input->render();
            }
        }

        $attrs = static::parseParams(is_array($options->attrs)?$options->attrs:[]);
        
        $html = new HtmlDom(static::$columnTag, $content, $attrs);
        if($options->class){
            $html->addClass($options->class);
        }
        return $html->render();
    }

    /**
     * duyệt thong tin cho template
     * @param array $data
     * 
     * @return array
     */
    public static function parseTemplateData($data = [])
    {
        $d = [];
        if(is_array($data)){
            foreach($data as $key => $value){
                if(!is_array($value)){
                    $d[$key] = static::getDataFromString($value);
                }else{
                    if(isset($value['call']) && (method_exists(static::$item, $value['call']) || is_callable($value['call']))){
                        $c = $value['call'];
                        $params = (isset($value['params']) && is_array($value['params'])) ? $value['params'] : [];
                        if($c=='route' && $params && substr($params[0], 0, 1) == '.') $params[0] = static::$moduleRoute.$params[0];
                        $params = static::parseParams($params);
                        $call = method_exists(static::$item, $c)?[static::$item, $c]:$c;
                        $d[$key] = call_user_func_array($call, $params);
                    }
                    elseif(substr($key, 0, 1) == '@'){
                        $f = substr($key, 1);
                        $d[$key] = static::callFunc($f, $value);
                        
                    }
                    else{
                        $d[$key] = null;
                    }
                }
            }
        }
        return $d;
    }

    public static function callFunc($func, $params)
    {
        $c = null;
        if(is_callable($func)){
            $c = $func;
            if($c=='route' && $params && substr($params[0], 0, 1) == '.') {
                if(is_array($params)){
                    $params[0] = static::$moduleRoute.$params[0];
                }
                else{
                    $params = static::$moduleRoute.$params;
                }
            }
        }
        elseif(method_exists(static::$item, $func)){
            $c = [static::$item, $func];
        }
        if($c){
            $params = static::parseParams($params);
            $p = is_array($params)?$params:[$params];
            $d = call_user_func_array($c, $p);
        }
        else{
            $d = null;
        }
        return $d;
    }
    /**
     * taich lấy param
     * @param mixed $raw
     * @return array
     */
    public static function parseParams($raw = null)
    {
        $data = [];
        if(is_array($raw)){
            foreach ($raw as $key => $value) {
                $data[$key] = static::getDataFromString($value);
            }
        }elseif (is_callable($raw)) {
            $data = $raw();
        }elseif ($raw) {
            $data = static::getDataFromString($raw);
        }
        return $data;
    }
    /**
     * lấy thông tin từ chuỗi
     * @param string
     * @return string|array
     */

    public static function getDataFromString($raw)
    {
        if(is_array($raw)){
            $data = [];
            foreach ($raw as $key => $value) {
                $data[$key] = static::getDataFromString($value);
            }
            return $data;
        }
        elseif (in_array($s = substr($raw,0,1), [':', '@'])) {
            $nsp = substr($raw,1);
            if ($s==':') {
                return static::$item->{$nsp};
            }elseif(strtolower(substr($nsp, 0, 5)) == 'data:'){
                return static::$config->get('data.' . substr($nsp, 5));
            }
            elseif(method_exists(static::$item, $nsp)){
                return static::$item->{$nsp}();
            }elseif(is_callable($nsp)){
                return $nsp();
            }
        }
        
        return static::parseString($raw);
    }

    public static function parseString($string)
    {
        return str_eval($string, static::$item->toArray(), 0, '');
    }


}