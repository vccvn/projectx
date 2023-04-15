@php
    $list = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];
@endphp
<div class="col-sm-6 col-lg-3 team-item">
    <div class="thumb-summary-wrap box-shadow-block">
        <div class="team-thumb">
            <a href="{{$data->link?$data->link:'#'}}" target="-sefl"> 
                <img src="{{$data->avatar}}" alt="{{$data->name}}">
            </a>
        </div><!-- .team-thumb-->
        <div class="team-text-wrap">
            <h3 class="team-title"><a href="#">{{$data->name}}</a></h3>
            <p class="team-position">{{$data->job}}</p>
        </div><!-- .team-text-wrap -->
        <div class="social-links circle">
            <ul>
                @foreach ($list as $item)
                    @if ($link = $data->get($item))
                    <li class="social-{{$item}}"><a class="link-{{$item}}" href="{{$link}}" target="_blank"><i class="fab fa-{{$item}}"></i></a></li>
                    @endif
                @endforeach
            </ul>
        </div><!-- .social-links -->
    </div> <!-- .team-item -->
</div> <!-- .team-item  -->

