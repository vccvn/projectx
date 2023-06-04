@php
    $tabs = get_product_page_tabs();
    $t = $tab??'all';
@endphp

<div class="tab-block">
    <div class="row tabs">
        @foreach ($tabs as $key => $text)
            <div class="col-4 tab-item">
                <a href="{{route('client.products.'.$key)}}" class="tab-link {{$key == $t ? 'active': ''}}">{{$text}}</a>
            </div>
        @endforeach
    </div>
</div>
