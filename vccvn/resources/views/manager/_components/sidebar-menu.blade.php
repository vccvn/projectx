<?php
// Doạn này code thuần nên hơi rối
// sử dụng class Any để truy cập menu data
use Crazy\Helpers\Any;
use Crazy\Html\Menu;


$action = function($item, $link, $sub){
    if ($item->type == 'section'){
        $item->className = 'm-menu__section';
        $item->innerHtml = '<h4 class="m-menu__section-text">'.$item->text.'</h4><i class="m-menu__section-icon flaticon-more-v3"></i>';
        return false;
    }

    if($item->hasSubMenu()){
        // $sub->className = 'm-menu__subnav';
        $sub->before('<div class="m-menu__submenu "><span class="m-menu__arrow"></span>')->after('</div>')
            ->prepend('<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                    <span class="m-menu__link">
                        <span class="m-menu__link-text">'.$item->text.'</span>
                    </span>
                </li>');
    }
    // elseif($item->isActive()){
    //     $item->addClass('m-menu__item--active');
    // }
    if(!$item->icon && $item->level){
        $link->prepend('<i class="m-menu__link-bullet m-menu__link-bullet--dot"> <span></span> </i>');
    }

    // $link->text->classname = '';

    if ($item->badge){
        $link->before('<span class="m-menu__link-wrap">')
            ->after('<span class="m-menu__link-badge">
                        <span class="m-badge m-badge--danger">'.$item->badge.'</span>
                </span>')
            ->after('</span>');
    }
    

};

$menu_props = [
        'menu_class'               => 'm-menu__nav m-menu__nav--dropdown-submenu-arrow',

        'item_class'               => 'm-menu__item',
        
        'has_sub_class'            => 'm-menu__item--submenu',

        'has_sub_active_class'     => 'm-menu__item--open m-menu__item--expanded',

        'item_active_class'        => 'm-menu__item--active',

        'link_class'               => 'm-menu__link', 

        'link_has_sub_class'       => 'm-menu__toggle',

        'text_tag'                 => 'span',
        
        'text_class'               => 'm-menu__link-text',

        'item_attrs'               => ['aria-haspopup' => 'true'],

        'item_has_sub_attrs'       => ['m-menu-submenu-toggle' => 'hover'],

        'icon_class'               => 'm-menu__link-icon',

        'icon_prefix_class'        => 'flaticon-',

        'has_sub_icon_class'       => 'm-menu__ver-arrow',

        'has_sub_icon_prefix_class'=> 'la la-angle-right',
        
        'action' => $action
    ];
$menu_props_2 = array_merge($menu_props, [
    'menu_class' => 'm-menu__subnav',
    'item_active_class' => ' m-menu__item--active'
]);

$menu = new Menu(
    isset($menu_data)?$menu_data:[],
    [
        'prop_type' => 'level',
        'props' => [
            // level 0
            $menu_props,
            $menu_props_2,
            $menu_props_2,
            $menu_props_2,
            $menu_props_2,
            $menu_props_2,
            
        ],
        'active_name' => 'admin_menu'
    ]
);

?>
{{-- in ra menu --}}


{!! $menu !!}

