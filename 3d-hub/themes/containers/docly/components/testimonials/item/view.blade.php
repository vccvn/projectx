
<div class="item">
    <div class="author_img">
        <img src="{{$data->image}}" alt="{{$data->name}}">
    </div>
    <p>
        {{$data->content}}
    </p>
    <h5>
        @if ($data->link)
        <a href="{{$data->link?$data->link:'#'}}">{{$data->name}}</a>
        @else
        {{$data->name}}
        @endif
        
    </h5>
    <h6>{{$data->job}}</h6>
</div>