<?php 
    $siteinfo = setting();
    $site_name = $siteinfo->site_name('web102'); 
    $web_title = ($full_title = $__env->yieldContent('full_title'))?$full_title:(
        ($short_title = $__env->yieldContent('title'))?$short_title.' | '.$site_name : $siteinfo->title('Trang chủ'.' | '.$site_name)
    );
?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


    @if ($__env->yieldContent('meta.robots') == 'noindex')
    <meta name="robots" content="noindex,follow"/>
    <meta name="googlebot" content="noindex" />
    @endif
    
    
    
    <title>@yield('meta_title', $web_title)</title>
    <meta property="og:site_name" content="{{$site_name}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('static/accounts/iconic-fonts/font-awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/accounts/iconic-fonts/flat-icons/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('static/accounts/iconic-fonts/cryptocoins/cryptocoins.css')}}">
    <link rel="stylesheet" href="{{asset('static/accounts/iconic-fonts/cryptocoins/cryptocoins-colors.css')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('static/accounts/css/bootstrap.min.css')}}">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{asset('static/accounts/css/jquery-ui.min.css')}}">
    <!-- Page Specific CSS (Slick Slider.css) -->
    <link rel="stylesheet" href="{{asset('static/accounts/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('static/accounts/css/datatables.min.css')}}">
    
    <link rel="stylesheet" href="{{asset('static/accounts/css/sweetalert2.min.css')}}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset('static/accounts/libraries/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" type="text/css"/>
    {{-- <link rel="stylesheet" href="{{asset('assets/libraries/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" type="text/css"/> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"> --}}

    <!-- Costic styles -->
    <link rel="stylesheet" href="{{asset('static/accounts/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('static/app/css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('static/accounts/css/custom.min.css')}}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('static/accounts/favicon.ico')}}">
    @yield('css')
    