<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('static/crazy/js/attribute.js');
$wrapper = $input->copy();

$wrapper->type = "attribute";
$wrapper->prepareCrazyInput();

$inputParams = $wrapper->getInputData(false);

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
    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--success" role="tablist">
        @foreach ($inputParams as $group => $inputs)
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link {{$loop->index==0?'active show':''}}" data-toggle="tab" href="#product-attributes-{{$group}}" role="tab" aria-selected="true">{{$attributeGroupLabels[$group]}}</a>
        </li>
            
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($inputParams as $group => $attributes)
        
        <div class="tab-pane {{$loop->index==0?'active show':''}}" id="product-attributes-{{$group}}" role="tabpanel">
            @foreach ($attributes as $attribute)
                @include($_current.'attribute-input', [
                    'params' => $attribute->toProductInputParam($wrapper->parent->hidden_id->val()),
                    'root_name' => $wrapper->name
                ])
                
            @endforeach
        </div>
            
        @endforeach
    </div>
</div>