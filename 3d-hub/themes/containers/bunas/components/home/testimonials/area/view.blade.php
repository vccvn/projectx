

    <!-- Star Testimonials
    ============================================= -->
    <div class="testimonials-area default-padding bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>{{$data->title("Các dự án")}}</h2>
                        <p>
                            {{$data->description}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="testimonial-items testimonial-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        @if ($data->list_type == 'data')
                            @if ($data->item_number > 0 && count($testimonials = $helper->getTestimonials(['@sort' => $data->sort_type, '@limit' => $data->item_number])))
                                @foreach ($testimonials as $testimonial)
                                    
                                    <div class="item">
                                        <div class="thumb">
                                            <img src="{{$testimonial->image}}" alt="Thumb">
                                        </div>
                                        <div class="info">
                                            <h4>{{$testimonial->name}}</h4>
                                            <span>{{$testimonial->job}}</span>
                                            <p>
                                                {{$testimonial->content}}
                                            </p>
                                            
                                        </div>
                                    </div>

                                @endforeach
                            @endif
                        @else
                        <!--Testimonials -->
                            {!! $html->testimonials->components !!}
                        @endif
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->
