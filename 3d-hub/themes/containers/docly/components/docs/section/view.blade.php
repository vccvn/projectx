<article class="developer" id="{{$data->id?$data->id:'component-' . $component->id}}">
    <h4 class="c_head">{{$data->title}}</h4>
    <div>
        {!! $data->content !!}
    </div>
</article>
@if ($data->boder_bottom)
    <div class="border_bottom"></div>
@endif