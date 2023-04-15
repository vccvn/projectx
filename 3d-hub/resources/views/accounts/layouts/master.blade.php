<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    @include($_template.'head')
</head>

<?php
$show = 'ms-aside-left-open';
if((isset($hide_sidebar) && $hide_sidebar) || $__env->yieldContent('hide_sidebar')){
    $show = '';
}
?>

<body class="ms-body ms-primary-theme {{$show}}">
    <!-- Preloader -->
    <div id="preloader-wrap">
        <div class="spinner spinner-8">
            <div class="ms-circle1 ms-child"></div>
            <div class="ms-circle2 ms-child"></div>
            <div class="ms-circle3 ms-child"></div>
            <div class="ms-circle4 ms-child"></div>
            <div class="ms-circle5 ms-child"></div>
            <div class="ms-circle6 ms-child"></div>
            <div class="ms-circle7 ms-child"></div>
            <div class="ms-circle8 ms-child"></div>
            <div class="ms-circle9 ms-child"></div>
            <div class="ms-circle10 ms-child"></div>
            <div class="ms-circle11 ms-child"></div>
            <div class="ms-circle12 ms-child"></div>
        </div>
    </div>
    <!-- Overlays -->
    <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
    <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
    @include($_template.'sidebar')

    <!-- Main Content -->
    <main class="body-content">
        <!-- Navigation Bar -->
        @include($_template.'nav')
        <div class="ms-content-wrapper">
            <div class="row">
                @if ($header_title = $__env->yieldContent('header_title'))
                <div class="col-md-12">
                    <h1 class="db-header-title">{{$header_title}}</h1>
                </div>
                
                @endif
                <div class="col-sm-12">
                @yield('content')
                </div>
            </div>
        </div>
        
    </main>
    <!-- MODALS -->
    @yield('modal')
    @include($_template.'modals')
    <!-- SCRIPTS -->
    
    @include($_template.'js', ['checkAuth' => true])
</body>



</html>

