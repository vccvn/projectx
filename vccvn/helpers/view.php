<?php

use Crazy\Html\Html;
use Crazy\Html\Menu;
use Crazy\Html\Form;
use Crazy\Html\Input;

if(!function_exists('html')){
    /**
     * tạo ra một đối tượng dom html
     * @param string $tagName thẻ html
     * @param mixed ...$params các tham số nhu content, attribute []
     */
    function html($tagName = 'div', ...$params)
    {

        return new Html($tagName, ...$params);
    }
}

if(!function_exists('html_menu')){
    /**
     * tạo ra một đối tượng dom html menu
     * @param array $data dữ liệu menu
     * @param array $options
     * @param int $level
     *
     * @return Menu
     */
    function html_menu($data, array $options = [], int $level = 0) : Menu
    {
        $menu = new Menu($data, $options, $level);
        return $menu;
    }
}


if(!function_exists('get_html_menu')){
    /**
     * tạo ra một đối tượng dom html menu
     * @param string $position vị trí menu
     * @param array $options
     * @param int $level
     *
     * @return Menu|null
     */
    function get_html_menu($position = null, array $options = [], int $level = 0) : Menu
    {
        $d = [];
        if($data = get_menu($position)){
            $d = $data;
        }
        $menu = new Menu($d, $options, $level);
        return $menu;

    }
}




if(!function_exists('get_custom_menu')){
    /**
     * lấy menu theo vị trí hoặc id
     *
     * @param array|int $position
     * @param integer $depth
     * @param array $attrs
     * @param array $options
     * @param \Closure
     * @return Menu
     */
    function get_custom_menu($position = null, $depth = 4, $attrs = [], $options = [], $action = null){
        if(!is_array($position)){
            if(is_numeric($position)){
                $a = [
                    'id' => $position,
                    'depth' => $depth
                ];
            }else{
                $a = compact('position', 'depth');

            }
            $position = $a;
        }
        elseif(!isset($position['depth']))$position['depth'] = $depth;
        // lấy menu theo
        $menu = get_html_menu($position, array_merge(
            [
                'prop_type' => 'loop',
                'props' => [

                ]
            ], $options
        ));
        $menu->attr($attrs);
        if(is_callable($action)){
            $menu->addAction($action);
        }
        
        return $menu;
    }
}



if(!function_exists('get_main_menu')){
    /**
     * lấy thông tin menu chính
     * @param array $options
     * @param int $level
     *
     * @return Menu
     */
    function get_main_menu(array $options = [], int $level = 0) : Menu
    {
        return get_html_menu('main', $options, $level);
    }
}

if(!function_exists('get_primary_menu')){
    /**
     * lấy thông tin menu  chính
     * @param array $options
     * @param int $level
     *
     * @return Menu
     */
    function get_primary_menu(array $options = [], int $level = 0){
        return get_html_menu('primary', $options, $level);
    }
}






if(!function_exists('html_form')){
    /**
     * tạo ra một đối tượng dom html form
     * @param array $data dữ liệu form
     * @param array $options
     * @param array $attrs
     *
     * @return Form
     */
    function html_form($data, array $options = [], array $attrs = []) : Form
    {
        $form = new Form($data, $options, $attrs);
        return $form;
    }
}

if(!function_exists('html_input')){
    /**
     * tạo ra một đối tượng dom html input
     * @param array $data dữ liệu input
     *
     * @return Input
     */
    function html_input($data) : Input
    {
        $input = new Input($data);
        return $input;
    }
}



if(!function_exists('get_register_form')){
    /**
     * tạo ra một đối tượng dom html form
     * @param array $data dữ liệu input
     *
     * @return Form
     */
    function get_register_form(array $config = []) : Form
    {
        $a = json_decode(file_get_contents(json_path('clients/forms/register.json')), true);
        $form = new Form([
            'inputs' => $a && isset($a['inputs']) ? $a['inputs'] : [],
            'errors' => request()->session()->get('errors')
        ], $config);
        $form->password->value = "";
        $form->password_confirmation->value = "";
        // dd($form);
        return $form;
    }
}

if(!function_exists('get_login_form')){
    /**
     * tạo ra một đối tượng dom html form
     * @param array $data dữ liệu input
     *
     * @return Form
     */
    function get_login_form(array $config = []) : Form
    {
        $a = json_decode(file_get_contents(json_path('clients/forms/login.json')), true);

        $form = new Form([
            'inputs' => $a && isset($a['inputs']) ? $a['inputs'] : [],
            'errors' => request()->session()->get('errors')
        ], $config);
        $form->password->value = "";

        return $form;
    }
}


