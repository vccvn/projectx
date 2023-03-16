
    <!-- Sidebar Navigation Left -->
    <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
        <!-- Logo -->
        <div class="logo-sn ms-d-block-lg">
            <a class="pl-0 ml-0 text-center" href="/">
                <img src="{{siteinfo()->logo}}" alt="">
            </a>
        </div>
        <!-- Navigation -->
        <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
            <!-- orders -->
            <li class="menu-item">
                <a href="{{route('accounts.dashboard')}}"> <span><i class="fas fa-clipboard-list fs-16"></i>Home</span>
                </a>
            </li>
            <!-- Pages -->
            <li class="menu-item">
                <a href="{{route('accounts.settings')}}" class="has-chevron" data-toggle="collapse" data-target="#profile-menu" aria-expanded="false"
                    aria-controls="profile-menu">
                    <span><i class="material-icons fs-16">account_circle</i>Profile</span>
                </a>
                <ul id="profile-menu" class="collapse" aria-labelledby="profile-menu" data-parent="#side-nav-accordion">
                    
                    @if ($settings = get_account_setting_configs())
                        @php
                            if(get_web_type() != 'ecommerce'){
                                unset($settings['customer']);
                            }
                        @endphp
                        @foreach ($settings as $sk => $item)
                            <li class="menu-item"><a class="" href="{{route('accounts.settings.tab', ['tab' => $item->slug])}}">{{$item->title}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </li>
            
        </ul>
    </aside>