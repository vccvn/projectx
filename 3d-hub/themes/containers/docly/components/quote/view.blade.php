
        <section class="about-journalism">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 md-order-two">
                        <div class="journalism-content-wrapper">
                            @if ($data->show_quote)
                                <div class="quote wow fadeIn">
                                    <img src="{{theme_asset('img/home_support/quote-top.png')}}" alt="quote">
                                </div>
                            
                            @endif
                            <h2 class="journalism-title wow fadeInUp" data-wow-delay="0.3s">
                                {!! $data->title !!}
                            </h2>

                            <p class="description wow fadeInUp" data-wow-delay="0.5s">
                                {!!$data->description!!}
                            </p>

                            @if ($data->show_author)
                                
                            <div class="journalism-info wow fadeInUp" data-wow-delay="0.3s">
                                <h3 class="name">
                                    @if ($data->author_link)
                                        <a href="{{$data->author_link}}">{{$data->author_name}}</a>
                                    @else
                                        {{$data->author_name}}
                                    @endif
                                </h3>
                                <span class="designation">{{$data->author_job}}</span>
                            </div>

                            @endif
                            @if ($data->show_quote)
                                <div class="quote dmt-4 wow fadeIn" data-wow-delay="1s">
                                    <img src="{{theme_asset('img/home_support/quote-bottom.png')}}" alt="quote">
                                </div>

                            @endif
                           
                            
                        </div>
                        <!-- /.journalism-content-wrapper -->
                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-lg-5">
                        <div class="journalism-feature-image wow fadeInRight" data-wow-delay="0.3s">
                            <img src="{{$data->image}}" alt="journalism">
                        </div>
                        <!-- /.journalism-feature-image -->
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
            @if ($data->light_title)
                
            <div class="light-header">
                <h2 class="title-light wow fadeInDown" data-wow-delay="0.4s">{{$data->light_title}}</h2>
            </div>
            
            @endif
        </section>