@extends($_layout.'base')

{{-- khai báo title --}}
@section('title', $page_title = isset($title)?$title:"404 - Không tìm thấy")

@section('content')
    <?php
    $content = (isset($message) && $message)?$message:(($msg = session('message'))?$msg:'Đường dẫn này hiện không có hoặc đã bị xóa. Vui longh2 kiểm tra lại!');
    ?>
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url({{asset('static/manager/assets/app/media/img//error/bg1.jpg')}});">
        <div class="m-error_container">
            <span class="m-error_number">
                <h1>404</h1>
            </span>
            <p class="m-error_desc">
                {!! $content !!}
            </p>
        </div>
    </div>

@endsection