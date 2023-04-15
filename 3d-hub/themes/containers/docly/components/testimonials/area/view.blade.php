@php
    $title = $data->title;
    $background = $data->background(theme_asset('img/home_one/feedback_bg.jpg'));
    $bg = theme_asset('img/bg.jpg');
@endphp

<section class="doc_feedback_area parallaxie sec_pad" data-background="{{$bg}}" style="background: url({{$background}}) no-repeat scroll;">
    <div class="overlay_bg"></div>
    <div class="container">
        <div class="doc_feedback_info">
            <div class="doc_feedback_slider">
                 
                @if ($data->list_type == 'data')
                    @if ($data->item_number > 0 && count($testimonials = $helper->getTestimonials(['@sort' => $data->sort_type, '@limit' => $data->item_number])))
                        @foreach ($testimonials as $testimonial)
                            <!--Testimonail Item-->
                            

                            <div class="item">
                                <div class="author_img">
                                    <img src="{{$testimonial->image}}" alt="{{$testimonial->name}}">
                                </div>
                                <p>
                                    {{$testimonial->content}}
                                </p>
                                <h5>{{$testimonial->name}}</h5>
                                <h6><a href="{{$testimonial->link?$testimonial->link:'#'}}">{{$testimonial->job}}</a></h6>
                            </div>
                            
                        @endforeach
                    @endif
                @else
                    <!--Testimonials -->
                    {!! $html->testimonials->components !!}
                @endif
                    
            </div>
            <div class="slider_nav">
                <div class="prev">
                    <span class="arrow"></span>
                </div>
                <div class="next">
                    <span class="arrow"></span>
                </div>

            </div>
        </div>
    </div>
</section>