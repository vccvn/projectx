<?php 
    $site_name = $siteinfo->site_name('DH Team'); 
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
   
    <!-- http-equive -->
    <meta http-equiv="Content-Language" content=”vi”>
    <meta http-equiv="Content-Type" content=”text/html; charset=utf-8″>
    <meta http-equiv="description" content="@yield('meta_description', $__env->yieldContent('description', $siteinfo->meta_description))" />
    <meta http-equiv="keywords" content="@yield('keywords', $siteinfo->keywords)">
    <!-- /http-equive -->


    <meta name="title" content="@yield('meta_title', $web_title)">
    <meta name="description" content="@yield('meta_description', $__env->yieldContent('description', $siteinfo->meta_description))">
    <meta name="keywords" content="@yield('keywords', $siteinfo->keywords)">
    <meta name="image" content="@yield('image', $siteinfo->web_image)">

    {{-- meta seo --}}
    
    <!-- seo -->
    <link rel="canonical" href="{{url()->current()}}" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="@yield('page.type', 'website')" />
    <meta property="og:title" content="@yield('meta_title', $web_title)" />
    <meta property="og:description" content="@yield('meta_description', $__env->yieldContent('description', $siteinfo->meta_description))" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:site_name" content="{{$siteinfo->site_name}}" />

    @if($__env->yieldContent('page.type') == 'article')

    <meta property="article:publisher" content="{{$siteinfo->facebook}}" />
    <meta property="article:section" content="@yield('article_section', 'Tin tức')" />
    <meta property="article:published_time" content="@yield('published_time','2018-04-22T19:48:13+07:00')" />
    <meta property="article:modified_time" content="@yield('modified_time','2018-04-22T19:48:13+07:00')" />
    <meta property="og:updated_time" content="@yield('modified_time','2018-04-22T19:48:13+07:00')" />
    
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    @endif
    
    <meta property="og:image" content="@yield('image', $siteinfo->web_image)" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="@yield('description', $siteinfo->description)" />
    <meta name="twitter:title" content="@yield('meta_title', $web_title)" />
    <meta name="twitter:site" content="@yield('twitter_site', $siteinfo->twitter_site)" />
    <meta name="twitter:image" content="@yield('image', $siteinfo->web_image)" />
    <meta name="twitter:creator" content="@yield('twitter_site', $siteinfo->twitter_creator)" />
    <script type='application/ld+json'>{!!json_encode([
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "url" => url('/'),
        "sameAs"=>[$siteinfo->facebook,$siteinfo->twitter],
        "@id" => url('/')."#organization",
        "name" => $siteinfo->site_name,
        "logo" => $siteinfo->logo
    ], true) !!}</script>
    <!-- / SEO  -->

    {{-- end meta seo --}}



    <!-- Icons -->
    
    @php
        $apple_sizes = [57, 114, 72, 144, 60, 120, 76, 152];
        $favicos = [196, 96, 32, 16, 128];
    @endphp
    @foreach ($apple_sizes as $size)
        @if ($apple_touch_icon = $__env->yieldContent('apple.touch.icon.'. $size .'x' . $size, $favicons->get('apple_touch_icon_'. $size .'x' . $size)))<link rel="apple-touch-icon-precomposed" sizes="{{$size . 'x' . $size}}" href="{{$apple_touch_icon}}" />@endif
    @endforeach
    @foreach ($favicos as $size)
    @if ($favicon = $__env->yieldContent('favicon.'. $size .'x' . $size, $favicons->get('favicon_'. $size .'x' . $size)))<link rel="icon" type="image/png" sizes="{{$size . 'x' . $size}}" href="{{$favicon}}" />@endif
    @endforeach

    <meta name="application-name" content="{{$siteinfo->site_name}}"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />

    @if ($favicon = $__env->yieldContent('mstile.144x144', $favicons->mstile_144x144))
        <meta name="msapplication-TileImage" content="{{$favicon}}" />
    @endif
    @if ($favicon = $__env->yieldContent('mstile.70x70', $favicons->mstile_70x70))
        <meta name="msapplication-square70x70logo" content="{{$favicon}}" />
    @endif
    @if ($favicon = $__env->yieldContent('mstile.150x150', $favicons->mstile_150x150))
        <meta name="msapplication-square150x150logo" content="{{$favicon}}" />
    @endif
    @if ($favicon = $__env->yieldContent('mstile.310x150', $favicons->mstile_310x150))
        <meta name="msapplication-square150x150logo" content="{{$favicon}}" />
        <meta name="msapplication-wide310x150logo" content="{{$favicon}}" />
    @endif
    @if ($favicon = $__env->yieldContent('mstile.310x310', $favicons->mstile_310x310))
        <meta name="msapplication-square310x310logo" content="{{$favicon}}" />
    @endif
    
    <!-- / Icons -->

    @if (($pwa = get_option('settings')->pwa) && $pwa->active)
    
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="white">
    <meta name="theme-color" media="(prefers-color-scheme: dark)"  content="black">
    <link rel="manifest" href="/manifest.json">
    <style>
        
.hidden {
  display: none !important;
}

#installContainer {
  position: absolute;
  bottom: 1em;
  display: flex;
  justify-content: center;
  width: 100%;
}

#installContainer button {
  background-color: inherit;
  border: 1px solid white;
  color: white;
  font-size: 1em;
  padding: 0.75em;
}
    </style>
    
    @endif