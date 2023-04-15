@php
    $fact1 = crazy_arr(nl2array($data->fact_1));
    $fact2 = crazy_arr(nl2array($data->fact_2));
    $line1 = crazy_arr(array_map('trim', explode('=', $data->line_1)));
    $line2 = crazy_arr(array_map('trim', explode('=', $data->line_2)));
    $line3 = crazy_arr(array_map('trim', explode('=', $data->line_3)));
@endphp
    <!-- Star Why Chose Us
    ============================================= -->
    <div class="why-us-area shape-box default-padding bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 info">
                    <ul>
                        <li class="fun-fact">
                            <div class="timer" data-to="{{to_number($fact1->get(0))}}" data-speed="5000"></div>
                            <span class="medium">{{$fact1->get(1)}}</span>
                            <p>
                                {{$fact1->get(2)}}
                            </p>
                        </li>
                        <li class="fun-fact">
                            <div class="timer" data-to="{{to_number($fact2->get(0))}}" data-speed="5000"></div>
                            <span class="medium">{{$fact2->get(1)}}</span>
                            <p>
                                {{$fact2->get(2)}}
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 achivements">
                    <!-- Progress Bar Start -->
                    @if ($line1->get(0))
                    <div class="progress-box">
                        <h5>{{$line1->get(0)}} <span class="pull-right">{{$n = to_number($line1->get(1))}}%</span></h5>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" data-width="{{$n}}"></div>
                        </div>
                    </div>
                    @endif
                    @if ($line2->get(0))
                    <div class="progress-box">
                        <h5>{{$line2->get(0)}} <span class="pull-right">{{$n = to_number($line2->get(1))}}%</span></h5>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" data-width="{{$n}}"></div>
                        </div>
                    </div>
                    @endif
                    @if ($line3->get(0))
                    <div class="progress-box">
                        <h5>{{$line3->get(0)}} <span class="pull-right">{{$n = to_number($line3->get(1))}}%</span></h5>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" data-width="{{$n}}"></div>
                        </div>
                    </div>
                    @endif
                    <!-- End Progressbar -->
                </div>
            </div>
        </div>
        <!-- Round Shape -->
        <div class="round-shape">
            <img src="{{theme_asset('img/round-shape.png')}}" alt="Thumb">
        </div>
        <!-- End Round Shape -->
    </div>
    <!-- End Why Chose Us -->