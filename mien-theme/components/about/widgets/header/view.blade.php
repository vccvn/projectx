<div class="page-header container-lg">

    <div class="inner">
        <h2 class="title">{{ $data->title }}</h2>
        <div class="spactor"></div>

        @if ($data->sub_title)
            <h3 class="sub-title">
                {!! nl2br($data->sub_title) !!}
            </h3>
        @endif
        <div class="description">
            <div class="text">
                {!! nl2br($data->description) !!}
            </div>
        </div>
    </div>

</div>