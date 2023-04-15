

<form class="subcribe-box subcribe-box {{parse_classname('subcribe-form')}} " method="post" action="{{route('client.subcribe')}}">
    <h5>{{$data->title}}</h5>
    <p>{{$data->description}}</p>
    <input placeholder="Nhập email" name="email" type="email" />
    <button type="submit" class="btn -normal">Đăng ký</button>
</form>