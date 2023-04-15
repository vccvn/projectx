<?php

if(!function_exists('dockly_menu')){
    function dockly_menu($position = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($position, 2, $attrs, $options, $action);
        
        // $menu->addAction(function($item, $link, $sub){
            
        // });
        return $menu;
    }
}


if(!function_exists('dockly_menu_primary')){
    function dockly_menu_primary($attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu('primary', 2, $attrs, $options, $action);
        
        
        $menu->addAction(function($item, $link){
            if($item->isActive()){
                $item->addClass('active');
            }
            if($item->level < 2){
                $item->addClass('nav-item');
                $link->addClass('nav-link');

            }

            $level = $item->getSonLevel();
            $SubItems = ($hasSub = $item->hasSubMenu()) ? $item->sub->count() : 0;

            if(!$item->level){
                if($hasSub){
                    if($level == 1){
                        $item->addClass('dropdown submenu');
                        $item->sub->addClass('dropdown-menu');
                        
                        $link->after('<i class="arrow_carrot-down_alt2 mobile_dropdown_icon" aria-hidden="true" data-toggle="dropdown"></i>');
                        $link->addClass('dropdown-toggle');
                    }
                }

                    
            }
            else{
                if ($item->level == 1 && $item->parent->sub->count() > 0 && $item->parent->getSonLevel() > 1) {
                    // // if(in_array($style, [3, 4])){
                        
                    //     $item->removeClass()->addClass('mega-menu__column');
                    //     $item->tagName = 'div';
                    //     $link->href = '';
                    //     $link->removeClass()->append('<span class="sub-toggle"></span>');
                    //     $link->tagName = 'h4';
                    //     if($hasSub) $item->sub->addClass('mega-menu__list');
                        
                    // // }
                }
                        
            }
            
        });
        return $menu;
    }
}





if(!function_exists('dockly_mobile_menu')){
    function dockly_mobile_menu($id = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($id?$id:'primary', 2, $attrs, $options, $action);
        
        
        $menu->addAction(function($item, $link){
            $item->addClass('nav-item');
            $link->addClass('nav-link');

            if($item->isActive()){
                $item->addClass('active');
            }
            
            
            $level = $item->getSonLevel();
            $SubItems = ($hasSub = $item->hasSubMenu()) ? $item->sub->count() : 0;

                if($hasSub){
                    if($level == 1){
                        $item->addClass('dropdown submenu');
                        $item->sub->addClass('dropdown-menu');
                        $link->after('<i class="arrow_carrot-down_alt2 mobile_dropdown_icon"></i>');
                        // $link->addClass('dropdown-toggle');
                    }
                }
            
        });
        return $menu;
    }
}



if(!function_exists('dockly_sidebar_mobile_menu')){
    function dockly_sidebar_mobile_menu($id = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($id?$id:'docsleft', 4, $attrs, $options, $action);
        
        
        $menu->addAction(function($item, $link){
            
            $level = $item->getSonLevel();
            $SubItems = ($hasSub = $item->hasSubMenu()) ? $item->sub->count() : 0;


            if($item->isActive()){
                $item->addClass('active');
            }
            if($item->level < 1){
                $item->addClass('nav-item');
                $link->addClass('nav-link');

            }else{
                $item->removeClass('nav-item');
                $link->removeClass('nav-link');

            }

            if($hasSub){
                if($level == 1){
                    $item->addClass('dropdown submenu');
                    $item->sub->addClass('list-unstyled dropdown_nav');
                    $link->after('<span class="icon"><i class="arrow_carrot-down"></i></span>');
                    // $link->addClass('dropdown-toggle');
                }
            }
            
        });
        return $menu;
    }
}


if(!function_exists('dockly_menu_sidebar')){
    function dockly_menu_sidebar($id = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($id?$id:'docsleft', 4, $attrs, $options, $action);
        
        
        $menu->addAction(function($item, $link){
            
            $level = $item->getSonLevel();
            $SubItems = ($hasSub = $item->hasSubMenu()) ? $item->sub->count() : 0;


            if($item->isActive()){
                $item->addClass('active');
            }
            if($item->level < 1){
                $item->addClass('nav-item');
                $link->addClass('nav-link');

            }else{
                $item->removeClass('nav-item');
                $link->removeClass('nav-link');

            }

            if($hasSub){
                if($level == 1){
                    $item->addClass('dropdown submenu');
                    $item->sub->addClass('list-unstyled dropdown_nav');
                    $link->after('<span class="icon"><i class="arrow_carrot-down"></i></span>');
                    // $link->addClass('dropdown-toggle');
                }
            }
            
        });
        return $menu;
    }
}


