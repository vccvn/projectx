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






<ul class="ms-list d-flex flex-wrap">
    @if (count($options))
        @foreach ($options as $value => $text)
            <li class="ms-list-item pl-0 mb-0 pt-1 pb-1">
                <label class="ms-checkbox-wrap">
                    <input type="checkbox" class="checkbox" name="{{$input->name}}" id="{{$input->id.'-'.str_slug($value)}}" value="{{$value}}" @if(in_array($value, $disable)) disabled="true" @endif @if(in_array($value, $defaultValues)) checked @endif> 
                    <i class="ms-checkbox-check"></i>
                </label>
                <label for="{{$input->id.'-'.str_slug($value)}}">{{$text}}</label>
            
            </li>    
        @endforeach
    @endif
    
</ul>

