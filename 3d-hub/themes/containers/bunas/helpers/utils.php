<?php

if(!function_exists('bunas_menu_primary_style')){
    function bunas_menu_primary_style($position = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($position, 2, $attrs, $options, $action);
        
        $menu->addAction(function($item, $link, $sub){
            if($item->hasSubMenu()){
                $item->addClass('dropdown');
                $link->addClass('dropdown-toggle');
                $link->attr('data-toggle', 'dropdown');
                $item->sub->addClass('dropdown-menu');
            }
            if($item->isActive()){
                $link->addClass('active');
            }
            
        });
        return $menu;
    }
}




if(!function_exists('bunas_primary_menu')){
    function bunas_primary_menu($attrs = [], $options = [], $action = null){
        return bunas_menu_primary_style('primary', $attrs, $options, $action);
    }
}

