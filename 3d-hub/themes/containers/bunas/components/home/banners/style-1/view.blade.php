
@if (($slider = $helper->getSlider($data->slider_id)) && count($slider->items))
    
    @php

        $contacts = $options->theme->contacts;
        $helper->setWebData('header_style', '2');
        $btnText = $data->btn_text('Xem chi tiết');
    @endphp

    <!-- Start Banner 
    ============================================= -->
    <div class="banner-area top-transparent">
        <div id="bootcarousel" class="carousel inc-top-heading slide carousel-fade animate_text" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner text-light text-center carousel-zoom">
                @foreach ($slider->items as $item)
                    
                <div class="item {{$loop->first?'active':''}}">
                    <div class="slider-thumb bg-cover" style="background-image: url({{$item->getImage()}});"></div>
                    <div class="box-table shadow dark">
                        <div class="box-cell">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="content">
                                            <h2 data-animation="animated slideInDown">
                                                {!! $item->title !!}
                                            </h2>
                                            <p data-animation="animated slideInLeft">
                                                {!! nl2br(strip_tags($item->description)) !!}
                                            </p>
                                            <a data-animation="animated slideInUp" class="btn btn-light border btn-md" href="{{$item->link}}">{{$btnText}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

                
            </div>
            <!-- End Wrapper for slides -->

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#bootcarousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                <span class="sr-only">Trước</span>
            </a>
            <a class="right carousel-control" href="#bootcarousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                <span class="sr-only">Sau</span>
            </a>
        </div>

        <!-- Fixed Address -->
        <div class="fixed-address text-center">
            <div class="container">
                <div class="address-items">
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info">
                                        <span>Địa chỉ</span> {{$contacts->address($siteinfo->address)}}
                                    </div> 
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-envelope-open"></i>
                                    </div>
                                    <div class="info">
                                        <span>Email</span> {{$data->email($contacts->email($siteinfo->email))}}
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="info">
                                        <span>Điện thoại</span> {{$data->phone_number($contacts->phone_number($siteinfo->phone_number))}}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Fixed Address -->

    </div>
    <!-- End Banner -->

    
@endif