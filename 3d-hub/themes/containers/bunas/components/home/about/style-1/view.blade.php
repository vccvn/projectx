

    <div class="about-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-5 thumb">
                    <div class="thumb-img">
                        <img src="{{$data->image(theme_asset('img/about/1.jpg'))}}" alt="{{$siteinfo->site_name}}">
                        <div class="video">
                            <a href="{{$data->youtube_url}}" class="popup-youtube video-play-button">
                                <i class="ti-control-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 info">
                    <h2>{!! $data->title !!}</h2>
                    @if ($p = nl2array($data->content))
                        @foreach ($p as $t)
                            <p>{!!$t!!}</p>
                        @endforeach
                    @endif
                    
                    <ul>
                        @if ($ul = nl2array($data->services))
                            @foreach ($ul as $li)
                                <li>{{$li}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>