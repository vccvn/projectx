<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
        @if ($notice_badge)
        <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
        @endif
        
        <span class="m-nav__link-icon">
            <i class="flaticon-music-2"></i>
        </span>
    </a>
    <div class="m-dropdown__wrapper">
        <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
        <div class="m-dropdown__inner">
            <div class="m-dropdown__header m--align-center" style="background: url({{asset('static/manager/assets/app/media/img/misc/notification_bg.jpg')}}); background-size: cover;">
                <span class="m-dropdown__header-title">{{$notice_badge}} New</span>
                <span class="m-dropdown__header-subtitle">Thông báo</span>
            </div>
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                Thông báo mới
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items" id="topbar-notification-list">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>