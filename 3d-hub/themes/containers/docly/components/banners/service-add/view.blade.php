<section class="doc_banner_area_one banner_add_service_area">
    <img class="p_absolute star" src="{{theme_asset('img/home_one/banner_bg_two.png')}}" alt="">
    <img class="dark" src="{{theme_asset('img/home_one/wave_one.svg')}}" alt="">
    <img class="dark_two" src="{{theme_asset('img/home_one/wave_two.svg')}}" alt="">
    <img class="p_absolute star_one" src="{{theme_asset('img/home_one/star.png')}}" alt="">
    <img class="p_absolute star_two" src="{{theme_asset('img/home_one/star.png')}}" alt="">
    <img class="p_absolute star_three" src="{{theme_asset('img/home_one/star.png')}}" alt="">
    <img class="p_absolute one wow fadeInLeft" data-wow-delay="0.1s" src="{{theme_asset('img/home_one/b_man.png')}}" alt="">
    <img class="p_absolute two wow fadeInRight" data-wow-delay="0.2s" src="{{theme_asset('img/home_one/b_man_two.png')}}" alt="">
    <img class="p_absolute three wow fadeInUp" data-wow-delay="0.3s" src="{{theme_asset('img/home_one/flower.png')}}" alt="">
    <img class="p_absolute four wow fadeInRight" data-wow-delay="0.4s" src="{{theme_asset('img/home_one/girl_img.png')}}" alt="">
    <img class="p_absolute five wow fadeIn" data-wow-delay="0.5s" src="{{theme_asset('img/home_one/file.png')}}" alt="">
    <img class="p_absolute bl_left" src="{{theme_asset('img/v.svg')}}" alt="">
    <img class="p_absolute bl_right" src="{{theme_asset('img/home_one/b_leaf.svg')}}" alt="">
    <div class="container">
        <div class="doc_banner_text">
            <h2 class="wow fadeInUp" data-wow-delay="0.3s">{{$data->title('Bạn đang cần một trang web để kinh doanh?')}}</h2>
            <p class="wow fadeInUp" data-wow-delay="0.5s">
                {{$data->description("Hãy chọn một gói dịch vụ và tên miền bạn thích nhất. Bạn sẽ có mọt trang web theo ý mình trong vòng 3 nốt nhạc")}}
            </p>
            <form action="{{route('client.services.add')}}" class="banner_search_form banner_search_form_two banner_add_service_form">
                <div class="input-group">
                    <div class="input-group-prepend">
                        {!!
                            html_input([
                                'type' => 'select',
                                'name' => 'service_id',
                                'id' => 'inlineFormCustomSelect1',
                                'class' => 'custom-select',
                                'data' => docly_get_service_options([], "Gói dịch vụ"),
                                'default' => $request->service_id
                            ])
                        !!}
                    </div>
                    <input type="text" class="form-control" name="subdomain" placeholder="Nhập Tên miền...">
                    <div class="input-group-append">
                        {!!
                            html_input([
                                'type' => 'select',
                                'name' => 'domain',
                                'id' => 'inlineFormCustomSelect',
                                'class' => 'custom-select',
                                'data' => get_cfg_domain_options(),
                                'default' => $request->domain
                            ])
                        !!}
                    </div>
                    <button type="submit">
                        {!!$data->create_button('Khởi tạo')!!}
                    </button>
                </div>
            </form>
            <h6>{!! $data->comment !!}</h6>
        </div>
    </div>
</section>
