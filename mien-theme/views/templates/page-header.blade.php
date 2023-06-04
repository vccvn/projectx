@php
    $t = isset($title) && $title ? $title : $__env->yieldContent('page.header.title');
    $st = isset($sub_title) && $sub_title ? $sub_title : (isset($subTitle) && $subTitle ? $subTitle : $__env->yieldContent('page.header.sub-title', $__env->yieldContent('page.header.subTitle')));
@endphp

<div class="page-header container-lg">

    <div class="inner">
        <h2 class="title">{{ $t ?? '' }}</h2>
        <div class="spactor"></div>

        @if ($st)
            <h3 class="sub-title">
                {!! nl2br($st) !!}
            </h3>
        @endif
    </div>

</div>
