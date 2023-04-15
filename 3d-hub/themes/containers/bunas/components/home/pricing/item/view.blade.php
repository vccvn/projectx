
                    <div class="col-lg-4 col-md-4 single-item">
                        <div class="pricing-item {{$data->active?'active':''}}">
                            <ul>
                                <li class="pricing-header">
                                    <h4>{{$data->title}}</h4>
                                    @if ($data->label)
                                    <span class="badge">{{$data->label}}</span>
                                    @endif
                                </li>
                                {!! 
                                    implode('', array_map(function($line){
                                        return '<li>'
                                            . str_replace(
                                                ['[t]', '[T]', '[check]', '[v]'],
                                                '<i class="fas fa-check"></i>',

                                                str_replace(
                                                    ['[f]', '[F]', '[times]', '[x]'],
                                                    '<i class="fas fa-check"></i>',
                                                    $line
                                                )
                                            )
                                        .'</li>';
                                    }, nl2array($data->content)))
                                !!}
                                <li class="price">

                                    <h2>
                                        <sup class="fs-14">{{$data->price_label}}</sup>{{number_format($data->price, 0, ',', '.')}}<sub class="fs-20">{{$data->unit}}</sub>
                                        {{-- <sub>/ tháng</sub> --}}
                                    </h2>
                                </li>
                                <li class="footer">
                                    <a class="btn btn-theme effect btn-sm" href="{{$data->link('#')}}">Đăng ký</a>
                                </li>
                            </ul>
                        </div>
                    </div>