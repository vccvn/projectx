
@php
    $webType = get_web_type();
@endphp

            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                    
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                        <a href="{{get_owner_home_url()}}" target="_blank" class="m-menu__link">
                            <i class="m-menu__link-icon fa fa-home"></i>
                            <span class="m-menu__link-text">Xem trang chủ</span>
                        </a>
                    </li>
                </ul>
            </div>