<?php

use App\Engines\Breadcrumb;
use App\Repositories\Components\ComponentRepository;
use App\Repositories\Html\AreaRepository;
use App\Repositories\Menus\MenuRepository;
use App\Repositories\Themes\ThemeRepository;

if(!function_exists('custom_css')){
    /**
     * thêm hoặc lấy nội dung css
     * @param string
     * @return string
     */
    function custom_css($css = null){
        static $style = '';
        if(!$css) return $style;
        $style .= "\r\n".$css;
    }
}

if(!function_exists('add_custom_css')){
    /**
     * thêm css
     * @param string $selector or $css
     * @param array $css
     *
     * @return boolean
     */
    function add_custom_css(string $selector, array $css = []){
        if(count($css)){
            $style = $selector . "{\n";
            foreach ($css as $prop => $value) {
                $style.= "\t$prop: $value;\n";
            }
            $style.='}';
            return custom_css($style);
        }
        return custom_css($selector);
    }
}

if(!function_exists('get_custom_css')){
    /**
     * lấy ra chuỗi css
     * @return string
     */
    function get_custom_css(){
        return custom_css();
    }
}

if(!function_exists('get_active_theme')){
    /**
     * lấy ra chuỗi css
     * @return App\Models\Theme
     */
    function get_active_theme(){
        static $checked = false;

        if(!$checked){
            $repository = new ThemeRepository;
            $repository->activeSearchMode();
            if(($id = session('theme_id')) && ($repository->countBy('id', $id))){
                $theme_id = $id;
            }else{
                $theme_id = web_setting('theme_id', 0);
            }

            ThemeRepository::checkActiveTheme($theme_id);
            $checked = true;
        }
        return ThemeRepository::getActiveTheme();
    }
}








if(!function_exists('theme_path')){
    /**
     * lấy dường dẫn theme blade
     * @return string
     */
    function theme_path($path = null){
        static $checked = false;
        static $theme = null;
        if(!$checked){
            $theme = get_active_theme();
            $checked = true;
        }

        if($theme){
            $f = $theme->secret_id;
        }else{
            $f = 'default';
        }

        if($path){
            $f.= '.'. ltrim(str_replace(['/', '\\'], '.', $path), '.');
        }
        return $f;
    }
}
if(!function_exists('theme_component')){
    /**
     * lấy dường dẫn theme component blade
     * @return string
     */
    function theme_component($path = null){
        $f = 'components';
        if($path){
            $f.= '.'. ltrim(str_replace(['/', '\\'], '.', $path), '.');
        }
        return theme_path($f);
    }
}

if(!function_exists('theme_template')){
    /**
     * lấy dường dẫn theme component blade
     * @return string
     */
    function theme_template($path = null){
        $f = 'templates';
        if($path){
            $f.= '.'. ltrim(str_replace(['/', '\\'], '.', $path), '.');
        }
        return theme_path($f);
    }
}

if(!function_exists('theme_layout')){
    /**
     * lấy dường dẫn theme component blade
     * @return string
     */
    function theme_layout($path = null){
        $f = 'layouts';
        if($path){
            $f.= '.'. ltrim(str_replace(['/', '\\'], '.', $path), '.');
        }
        return theme_path($f);
    }
}

if(!function_exists('theme_module')){
    /**
     * lấy dường dẫn theme component blade
     * @return string
     */
    function theme_module($path = null){
        $f = 'modules';
        if($path){
            $f.= '.'. ltrim(str_replace(['/', '\\'], '.', $path), '.');
        }
        return theme_path($f);
    }
}



if(!function_exists('theme_asset')){
    /**
     * lấy dường dẫn (url) asset
     * @return string
     */
    function theme_asset($path = null){
        static $checked = false;
        static $theme = null;
        if(!$checked){
            $theme = get_active_theme();
            $checked = true;
        }
        if($theme){

            $f = $theme->slug;
        }else{
            $f = 'default';
        }

        if($path){
            $f.= '/'. ltrim($path, '/');
        }
        return asset('skins/'.$f);
    }
}

if(!function_exists('theme_json')){
    /**
     * nội dung file json của theme
     * @return string
     */
    function theme_json($file = null, $key = null, $default = null){
        /**
         * @var Filemanager
         */
        static $filemanageer = null;
        static $theme = null;
        if(!$theme){
            $filemanageer = app(Filemanager::class);
            $theme = get_active_theme();
        }
        if($theme){
            $f = base_path('themes/containers/'.$theme->slug . '/json/' . ltrim($file));
            $json = $filemanageer->json($f, $key?true:null);
            return $key ? $json->get($key, $default) : ($json?$json:$default);
        }else{
            return [];
        }

    }
}

if(!function_exists('theme_css_link')){
    /**
     * lấy dường dẫn (url) asset css
     * @return string
     */
    function theme_css_link($file){
        $f = 'css/'.ltrim($file, '/');

        return theme_asset($f);
    }
}

