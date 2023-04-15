@php
    $user = Auth::user();

@endphp

        <nav class="navbar ms-navbar">
            <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
            </div>
            <div class="logo-sn logo-sm ms-d-block-sm">
                <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="{{route('home')}}">
                    <img src="{{asset('static/accountsimg/lottery/lottery-logo-84x41.png')}}" alt="logo">
                </a>
            </div>
            <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
                <li class="ms-nav-item hide-mob">
                    <a href="{{route('home')}}" class="">
                        <i class="fa fa-home"></i> Trang chủ
                        
                    </a>
                </li>
                <!-- Payment -->
                {{-- <li class="ms-nav-item dropdown  hide-mob hide-by-side">
                    <a href="#" class="" id="payment-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-credit-card"></i> Thanh toán
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="payment-dropdown">
                        @if (!($user->type=='admin' && $user->agency_level == 0))
                        <li class="ms-scrollable ms-dropdown-list"> <a class="media" href="{{route('payment.requests.deposit')}}">Nạp tiền</a> </li>
                        <li class="ms-scrollable ms-dropdown-list"> <a class="media" href="{{route('payment.requests.withdraw')}}">Rút tiền</a> </li>

                        
                        <li class="ms-scrollable ms-dropdown-list"> <a class="media" href="{{route('payment.requests.history')}}">Lịch sử</a> </li>
                            
                        @endif
                        @if ($user->type!='user')
                        <li class="ms-scrollable ms-dropdown-list"> <a class="media" href="{{route('payment.requests.list')}}">Yêu cầu thanh toán</a> </li>
                        @endif

                        <li class="ms-scrollable ms-dropdown-list"> <a class="media" href="{{route('payment.banks')}}">Ngân hàng</a> </li>

                        

                    </ul>
                </li> --}}


                <li class="ms-nav-item dropdown">
                    @php
                        $unreadaed =  0; // count_notifications(['read'=>0]);
                    @endphp
                    <a href="#" class="text-disabled @if ($unreadaed) ms-has-notification @endif" badge-count="{{$unreadaed}}" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon-bell"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header ms-inline m-0">
                                <span class="text-disabled">Thông báo</span>
                            </h6>
                            @if ($unreadaed)
                                
                            <span class="badge badge-pill badge-info">{{$unreadaed}} thông báo mới</span>
                            @endif
                        </li>
                        <li class="dropdown-divider"></li>

                        <li class="ms-scrollable ms-dropdown-list">
                            {{-- @if (count($notifies = get_notifications(10,['read' => 0])))
                                @foreach ($notifies as $notify)
                                <a class="media p-2 notify-item" href="javascript:void(0)" data-id="{{$notify->id}}" data-type="{{$notify->type}}" data-url="{{$notify->url}}" data-read="{{$notify->read}}" >
                                    <div class="media-body"> 
                                        <span>{{$notify->message}}</span>
                                        <p class="fs-10 my-1 text-disabled">
                                            <i class="material-icons">access_time</i> 
                                            {{$notify->timeAgo()}}
                                        </p>
                                    </div>
                                </a>
                            
                            @endforeach
                            
                            @endif --}}
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-menu-footer text-center"> <a href="#">Tất cả thông báo</a>
                        </li>
                    </ul>
                </li>

                <li class="ms-nav-item ms-nav-user dropdown">
                    <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="ms-user-img ms-img-round float-right" src="{{$user->getAvatar()}}" alt="people">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Xin chào {{$user->name}}</span></h6>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="ms-dropdown-list">
                            <a class="media fs-14 p-2" href="{{route('accounts')}}">
                                <span><i class="flaticon-user mr-2"></i>Profile</span>
                            </a>

                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-menu-footer">
                            <a class="media fs-14 p-2 btn-lock-my-account" href="javascript:void:(0)">
                                <span><i class="flaticon-security mr-2"></i> Khóa</span>
                            </a>
                        </li>
                        <li class="dropdown-menu-footer">
                            <a class="media fs-14 p-2" href="/logout">
                                <span><i class="flaticon-shut-down mr-2"></i> Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
            <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown"
                data-target="#ms-nav-options"> <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
            </div>
        </nav>