if(!function_exists('js_data')){
    /**
     * thêm biến để dùng cho js
     * @param string $name
     * @param string|array $key
     * @param mixed $value
     * @return null|array
     */
    function js_data($name = null, $key = null, $value = '<!-- DEFAULT -->'){
        static $data = [];

        if(!$name || !preg_match('/^[A-z]+[A-z0-9_\$\.]*$/i', $name)) return $data;

        if(!isset($data[$name])) $data[$name] = [];

        if(is_array($key)){
            $data[$name] = array_merge($data[$name], $key);
        }elseif($value !== '<!-- DEFAULT -->'){
            $data[$name][$key] = $value;
        }else{
            $data[$name][] = $key;
        }
    }
}

if(!function_exists('get_js_data')){
    /**
     * @param string $name ten bien
     * @param string $key
     * @return mixed
     */
    function get_js_data($name = null, $key = null){
        $data = js_data();
        if(!$name) return $data;
        if(isset($data[$name])){
            if(!is_null($key)) return isset($data[$name][$key])?$data[$name][$key]:null;
            return $data[$name];
        }
        return null;
    }
}

if(!function_exists('add_js_data')){
    /**
     * thêm biến để dùng cho js
     * @param string $name
     * @param string|array $key
     * @param mixed $value
     *
     */
    function add_js_data($name, $key = null, $value = '<!-- DEFAULT -->'){
        if($name && !is_null($key)){
            return js_data($name, $key, $value);
        }
    }
}

if(!function_exists('js_src')){
    /**
     * them nguon js
     * @param string|array
     *
     * @return array
     */
    function js_src($src = null){
        static $list = [];
        if($src){
            if(!is_array($src)){
                $src = [$src];
            }
            foreach($src as $s){
                if(preg_match('/^(http\:\/\/|https\:\/\/|\/\/)/i', $s)){
                    $r = $s;
                }else{
                    $r = asset($s);
                }
                if(!in_array($r, $list)){
                    $list[] = $r;
                }
            }
            return true;
        }
        return $list;
    }
}

if(!function_exists('get_js_src')){
    /**
     * lay danh sach nguon js
     * @return array
     */
    function get_js_src(){
        return js_src();
    }
}

if(!function_exists('add_js_src')){
    /**
     * them danh sach nguon js
     * @param array|string $src
     * @return array
     */
    function add_js_src(...$src){
        if(is_array($src) && count($src)){
            foreach ($src as $s) {
                js_src($s);
            }
        }
    }
}




if(!function_exists('css_link')){
    /**
     * them link
     * @param string|array
     *
     * @return array
     */
    function css_link($link = null){
        static $list = [];
        if($link){
            if(!is_array($link)){
                $link = [$link];
            }
            foreach($link as $s){
                if(preg_match('/^(http\:\/\/|https\:\/\/|\/\/)/i', $s)){
                    $r = $s;
                }else{
                    $r = asset($s);
                }
                if(!in_array($r, $list)){
                    $list[] = $r;
                }
            }
            return true;
        }
        $a = $list;
        $list = [];
        return $a;
    }
}

if(!function_exists('get_css_link')){
    /**
     * lay danh sach css link
     * @return array
     */
    function get_css_link(){
        return css_link();
    }
}

if(!function_exists('add_css_link')){
    /**
     * them danh sach link
     * @param array|string $link
     * @return array
     */
    function add_css_link(...$link){
        if(is_array($link) && count($link)){
            foreach ($link as $s) {
                css_link($s);
            }
        }
    }
}

if(!function_exists('is_url')){
    /**
     * kiểm tra xem có phải là url hay ko
     * @param string $str
     *
     * @return boolean
     */
    function is_url($str = null)
    {
        if(is_string($str)){
            if(preg_match('/^(http|https):\/\//i', $str)) return true;
        }
        return false;
    }
}

if(!function_exists('get_result_blade_vars')){
    /**
     * lấy các biến tromg result view
     * @param string $item_name tên mục
     * @param string $list_type ví dụ: default / active / trash
     */
    function get_result_blade_vars($item_name, $list_type = 'default'){
        $list_config = [
            'default' => [
                'title' => 'Danh sách '.$item_name,
                'btn_class' => 'btn-move-to-trash',
                'tooltip' => 'Xóa tạm thời',
            ],
            'trash' => [
                'title' => 'Danh sách '.$item_name.' đã xóa',
                'btn_class' => 'btn-delete',
                'tooltip' => 'Xóa vĩnh viễn',
            ],
        ];
        $list_type = $list_type == 'trash' ? $list_type : 'default';
        $title = $list_config[$list_type]['title'];
        $btn_class = $list_config[$list_type]['btn_class'];
        $btn_tooltip = $list_config[$list_type]['tooltip'];
        return compact('list_config', 'list_type', 'title', 'btn_class', 'btn_tooltip');

    }
}


