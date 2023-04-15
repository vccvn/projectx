
    <article class="documentation_body" id="{{$data->id?$data->id:'component-' . $component->id}}">
        <div class="shortcode_title">
            <h2>{{$data->title}}</h2>
            <p>{!! $data->description !!}</p>
        </div>
        <div class="row">
            {!! $html->docbody->components !!}
        </div>
    </article>
    @if ($data->boder_bottom)
        <div class="border_bottom"></div>
    @endif