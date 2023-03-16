<?php
// Doạn này code thuần nên hơi rối
// sử dụng class Any để truy cập menu data
use Crazy\Helpers\Any;
use Crazy\Html\Menu;


$menu_props = [
	'menu_class'               => 'm-menu__nav m-menu__nav--dropdown-submenu-arrow',
	'item_class'               => 'm-menu__item',
	'has_sub_class'            => 'm-menu__item--submenu',
	'has_sub_active_class'     => 'm-menu__item--expanded',
	'item_active_class'        => 'm-menu__item--open',
	'link_class'               => 'm-menu__link', 
	'link_has_sub_class'       => 'm-menu__toggle',
	'text_tag'                 => 'span',
	'text_class'               => 'm-menu__link-text',
	'item_attrs'               => ['aria-haspopup' => 'true'],
	'item_has_sub_attrs'       => ['m-menu-submenu-toggle' => 'hover'],
	'icon_class'               => 'm-menu__link-icon',
	'icon_prefix_class'        => 'fa fa-',
	'has_sub_icon_class'       => 'm-menu__ver-arrow',
	'has_sub_icon_prefix_class'=> 'la la-angle-right',
	'action'                   => function($item, $link, $sub){

		if ($item->type == 'section'){
			$item->className = 'm-menu__section';
			$item->innerHtml = '<h4 class="m-menu__section-text">'.$item->text.'</h4><i class="m-menu__section-icon flaticon-more-v3"></i>';
			return false;
		}

		if($item->isActive() && ($item->level || !$item->hasSubMenu()) ){
			$item->addClass('m-menu__item--active');
		}
		if($item->hasSubMenu()){

			$sub->before('<div class="m-menu__submenu "><span class="m-menu__arrow"></span>')->after('</div>')
				->prepend('<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
						<span class="m-menu__link">
							<span class="m-menu__link-text">'.$item->text.'</span>
						</span>
					</li>');
		}
		if(!$item->icon && $item->level){
			$link->prepend('<i class="m-menu__link-bullet m-menu__link-bullet--dot"> <span></span> </i>');
		}

		if ($item->badge){
			$link->before('<span class="m-menu__link-wrap">')
				->after('
						<span class="m-menu__link-badge">
							<span class="m-badge m-badge--danger">'.$item->badge.'</span>
						</span>'
				)
				->after('</span>');
		}
	}
];

$menu_props_2 = array_merge($menu_props, [
    'menu_class' => 'm-menu__subnav',
    'item_active_class' => 'm-menu__item--active'
]);

$menu = new Menu(
    isset($sidebar_menu)?$sidebar_menu:[],
    [
        'prop_type' => 'level',
        'props' => [
            // level 0
			$menu_props,
			// level 1
			$menu_props_2,
			// level 2
			$menu_props_2,
			// level 3
            $menu_props_2,
            
        ],
        'active_name' => 'manager_menu'
    ]
);
?>

				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
					<i class="la la-close"></i>
				</button>
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark menu--style-info" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
						{!! $menu !!}

					</div>

					<!-- END: Aside Menu -->
				</div>
