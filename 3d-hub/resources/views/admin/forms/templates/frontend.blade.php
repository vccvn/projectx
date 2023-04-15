<?php
// add_css_link('manager/css/deep-select.min.css');
// add_js_src('static/manager/js/deep-select.js');
if($js = $input->hiddenData('js')){
    add_js_src($js);
}
if($css = $input->hiddenData('css')){
    add_css_link($css);
}

$input->type = "frontent";
$data = $input->getInputData();
$defVal = $input->defVal();
?>
<div class="jsom-input frontend" id="{{$input->id}}">
    <div class="input-list-body">

    </div>
    <textarea class="ft value d-none">{!! $defVal?json_encode($defVal):'' !!}</textarea>
    <textarea class="ft template d-none">{!! $input->hiddenData('template') !!}</textarea>
    
</div>