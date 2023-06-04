<div class="contact-us">
    <div class="inner">
        <div class="contact-thumbnail">
            <img src="{{$data->thumbnail}}" alt="{{$data->title}}">
        </div>
        <div class="contact-info">
            <h3 class="contact-title">{{$data->title}}</h3>
            <div class="contact-description">
                {{$data->description}}
            </div>
            @if ($data->phone_number || $data->email || $data->address)
                <ul class="contact-items">
                    @if ($data->phone_number)
                        <li><a href="tel:{{$data->phone_number}}">{{$data->phone_number}}</a></li>
                    @endif
                    @if($data->email)
                        <li><a href="mailto:{{$data->email}}">{{$data->email }}</a></li>
                    @endif
                    @if($data->address)
                        <li><span>{{$data->address}}</span></li>
                    @endif
                </ul>
            @endif
        </div>
    </div>
    <div class="buttons">
        <a href="{{$data->url}}" class="mien-button">{{$data->btn_text}}</a>
    </div>
</div>