@php
    $html->addTagAttribute('html', 'lang', 'vi-VN');
    $html->addTagAttribute('body', [
        'class' => $__env->yieldContent('body.class')
    ]);
    
@endphp
@extends($_lib . 'layout')
@section('body')
    <!-- header start -->
    @include($_template . 'header')
    <!-- header end -->

    @yield('content')

    <!-- footer start -->
    @php
        $disableFooter = $__env->yieldContent('disable_footer');
    @endphp
    @if (!$disableFooter)
        @include($_template . 'footer')
    @endif
    @include($_template . 'js')
@endsection
