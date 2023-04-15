<?php

$def = [];
$options = $input->getInputData();
if(is_array($options) || is_object($options)){
    
    if(is_array($df = $input->defVal())){
        $def = $df;
    }
}
$defaultValues = old($input->name, $def);
$listType = $input->data('list-type') == 'list' ? 'list' : 'inline';
$input->name.='[]';
$disable = is_array($d = $input->hiddenData('disable')) ? $d : [];
// dump($options);

$wrapper = $input->copy();
$wrapper->removeClass()->addClass("m-checkbox-{$listType}");
$wrapper->name = null;
$wrapper->type = null;
$wrapper->placehoder = null;
$wrapper->id = $wrapper->id. '-wrapper';


?>






<div {!! $wrapper->attrsToStr() !!}>
    @if (count($options))
        @foreach ($options as $value => $text)

        <label class="m-checkbox m-checkbox--solid m-checkbox--info">
            <input type="checkbox" class="crazy-checkbox" name="{{$input->name}}" id="{{$input->id.'-'.str_slug($value)}}" value="{{$value}}" @if(in_array($value, $disable)) disabled="true" @endif @if(in_array($value, $defaultValues)) checked @endif> 
            {{$text}}
            <span></span>
        </label>
    
        @endforeach
    @endif
    
</div>