if(!function_exists('theme_css')){
    /**
     * lấy dường dẫn (url) asset css
     * @return string
     */
    function theme_css($file){
        $f = 'css/'.ltrim($file, '/');

        return theme_asset($f);
    }
}

if(!function_exists('theme_js')){
    /**
     * lấy dường dẫn (url) asset js
     * @return string
     */
    function theme_js($file){
        $f = 'js/'.ltrim($file, '/');

        return theme_asset($f);
    }
}


if(!function_exists('get_menu_positions')){
    function get_menu_positions()
    {
        $pos = [
            'primary' => 'Menu chính'
        ];
        if($theme = get_active_theme()){
            if($theme->menus){
                $memu = $theme->menus;
                if(isset($memu['positions'])){
                    $pos = array_merge($pos,(array) $memu['positions']);
                }

            }
        }
        $pos['custom'] = "Tự do";
        return $pos;
    }
}

if(!function_exists('get_menu')){
    /**
     * lấy thông tin menu
     * @param string $position
     * @param array $args
     *
     * @return array
     */
    function get_menu($position = null, array $args = [], $deep = 4){
        static $repository = null;
        if(!$repository) $repository = new MenuRepository();
        return $repository->orderBy('priority', 'ASC')->cache('get-menu-'.json_encode($position).'--'.$deep, system_setting()->cache_data_time(0), $args)->getClientMenu($position, $args, $deep);
    }
}

if(!function_exists('get_menu_options')){
    /**
     * lấy thông tin select option menu
     * @param array $args
     * @return array
     */
    function get_menu_options(array $args = [], $firstDefault = null){
        static $repository = null;;
        if(!$repository) $repository = new MenuRepository();
        return $repository->getDataOptions($args, $firstDefault);
    }
}

if(!function_exists('get_menu_select_options')){
    /**
     * lấy thông tin select option menu
     * @param array $args
     * @return array
     */
    function get_menu_select_options(array $args = []){
        static $repository = null;;
        if(!$repository) $repository = new MenuRepository();
        return $repository->getDataOptions($args, "Trống");
    }
}


if(!function_exists('get_component_area')){
    /**
     * lấy thông tin area
     * @param mixed $args
     * @return array
     */
    function get_component_area($args = null){
        static $repository = null;
        if(!$args) return null;
        $theme = get_active_theme();
        if(is_array($args)){
            if(!isset($args['slug'])) return null;
            elseif(!in_array($args['slug'], ['head', 'top', 'bottom', 'main', 'sidebar_top', 'sidebar_bottom', 'header', 'footer'])){
                $args['ref'] = 'theme';
                $args['ref_id'] = $theme?$theme->id:0;
            }
        }
        elseif(is_string($args)) {
            $slug = $args;
            $args = ['slug'=> $args];
            if(!in_array($slug, ['head', 'top', 'bottom', 'main', 'sidebar_top', 'sidebar_bottom', 'header', 'footer'])){
                $args['ref'] = 'theme';
                $args['ref_id'] = $theme?$theme->id:0;
            }
        }
        elseif(is_numeric($args)) $args = ['id'=> $args];
        else return null;
        if(!$repository) $repository = new AreaRepository();

        return $repository->getComponentArea($args);
    }
}

if(!function_exists('get_component_options')){
    /**
     * lấy thông tin area
     * @param mixed $args
     * @return array
     */
    function get_component_options(){
        static $repository = null;;
        if(!$repository) $repository = new ComponentRepository();

        return $repository->getComponentOptionData();
    }
}




if(!function_exists('get_breakcrumbs')){
    /**
     * lấy dữ liệu breakcrumbs
     * @return array|null
     */
    function get_breakcrumbs()
    {
        return BreaDcrumb::getMap();
    }
}


if(!function_exists('get_breadcrumbs')){
    /**
     * lấy dữ liệu breakcrumbs
     * @return array|null
     */
    function get_breadcrumbs()
    {
        return Breadcrumb::getMap();
    }
}

if(!function_exists('get_last_breadcrumb_item')){
    /**
     * lấy dữ liệu breakcrumbs
     * @return array|null
     */
    function get_last_breadcrumb_item()
    {
        $map = Breadcrumb::getMap();
        return array_pop($map);
    }
}

if(!function_exists('get_last_breakcrumb_item')){
    /**
     * lấy dữ liệu breakcrumbs
     * @return array|null
     */
    function get_last_breakcrumb_item()
    {
        $map = Breadcrumb::getMap();
        return array_pop($map);
    }
}

if(!function_exists('get_title_by_breadcrumbs')){
    /**
     * lấy dữ liệu breadcrumbs
     * @return array|null
     */
    function get_title_by_breadcrumbs()
    {
        return Breadcrumb::getFullTitle();
    }
}



if(!function_exists('get_title_by_breakcrumbs')){
    /**
     * lấy dữ liệu breakcrumbs
     * @return array|null
     */
    function get_title_by_breakcrumbs()
    {
        return Breadcrumb::getFullTitle();
    }
}