if(!function_exists('set_docly_bookmark')){
    /**
     * thêm dấu trang
     */
    function set_docly_bookmark($str = null)
    {
        $data = [];
        if(is_string($str)){
            $lines = explode("\n", $str);
            if(count($lines)){
                foreach ($lines as $line) {
                    $parts = explode(';', $line);
                    if(count($parts)){
                        foreach ($parts as $part) {
                            if($p = trim($part)){
                                if(count($keyVal = explode(':', $p)) >= 2){
                                    if(strlen($key = array_shift($keyVal)) && strlen($val = implode(':', $keyVal))){
                                        $data[$key] = $val;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if($data){
            set_web_data('docly_bookmark', $data);
        }
    }
}


if(!function_exists('get_docly_bookmark')){
    /**
     * thêm dấu trang
     */
    function get_docly_bookmark()
    {
        return get_web_data('docly_bookmark');
    }
}


if(!function_exists('get_docly_dynamic_settings')){
    /**
     * thêm dấu trang
     */
    function get_docly_dynamic_settings($id = null)
    {
        $data = null;
        if($html = get_web_data('__html__')){
            if($post_settings = $html->post_settings){
                if($components = $post_settings->components->getComponents()){
                    foreach ($components as $comp) {
                        if($comp->data->dynamic_id == $id){
                            $data = $comp->data;
                        }
                    }
                }
            }
        }
        return $data;
    }
}


if(!function_exists('docly_section_attrs')){
    function docly_section_attrs($section, $default = []){
        $tag = html('div', null, $default);
        $style = $tag->style;
        if($style) {
            if(is_string($style)){
                $style .= ';';
            }
        }

        if($section->class_name){
            $tag->addClass($section->class_name);
        }
        

        if($section->bg_default_color && $section->bg_default_color != 'none'){
            $tag->addClass('bg-'.$section->bg_default_color);
        }

        if($section->bg_color){
            $style .= 'background-color: '.$section->bg_color;
        }
        if($section->bg_image){
            $style .= 'background-image: url('.$section->bg_image .');';
            $tag->addClass('has-bg-image');
            if($section->bg_position){
                $tag->addClass('bg-'.$section->bg_position);
            }
            if($section->bg_half){
                $tag->addClass('half-bg-light');
            }
        }

        if($section->advance && is_array($section->advance)){
            $tag->addClass(implode(' ', $section->advance));
        }
        $tag->style = $style;
        return $tag->attrsToStr();
    }
}


if(!function_exists('docly_attrs')){
    function docly_attrs($section, $default = []){
        $tag = html('div', null, $default);
        $style = $tag->style;
        if($style) {
            if(is_string($style)){
                $style .= ';';
            }
        }

        if($section->class_name){
            $tag->addClass($section->class_name);
        }
        

        if($section->bg_default_color && $section->bg_default_color != 'none'){
            $tag->addClass('bg-'.$section->bg_default_color);
        }

        if($section->bg_color){
            $style .= 'background-color: '.$section->bg_color;
        }
        if($section->bg_image && $section->use_bg_image){
            $style .= 'background-image: url('.$section->bg_image .');';
            $tag->addClass('has-bg-image');
            if($section->bg_position){
                $tag->addClass('bg-'.$section->bg_position);
            }
            if($section->bg_half){
                $tag->addClass('half-bg-light');
            }
        }

        if($section->advance && is_array($section->advance)){
            $tag->addClass(implode(' ', $section->advance));
        }
        $tag->style = $style;
        return $tag->attrsToStr();
    }
}


if(!function_exists('docly_to_lines')){
    /**
     * thêm dấu trang
     */
    function docly_to_lines($str = null)
    {
        $data = [];
        if(is_string($str)){
            $lines = explode("\n", $str);
            if(count($lines)){
                foreach ($lines as $line) {
                    $parts = explode(';', $line);
                    if(count($parts)){
                        foreach ($parts as $part) {
                            if($p = trim($part)){
                                $data[] = $p;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}


if(!function_exists('docly_get_service_options')){
    function docly_get_service_options($args = [], $defaultFirst = null){
        $s = get_services($args);
        if(count($s) == 1){
            return [$s[0]->id => $s[0]->name];
        }
        $a = [];
        if($defaultFirst != null){
            $a[0] = $defaultFirst;
        }
        if(count($s) > 0){
            foreach ($s as $k => $v) {
                $a[$v->id] = $v->name;
            }
        }
        return $a;
    }
}

if(function_exists('add_shortcode')){
    add_shortcode('promoinfo', 'docly_promo_info');
    function docly_promo_info($args, $content){
        $params = [];
        
        if(is_array($args)){
            $params = $args;
        }
        if($promo = get_service_promo($params)){
            
            return str_eval($content, $promo->toArray());
        }
        return $content;
    }
}