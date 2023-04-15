
    <article class="get_started" id="{{$data->id?$data->id:'component-' . $component->id}}">
        <h4 class="c_head">{{$data->title}}</h4>
        <div>
            {!! $data->description !!}
        </div>
    </article>
    @if ($data->boder_bottom)
        <div class="border_bottom"></div>
    @endif