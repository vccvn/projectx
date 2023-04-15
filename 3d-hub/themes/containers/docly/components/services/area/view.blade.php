@php
    $link = null;
    $title = null;
    if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
        $link = $dynamic->getViewUrl();
        $title = $dynamic->name;
    }
    if($data->title) $title = $data->title;
    if($data->link) $link = $data->link;
@endphp
<section class="doc_banner_area_two service_area">
    <div class="b_plus one" data-parallax='{"x": 250, "y": 160, "rotateZ":500}'><img src="{{theme_asset('img/home_two/plus.png')}}" alt=""></div>
    <div class="b_plus two" data-parallax='{"x": 250, "y": 260, "rotateZ":500}'><img src="{{theme_asset('img/home_two/plus_one.png')}}" alt=""></div>
    <div class="b_round r_one" data-parallax='{"x": 0, "y": 100, "rotateZ":0}'></div>
    <div class="b_round r_two" data-parallax='{"x": -10, "y": 80, "rotateY":0}'></div>
    <div class="b_round r_three"></div>
    <div class="b_round r_four"></div>
    <img class="p_absolute building_img" src="{{theme_asset('img/home_two/building.png')}}" alt="">
    <img class="p_absolute table_img wow fadeInLeft" src="{{theme_asset('img/home_two/table.svg')}}" alt="">
    <img class="p_absolute flower wow fadeInUp" data-wow-delay="0.6s" src="{{theme_asset('img/home_two/flower.png')}}" alt="">
    <img class="p_absolute bord wow fadeInRight" data-wow-delay="0.4s" src="{{theme_asset('img/home_two/bord.png')}}" alt="">
    <img class="p_absolute girl wow fadeInRight" data-wow-delay="0.8s" src="{{theme_asset('img/home_two/girl.png')}}" alt="">
    <div class="container">
        <div class="doc_banner_text_two text-center">
            <h2>{{$data->title('Các dịch vụ')}}</h2>
            <p>{{$data->description}}</p>
        </div>
        <div class="row mt-5 pt-2">
            @if (isset($children) && $children)
                {!! $children !!}
            @else
            {!! $html->home_services->components !!}
            @endif
            

            @if ($link)
                    
            <div class="col-lg-12 text-center wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{$link}}" class="doc_border_btn all_doc_btn">Xem thêm<i class="arrow_right"></i></a>
            </div>
            
            @endif
        </div>
    
    </div>
</section>

