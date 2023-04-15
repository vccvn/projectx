<article class="help_text" id="{{$data->id?$data->id:'component-' . $component->id}}">
    <h4 class="c_head">{{$data->title}}</h4>
    <div class="help_info">
        {!!
            $html->help_area->components
        !!}
    </div>

</article>

@if ($data->boder_bottom)
<div class="border_bottom"></div>
@endif