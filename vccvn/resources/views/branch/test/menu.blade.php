<?php
// Doạn này code thuần nên hơi rối
// sử dụng class Any để truy cập menu data
use Crazy\Helpers\Any;
use Crazy\Html\Menu;


$action = function($item, $link, $sub){
    echo '<pre>';
    print_r($item->getProps());
    echo '<br /><br />';
    // echo '1 -- ';
    // if ($item->type == 'section'){
    //     $item->className = 'm-menu__section';
    //     $item->innerHtml = '<h4 class="m-menu__section-text">'.$item->text.'</h4>
    //                     <i class="m-menu__section-icon flaticon-more-v3"></i>';
    //     return false;
    // }

    if($item->hasSubMenu()){
        // $sub->className = 'm-menu__subnav';
        $sub->before('<div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>')
            ->after('</div>');
    }
    if(!$item->icon && $item->level){
        $link->prepend('<i class="m-menu__link-bullet m-menu__link-bullet--dot"> <span></span> </i>');
    }
    if ($item->badge){
        $link->text->classname = 'm-menu__link-title';
        $link->text->innerHTML = '
                                <span class="m-menu__link-wrap">
                                    
                                    <span class="m-menu__link-badge">
                                        <span class="m-badge m-badge--danger">'.$item->badge.'</span>
                                    </span>
                                </span>';
    }
    else{
        $link->text->classname = 'm-menu__link-text';
    }
};

$menu_props = [
        'menu_class'               => 'm-menu__nav m-menu__nav--dropdown-submenu-arrow',

        'item_class'               => 'm-menu__item',
        
        'has_sub_class'            => 'm-menu__ver-arrow la la-angle-right',
        'has_sub_active_class'     => 'm-menu__item--expanded',
        'item_active_class'        => 'm-menu__item--open',
        'link_class'               => 'm-menu__link', 
        'link_has_sub_class'       => 'm-menu__toggle',
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
    [
        'type' => 'json',
        'file' => 'manager/menus/test'
    ],
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

{!! '<!--' !!}

    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow">
        <li class="m-menu__ver-arrow la la-angle-right">
            <a href="http://manager.chinhlatoi.me/test/menu" title="Người dùng">
                <i class="m-menu__link-icon flaticon-user"></i>
                <span class="m-menu__link-text">Người dùng </span>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li>
                        <a href="http://manager.chinhlatoi.me/test/menu/list" title="Danh sách">
                            <i class="m-menu__link-icon flaticon-th-list"></i>
                            <span class="m-menu__link-text">Danh sách </span>
                        </a>
                    </li>
                    <li>
                        <a href="http://manager.chinhlatoi.me/test/menu/add" title="Thêm mới">
                            <i class="m-menu__link-icon flaticon-plus"></i>
                            <span class="m-menu__link-text">Thêm mới </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>

<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
    <li class="m-menu__item " aria-haspopup="true">
        <a href="../../index.html" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">Dashboard</span>
                    <span class="m-menu__link-badge">
                        <span class="m-badge m-badge--danger">2</span>
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__section ">
        <h4 class="m-menu__section-text">Components</h4>
        <i class="m-menu__section-icon flaticon-more-v3"></i>
    </li>
    <li class="m-menu__item  m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
        <a href="javascript:;" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-layers"></i>
            <span class="m-menu__link-text">Base</span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                    <span class="m-menu__link">
                        <span class="m-menu__link-text">Base</span>
                    </span>
                </li>
                <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
                    <a href="../../components/base/state.html" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">State Colors</span>
                    </a>
                </li>
                <li class="m-menu__item " aria-haspopup="true">
                    <a href="../../components/base/typography.html" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">Typography</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>          

{!! '-->' !!}
{{-- in ra menu --}}


{!! $menu !!}







