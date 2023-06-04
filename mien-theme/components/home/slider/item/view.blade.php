<div class="carousel-item {{ $data->index == 0 ? 'active' : '' }}">
    <div class="slide-image">
        <img src="{{ $data->image_url }}" class="d-block w-100" alt="{{ $data->title }}">
    </div>
    <div class="slide-text">
        <h3 class="slide-title">
            {!! nl2br($data->title) !!}
        </h3>
        @if ($data->description)
            <div class="slide-description">
                {!! nl2br($data->description) !!}
            </div>
        @endif

    </div>

</div>