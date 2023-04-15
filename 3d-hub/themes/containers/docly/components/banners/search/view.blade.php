<section class="doc_banner_area_two">
    <div class="b_plus one" data-parallax='{"x": 250, "y": 160, "rotateZ":500}'><img src="{{theme_asset('img/home_two/plus.png')}}" alt=""></div>
    <div class="b_plus two" data-parallax='{"x": 250, "y": 260, "rotateZ":500}'><img src="{{theme_asset('img/home_two/plus_one.png')}}" alt=""></div>
    <div class="b_round r_one" data-parallax='{"x": 0, "y": 100, "rotateZ":0}'></div>
    <div class="b_round r_two" data-parallax='{"x": -10, "y": 80, "rotateY":0}'></div>
    <div class="b_round r_three"></div>
    <div class="b_round r_four"></div>
    <img class="p_absolute building_img" src="{{theme_asset('img/home_two/building.png')}}" alt="">
    <img class="p_absolute table_img wow fadeInLeft" src="{{theme_asset('img/home_two/table')}}" alt="">
    <img class="p_absolute flower wow fadeInUp" data-wow-delay="0.6s" src="{{theme_asset('img/home_two/flower.png')}}" alt="">
    <img class="p_absolute bord wow fadeInRight" data-wow-delay="0.4s" src="{{theme_asset('img/home_two/bord.png')}}" alt="">
    <img class="p_absolute girl wow fadeInRight" data-wow-delay="0.8s" src="{{theme_asset('img/home_two/girl.png')}}" alt="">
    <div class="container">
        <div class="doc_banner_text_two text-center">
            <h2>{{$data->title}}</h2>
            <p>{{$data->description}}</p>
            <form action="{{route('client.search')}}" class="banner_search_form">
                <input type="search" class="form-control" placeholder="Tìm kiếm...">
                <button type="submit" class="search_btn">{{$data->button_text('Tìm kiếm')}}</button>
            </form>
        </div>
    </div>
</section>
