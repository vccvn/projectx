
@php
    $webType = get_web_type();
@endphp

            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon flaticon-add"></i>
                            <span class="m-menu__link-text">Truy cập nhanh</span>
                            <i class="m-menu__hor-arrow la la-angle-down"></i>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                            <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                            <ul class="m-menu__subnav">
                                @if ($webType == 'ecommerce')
                                    
                                <li class="m-menu__item " aria-haspopup="true">
                                    <a href="{{route('admin.products.create')}}" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-plus"></i>
                                        <span class="m-menu__link-text">Thêm sản phẩm</span>
                                    </a>
                                </li>
                                <li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                        <i class="m-menu__link-icon flaticon-business"></i>
                                        <span class="m-menu__link-text">Quản lú đơn hàng</span>
                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                        <span class="m-menu__arrow "></span>
                                        <ul class="m-menu__subnav">

                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="{{route('admin.orders.list')}}" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đơn hàng mới</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="{{route('admin.orders.list-by-status', ['list' => 'verified'])}}" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đã xác nhận</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="{{route('admin.orders.list-by-status', ['list' => 'pending'])}}" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Chờ xử lý</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="{{route('admin.orders.list-by-status', ['list' => 'processing'])}}" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đang xử lý</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="{{route('admin.orders.list-by-status', ['list' => 'completed'])}}" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đã hoàn thành</span>
                                                </a>
                                            </li>
                                            
                                            

                                        </ul>
                                    </div>
                                </li>

                                @endif

                                @if (count($dynamics = get_dynamics()))
                                    @foreach ($dynamics as $item)
                                        
                                        <li class="m-menu__item " aria-haspopup="true">
                                            <a href="{{route('admin.posts.create', ['dynamic' => $item->slug])}}" class="m-menu__link ">
                                                <i class="m-menu__link-icon flaticon-file"></i>
                                                <span class="m-menu__link-text">Thêm {{$item->name}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                {{-- <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="../../header/actions.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-diagram"></i>
                                        <span class="m-menu__link-title">
                                            <span class="m-menu__link-wrap">
                                                <span class="m-menu__link-text">Generate Reports</span>
                                                <span class="m-menu__link-badge">
                                                    <span class="m-badge m-badge--success">2</span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="#" class="m-menu__link m-menu__toggle">
                                        <i class="m-menu__link-icon flaticon-chat-1"></i>
                                        <span class="m-menu__link-text">Customer Feedbacks</span>
                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                        <span class="m-menu__arrow "></span>
                                        <ul class="m-menu__subnav">
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="../../header/actions.html" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Customer Feedbacks</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="../../header/actions.html" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Supplier Feedbacks</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="../../header/actions.html" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Reviewed Feedbacks</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="../../header/actions.html" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Resolved Feedbacks</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="../../header/actions.html" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Feedback Reports</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="../../header/actions.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-users"></i>
                                        <span class="m-menu__link-text">Register Member</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                        <a href="{{route('home')}}" target="_blank" class="m-menu__link">
                            <i class="m-menu__link-icon fa fa-home"></i>
                            <span class="m-menu__link-text">Xem trang chủ</span>
                        </a>
                    </li>
                </ul>
            </div>