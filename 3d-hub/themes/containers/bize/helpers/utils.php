<?php
if(!function_exists('bize_sections')){
    function bize_sections(){
        static $sections = null;
        if(!$sections){
            $sections = [];
            $options = Helper::getThemeOption();
            $list = ['hero', 'promo', 'about', 'services', 'projects', 'pricing', 'testimonials', 'team', 'contact'];
            // $activeDynamic = Helper::getActiveModel('dynamic');
            $prefix = null;
            // if($activeDynamic){
            //     $activeKey = $activeDynamic->slug;
            //     $prefix = asset('/');
            // }else{
            //     $activeKey = 'home';
            // }

            foreach ($list as $itemName) {
                if($options->{$itemName} && $options->{$itemName}->show){
                    $item = $options->{$itemName};
                    $sections[$itemName] = [
                        'template' => $itemName,
                        'data' => $item
                    ];
                }
            }
            
            
        }
        return $sections;
    }
}


if(!function_exists('bize_menu')){
    function bize_menu($position = null, $depth = 4, $attrs = [], $options = [], $action = null){
        if(!is_array($position)){
            $a = compact('position', 'depth');
            $position = $a;
        }
        elseif(!isset($position['depth']))$position['depth'] = $depth;
        $menu = Helper::getHtmlMenu($position, array_merge(
            [
                'prop_type' => 'loop',
                'props' => [
                    // 'item_class' => 'mainmenu__item',
                    // 'has_sub_class' => 'menu-item-has-children sticky-has-child',
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



if(!function_exists('bize_primary_menu_style')){
    function bize_primary_menu_style($position = null, $attrs = [], $options = [], $action = null){
        $attrs = array_merge($attrs,['class' => 'nav navbar-nav navbar-right']);
        $options = array_merge($options, [
            'prop_type' => 'loop',
            'props' => [
                'link_class' => 'page-scroll'
            ]
        ]);
        $menu = bize_menu($position, 3, $attrs, $options, $action);
        // if(in_array($style, [3])){
        //     $menu->addClass('menu--dropdown');
        // }

        return $menu;

    }
}



if(!function_exists('bize_primary_menu')){
    function bize_primary_menu($attrs = [], $options = [], $action = null){
        return bize_primary_menu_style('primary', $attrs, $options, $action);
    }
}



if(!function_exists('bize_logo')){
    function bize_logo($default = null){
        static $logo = null;
        if($logo) return $logo;
        if(!$default) $default = 'logo.png';
        $header = theme_option('header');
        if(!($logo = $header->logo)){
            if(!($logo = siteinfo('logo'))){
                $logo = theme_asset('img/'.$default);
            }
            
        }
        return $logo;
    }
}

if(!function_exists('bize_mobile_logo')){
    function bize_mobile_logo($default = null){
        static $logo = null;
        if($logo) return $logo;
        if(!$default) $default = 'logo.png';
        $header = theme_option('header');
        if(!($logo = $header->mobile_logo)){
            if(!($logo = siteinfo('mobile_logo'))){
                if(!($logo = siteinfo('logo'))){
                    $logo = theme_asset('img/'.$default);
                }
            }
        }
        return $logo;
    }
}

if(!function_exists('bize_footer_logo')){
    function bize_footer_logo($default = null){
        static $logo = null;
        if($logo) return $logo;
        if(!$default) $default = 'logo.png';
        $footer = theme_option('footer');
        if($footer){
            if(!($logo = $footer->logo)){
                if(!($logo = siteinfo('footer_logo'))){
                    if(!($logo = siteinfo('logo'))){
                        $logo = theme_asset('img/'.$default);
                    }
                }
            }
        }
        
        return $logo;
    }
}



?>