<?php

$def = $input->defVal();
$options = $input->data;
$defaultValues = old($input->name, $def);

$wrapper = $input->copy();
$wrapper->removeClass()->addClass("color-select");
$wrapper->name = null;
$wrapper->type = null;
$wrapper->placehoder = null;
$wrapper->id = $wrapper->id. '-wrapper';

?>


<ul {!! $wrapper->attrsToStr() !!}>
                
    @foreach ($options as $value => $color)
        <li class="color-option">
            <input type="radio" id="color-select-{{$color['value']}}" name="{{$input->name}}" class="color-option-radio" value="{{$value}}" @if($color['value'] == $def) checked @endif>
            <label for="color-select-{{$color['value']}}" class="color-option-label " style="background-color:{{$color['color']}}">
                <span class="color-option-text">{{$color['text']}}</span>
            </label>
            <div class="color-tooltip">
                <div class="color-option-text">{{$color['text']}}</div>
            </div>
        </li>
    @endforeach
    

</ul>
