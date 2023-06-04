@extends($_layout . 'master')
@section('title', 'Thông báo')
@section('meta.robots', 'noindex')

@include($_lib . 'register-meta')

@section('content')
    <?php
    $type = isset($type) && $type ? $type : (session('type') ? session('type') : 'success');
    $message = isset($message) && $message ? $message : (session('message') ? session('message') : 'Hello World');
    $link = isset($link) ? $link : (session('link') ? session('link') : route('home'));
    $text = isset($text) ? $text : (session('text') ? session('text') : '<i class="fa fa-home"></i> Về trang chủ');
    $title = isset($title) && $title ? $title : (session('title') ? session('title') : null);
    
    ?>


    <div class="slert-page mt-50 mb-50">
        @include($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ])
        <div class="container">
            <div class="alert alert-{{ $type }} text-center">
                {!! $message !!}
            </div>
            <div class="buttons mt-20 text-center">
                <a href="{{ $link }}" class="btn btn-primary" data-bs-target="#doneModal" data-bs-dismiss="modal">{!! $text !!}</a>
            </div>

        </div>
    </div>

@endsection
