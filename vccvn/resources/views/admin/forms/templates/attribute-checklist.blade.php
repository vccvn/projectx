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
$wrapper->removeClass()->addClass("m-checkbox-{$listType} checklist attribute-".$wrapper->data('attribute-id'). "-wrapper");
$wrapper->name = null;
$wrapper->type = null;
$wrapper->placehoder = null;
$wrapper->id = 'attribute-'.$wrapper->data('attribute-name'). '-wrapper';


?>






<div {!! $wrapper->attrsToStr() !!}>
    @if (count($options))
        @foreach ($options as $value => $text)

        <label class="m-checkbox m-checkbox--solid m-checkbox--success">
            <input 
                type="checkbox" 
                class="attr-checkbox" 
                name="{{$input->name}}" 
                id="{{$input->id.'-'.str_slug($value)}}" 
                value="{{$value}}" 
                @if(in_array($value, $disable)) disabled="true" @endif 
                @if(in_array($value, $defaultValues)) checked @endif> 
            {{$text}}
            <span></span>
        </label>
    
        @endforeach

        
    @endif
    <label class="btn-add-value-block">
        <a href="javascript:void(0);" class="btn-add-attribute-value ref-checklist" 
            data-id="{{$wrapper->data('attribute-id')}}" 
            data-value-type="{{$wrapper->data('attribute-value-type')}}" 
            data-label="{{$wrapper->data('attribute-label')}}">
            Thêm
        </a>
    </label>
</div>

<div class="d-none crazy-hidden-template" style="display:none" id="{{'attribute-'.$wrapper->data('attribute-id'). '-template'}}">
    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
        <input 
            type="checkbox" 
            class="attr-checkbox" 
            name="{{$input->name}}" 
            id="{{$input->id.'-'}}{$value}" 
            value="{$value}"> 
        {$text}
        <span></span>
    </label>
</div>




