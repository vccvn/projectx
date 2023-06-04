<div class="top-banner">
    <div id="top-banner-sliders" class="carousel slide" data-bs-ride="true">
        @if ($data->type == 'slider')
            @if (($slider = $helper->getSlider(['id' => $data->slider_id])) && $slider->items)
                <div class="carousel-indicators">
                    @foreach ($slider->items as $item)
                        @php
                            $i = $loop->index;
                        @endphp
                        <button type="button" data-bs-target="#top-banner-sliders" data-bs-slide-to="{{ $i }}" class="active" aria-current="true" aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach ($slider->items as $item)
                        <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                            <div class="slide-image">
                                <img src="{{ $item->image_url }}" class="d-block w-100" alt="{{ $item->title }}">
                            </div>
                            <div class="slide-text">
                                <h3 class="slide-title">
                                    {!! nl2br($item->title) !!}
                                </h3>
                                @if ($item->description)
                                    <div class="slide-description">
                                        {!! nl2br($item->description) !!}
                                    </div>
                                @endif

                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @else
            @if (isset($children) && ($t = count($children)))

                <div class="carousel-indicators">
                    @for ($i = 0; $i < $t; $i++)
                        <button type="button" data-bs-target="#top-banner-sliders" data-bs-slide-to="{{ $i }}" class="active" aria-current="true" aria-label="Slide {{ $i + 1 }}"></button>
                    @endfor
                </div>

                <div class="carousel-inner">

                    {!! $children ?? '' !!}
                </div>
            @endif
        @endif
        <button class="carousel-control-prev" type="button" data-bs-target="#top-banner-sliders" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#top-banner-sliders" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
