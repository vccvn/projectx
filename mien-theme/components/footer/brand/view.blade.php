<div class="col-xl-{{$data->col_xl(2)}} col-lg-{{$data->col_lg(3)}} col-md-{{$data->col_md(4)}} col-sm-{{$data->col_sm(6)}} col-sm-{{$data->col_xs(12)}}  {{$data->class}} ">
    <div class="brand-widget">
        <div class="brand-img">
            <a href="/"><img src="{{$data->logo($siteinfo->logo(theme_asset('images/logo.png')))}}" alt="{{$siteinfo->site_name}}" class="footer-logo"></a>
        </div>
        <div class="brand-text">
            <h3>{{$data->title}}</h3>
        </div>
    </div>
</div>