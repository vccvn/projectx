@php
    $tabs = $html->home_tabs->components->getComponents();
    $active = 0;
    if(count($tabs)){
        foreach ($tabs as $i => $tab) {
            if($tab->data->active){
                $active = $i;
            }
        }
    }
@endphp
<article class="test_version" id="version">
    <h4 class="c_head">{{$data->title}}</h4>
    <p>
        {!! $data->description !!}
    </p>
    @if (count($tabs))
        
    <ul class="nav nav-tabs v_menu" id="myTab" role="tablist">
        @foreach ($tabs as $tab)
        <li class="nav-item">
            <a class="nav-link {{$loop->index == $active ? 'active' : ''}}" id="tab-{{$tab->component->id}}" data-toggle="tab" href="#tab-content-{{$tab->component->id}}" role="tab" aria-controls="card" aria-selected="true"><span>{{$loop->index+1}}</span>{{ $tab->data->title }}</a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach ($tabs as $tab)
            <div class="tab-pane fade pb-2 {{$loop->index == $active ? 'show active' : ''}}" id="tab-content-{{$tab->component->id}}" role="tabpanel" aria-labelledby="tab-{{$tab->component->id}}">
                {!! $tab->data->content !!}
            </div>
        @endforeach
    </div>
    
    @endif
</article>
@if ($data->boder_bottom)
    <div class="border_bottom"></div>
@endif