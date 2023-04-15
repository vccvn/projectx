
@php
    $socials = $options->theme->socials;
@endphp
                <div class="equal-height col-md-4 col-sm-6 item">
                    <div class="f-item about">
                        <h4 class="widget-title">{{$data->titlie('Giới thiệu')}}</h4>
                        <p>
                            {{$data->description($siteinfo->description)}}
                        </p>
                        <ul>
                            @foreach (['facebook' => 'f', 'twitter', 'youtube', 'linkedin' => 'in', 'skype'] as $item => $fk)
                                @php
                                    $f = '';
                                    $k = $fk;
                                    if(!is_numeric($item)){
                                        $f = '-'.$fk;
                                        $k = $item;
                                    }
                                @endphp
                                @if ($link = $socials->get($k))
                                    
                                <li>
                                    <a href="{{$link}}"><i class="fab fa-{{$k}}{{$f}}"></i></a>
                                </li>
                                
                                @endif
                            @endforeach
                        </ul>
                        <form method="POST" action="{{route('client.subcribe')}}"  class="{{parse_classname('subcribe-form')}}">
                            <input type="email" placeholder="Nhập email" class="form-control" name="email">
                            <button type="submit"><i class="fa fa-paper-plane"></i></button>  
                        </form>
                    </div>
                </div>
