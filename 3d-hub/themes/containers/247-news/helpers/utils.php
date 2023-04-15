<?php

if(!function_exists('news_menu_primary_style')){
    function news_menu_primary_style($position = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($position, 2, $attrs, $options, $action);
        
        $menu->addAction(function($item, $link, $sub){
            if($item->hasSubMenu()){
                $item->addClass('dropdown');
                $link->addClass('dropdown-toggle')->attr('data-toggle', 'dropdown');
                $item->sub->addClass('dropdown-menu');
                if($item->sub_type == 'mega'){
                    $item->addClass('mega-dropdown');
                    $item->sub->addClass('mega-dropdown-menu');
                }
            }
            
        });
        return $menu;
    }
}


if(!function_exists('news_menu_sidebar_style')){
    function news_menu_sidebar_style($position = null, $attrs = [], $options = [], $action = null){
        $menu = Helper::getCustomMenu($position, 2, $attrs, $options, $action);
        
        $menu->addAction(function($item, $link, $sub){
            if($item->hasHiddenSubmenu()){
                $item->show_submenu = 'show';
                $item->append($sub);
            }
            $hasSub = $item->hasSubMenu();
            if($hasSub){
                $item->sub->addClass('sidenav-dropdown');
                $item->sub->attr('data-sidenav-dropdown', true);
                $link->after('
                <div class="icon-sub-menu" data-sidenav-dropdown-toggle>
                    <span class="sidenav-dropdown-icon show" data-sidenav-dropdown-icon></span>
                    <span class="sidenav-dropdown-icon up-icon" data-sidenav-dropdown-icon></span>
                </div>
                ');
            }
            
            
        });
        return $menu;

    }
}



if(!function_exists('news_primary_menu')){
    function news_primary_menu($attrs = [], $options = [], $action = null){
        return news_menu_primary_style('primary', $attrs, $options, $action);
    }
}


if(!function_exists('news_text_logo')){
    function news_text_logo($primaey = 'h1', $second = 'h4'){
        static $header = null;
        $siteinfo = siteinfo(); 
        if(!$header){
            $header = Helper::themeOption('header');

        }
        if ($header->show_text_logo){
            $html = "<$primaey>";
            if ($header->text_logo_primary || $header->text_logo_second){
                if(in_array($header->highlight, ['all', 'both', 'primary'])){
                    $html .= "<span>";
                }
                $html .= $header->text_logo_primary;
                if ($header->highlight == 'primary') $html .= "</span>";
                if ($header->highlight == 'second') $html .= "<span>";
                $html .= ' '. $header->text_logo_second;
                if (in_array($header->highlight, ['all', 'both', 'second'])) $html .= "</span>";
            }else{
                $html .= $siteinfo->site_name;
            }
            $html .= "</$primaey>";
            $html .= ($text = $header->text_logo_slogan($siteinfo->slogan))? "<$second>$text</$second>": "";
            return $html;
        }
        return null;
    }
}



if(!function_exists('news_component_text_logo')){
    function news_component_text_logo($component, $primaey = 'h1', $second = 'h4'){
        $siteinfo = siteinfo(); 
        if ($component->show_text_logo){
            $html = "<$primaey>";
            if ($component->text_logo_primary || $component->text_logo_second){
                if(in_array($component->highlight, ['all','both', 'primary'])){
                    $html .= "<span>";
                }
                $html .= $component->text_logo_primary;
                if ($component->highlight == 'primary') $html .= "</span>";
                if ($component->highlight == 'second') $html .= "<span>";
                $html .= ' '. $component->text_logo_second;
                if (in_array($component->highlight, ['all','both', 'second'])) $html .= "</span>";
            }else{
                $html .= $siteinfo->site_name;
            }
            $html .= "</$primaey>";

            $html .= ($text = $component->text_logo_slogan($siteinfo->slogan))? "<$second>$text</$second>": "";
            
            return $html;
        }
        return null;
    }
}




if(!function_exists('get_category_label')){
    function get_category_label($id = 0){
        static $cateLabels = [];
        if(!$id) return 1;
        if(!isset($cateLabels[$id])){
            $cateLabels[$id] = count($cateLabels) % 5 + 1;
        }
        return $cateLabels[$id];
    }
}

if(!function_exists('get_bg_style_options')){
    function get_bg_style_options(){
        $data = [];
        for($i = 1; $i < 13; $i++){
            $data[$i] = $i;
        }
        return $data;
    }
}