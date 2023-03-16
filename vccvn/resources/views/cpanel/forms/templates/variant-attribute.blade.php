<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('static/crazy/js/attribute.js');
$wrapper = $input->copy();
$wrapper->type = "attribute";
$wrapper->prepareCrazyInput();

$attributes = $wrapper->getInputData(false);
$attributeGroupLabels = [
    'required' => 'Bắt buộc',
    'optional' => 'Tùy chọn'
];

$wrp = $wrapper->copy();
$wrp->removeClass()->addClass("product-attributes");
$wrp->name = null;
$wrp->id = 'product-attributes';
$wrp->type = null;
$wrp->placeholder = null;

?>


<div {!! $wrp->attrsToStr() !!}>
    <div class="attribute-inputs">
        @foreach ($attributes as $attribute)
            @include($_base.'forms.variant-attribute-input', [
                'params' => $attribute->toProductInputParam($wrapper->parent->hidden_id->val()),
                'root_name' => $wrapper->name
            ])
            
        @endforeach
    </div>
</div>