if(!function_exists('is_support_template')){

    function is_support_template($template, $type){

        // danh sach template ho tro cac inout
        // template              => [type]
        $input_templates = [
            'switch'             => ['checkbox', 'switch'],
            'checklist'          => ['checklist', 'select'],
            'options'            => ['radio', 'option'],
            'date'               => ['text', 'date'],
            'time'               => ['text', 'time'],
            'crazyslug'          => ['text', 'slug', 'crazyslug'],
            'daterange'          => ['text', 'date', 'daterange'],
            'touchspin'          => ['text', 'number', 'touchspin'],
            'deepselect'         => ['deepselect', 'select'],
            'crazyselect'        => ['crazyselect', 'select'],
            'dateselect'         => ['date', 'text', 'dateselect'],
            'crazytag'           => ['crazytag', 'select'],
            'multiselect'        => ['multiselect', 'select'],
            'select2'            => ['select','select2'],
            'cropit'             => ['file', 'imagefile'],
            'crazyprop'          => ['textarea', 'crazyprop', 'crazyInput', 'array'],
            'specification'      => ['textarea', 'specification', 'crazySpecification', 'array'],
            'tinymce'            => ['textarea', 'tinymce'],
            'gallery'            => ['inputgallery', 'crazygallery', 'gallery', 'image', 'file'],
            'videopreview'       => ['text', 'url'],
            'attribute'          => ['attribute', 'select', 'textarea'],
            'variant-attribute'  => ['attribute', 'select', 'textarea', 'variant-attribute'],
            'product'            => ['product', 'select', 'textarea'],
            'colorpicker'        => ['text', 'colorpicker', 'color'],
            'iconpicker'         => ['text', 'iconpicker', 'icon'],
            'checkmultilevel'    => ['checkbox', 'checklist', 'checkmultilevel', 'textarea'],
            'ckeditor'           => ['textarea', 'ckeditor'],
            'area'               => ['textarea', 'area', 'hidden', 'text'],
            'colorselect'        => ['radio', 'colorselect'],
            'affiliate'          => ['text', 'textarea', 'affiliate'],
            'media'              => ['inputmedia', 'crazymedia', 'media', 'image', 'file'],


        ];

        return ($template && $type)?(
            array_key_exists($template, $input_templates)
            && (
                (
                    is_string($input_templates[$template])
                    && $input_templates[$template] == $type
                )
                || (
                    is_array($input_templates[$template])
                    && in_array($type, $input_templates[$template])
                )
            )
        ):false;
    }
}

if(!function_exists('get_prefix_classname')){
    /**
     * lấy prefix class của hệ thống. dùng cho jquery hoặc css
     *
     * @return string
     */
    function get_prefix_classname()
    {
        static $class = -1;
        if($class == -1){
            $class = get_system_config('frontend.css.prefix_class', env('css_prefix_class'));
        }
        return $class;
    }
}

if(!function_exists('parse_classname')){
    /**
     * tạo ra các class đã được thêm prefix hệ thống
     * @param array|string[]|array[] ...$classes
     * @return string
     */
    function parse_classname(...$classes)
    {
        if($classes){
            $array = [];
            foreach ($classes as $ind => $class) {
                if(is_string($class)){
                    $array[] = get_prefix_classname(). $class;
                }
                elseif(is_array($class)){
                    $a = array_values($class);
                    foreach ($a as $key => $c) {
                        if(is_string($c)) $array[] = get_prefix_classname().$c;
                    }
                }
            }
            return implode(" ", $array);
        }
        return null;
    }
}

if(!function_exists('get_js_object_name')){
    /**
     * lấy lấy ra tên đối tượng (js) để tương tác với hệ thống
     *
     * @return string
     */
    function get_js_object_name()
    {
        static $object = -1;
        if($object == -1){
            $object = get_system_config('frontend.js.object', env('js_object'));
        }
        return $object;
    }
}


if(!function_exists('get_mobile_detect')){
    /**
     * lấy doi tuong mobike detect
     *
     * @return Mobile_Detect
     */
    function get_mobile_detect()
    {
        static $device = null;
        if(!$device) $device = app(Mobile_Detect::class);
        return $device;
    }
}

if(!function_exists('is_mobile')){
    /**
     * kiểm tra có phải mobile hay không
     *
     * @return bool
     */
    function is_mobile(...$args)
    {
        return get_mobile_detect()->isMobile(...$args);
    }
}



if(!function_exists('is_tablet')){
    /**
     * kiểm tra có phải table hay không
     *
     * @return bool
     */
    function is_tablet(...$args)
    {
        return get_mobile_detect()->isTablet(...$args);
    }
}


if(!function_exists('is_desktop')){
    /**
     * kiểm tra có phải mobile hay không
     *
     * @return bool
     */
    function is_desktop(...$args)
    {
        $device = get_mobile_detect();
        return !$device->isMobile(...$args) && !$device->isTablet(...$args);
    }
}












?>
