

@php
    $socials = $options->theme->socials;
    $list = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin']
@endphp
    <div class="sidebar-item social-sidebar">
        <div class="title">
            <h4>{{$data->title}}</h4>
        </div>
        <div class="sidebar-info">
            <ul>
                @foreach ($list as $item)
                    @if ($link = $data->get($item, $socials->get($item)))
                        <li class="{{$item}}">
                            <a href="{{$link}}">
                                <i class="fab fa-{{$item == 'facebook'?$item . '-f':$item}}"></i>
                            </a>
                        </li>
                        
                    @endif
                @endforeach
                
            </ul>
        </div>
    </div>