@php
    
@endphp
<div class="services-area bg-gray default-padding bottom-less">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="site-heading text-center">
                    <h2>{{$data->title('Các dịch vụ')}}</h2>
                    <p>
                        {{$data->description}}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="services-items">
                {!! $html->home_services->components !!}
            </div>
        </div>
    </div>
</div>