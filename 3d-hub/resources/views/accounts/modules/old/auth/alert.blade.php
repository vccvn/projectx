@extends($_layout.'clean')

{{-- khai báo title --}}
@section('title', 'Thông báo')

@section('content')
<?php
    $type = (isset($type) && $type)?$type:(session('type')?session('type'):'success');
    $message = (isset($message) && $message)?$message:(session('message')?session('message'):'Hello World');
    $link = isset($link)?$link:(session('link')?session('link'):route('home'));
    $text = isset($text)?$text:(session('text')?session('text'):'<i class="fa fa-home"></i> Về trang chủ');
    $title = (isset($title) && $title)?$title:(session('title')?session('title'):null);
    
?>
<div class="w-sm-80pc w-md-70pc">
    <div class="ps-section__header text-center">
        <h3>{{$title?$title:'Thông báo'}}</h3>
    </div>
    <div class="ps-section__content">
        <div class="alert alert-{{$type}} text-center">
            {!! $message !!}
        </div>
        <div class="buttons text-center" style="margin: 20px auto;">
            <a href="{{$link}}" class="theme-btn btn-style-two">{!! $text !!}</a>
        </div>
    </div>
</div>
@endsection
