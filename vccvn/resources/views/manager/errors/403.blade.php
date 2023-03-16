@extends($_layout.'base')

{{-- khai báo title --}}
@section('title', $page_title = isset($title) ? $title : '403 - Truy cập không hợp lệ')

@section('content')
    <?php
    $content = isset($message) && $message ? $message : (($msg = session('message')) ? $msg : 'Dường như bạn đang cố truy cập một đường dẫn không được phép!');
    ?>
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-6" style="background-image: url({{ asset('static/manager/assets/app/media/img//error/bg6.jpg') }});">
        <div class="m-error_container">
            <span class="m-error_subtitle m--font-light">
                <h1>403</h1>
            </span>
            <p class="m-error_description m--font-light">
                {!! $content !!}
                @if ($user = auth()->user())
                    <br>
                    <a href="{{ route('logout') }}" style="color: white; text-decoration: underline; font-size: 1.6rem;"><i class="fa fa-sign-out-alt" style="font-size: 1.6rem;" aria-hidden="true"></i> Đăng xuất</a>

                @endif
            </p>

        </div>
    </div>
@endsection
