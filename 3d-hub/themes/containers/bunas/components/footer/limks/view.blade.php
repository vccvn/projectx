

<div class="equal-height col-md-2 col-sm-6 item">
    <div class="f-item link">
        <h4 class="widget-title">{{$data->title('Liên kết')}}</h4>
        @if ($menu = $helper->getCustomMenu(['id'=>$data->menu_id]))
            {!! $menu !!}
        @endif

    </div>
</div>
