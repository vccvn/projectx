@php
$socials = $options->theme->socials;
$list = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];
@endphp
<div class="col-lg-{{$data->col_lg(4)}} col-sm-{{$data->col_sm(6)}}">
    <div class="f_widget subscribe_widget">
        <a href="index.html" class="f_logo"><img src="{{$siteinfo->logo(theme_asset('img/logo.png'))}}" alt=""></a>
        <h4 class="c_head">{{$data->title}}</h4>
        <form method="post" action="{{route('client.subcribe')}}" class="{{parse_classname('subcribe-form')}} footer_subscribe_form">
            <input type="email" name="email" placeholder="Email" class="form-control">
            <button type="submit" class="s_btn">{{$data->subscribe_button('Đăng ký')}}</button>
        </form>
        <ul class="list-unstyled f_social_icon">
            @foreach ($list as $item)
                @if ($link = $socials->get($item))
                <li><a href="{{$link}}"><i class="social_{{$item}}"></i></a></li>
                @endif
            @endforeach
            
        </ul>
    </div>
</div>