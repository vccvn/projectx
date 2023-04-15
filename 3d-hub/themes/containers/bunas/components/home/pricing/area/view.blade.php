
    <!-- Start Pricing Area
    ============================================= -->
    <div id="pricing" class="pricing-area bg-light default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>{{$data->title('Bảng giá dịch vụ')}}</h2>
                        <p>
                            {{$data->description}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="pricing pricing-simple text-center">
                    {!! $html->home_pricing->components !!}
                </div>
            </div>
        </div>
    </div>
    <!-- End Pricing Area -->
