<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('static/crazy/js/attribute.js');

$wrapper = $input->copy();
$wrapper->type = "attribute";
$wrapper->prepareCrazyInput();

$inputParams = $wrapper->getInputData(false);
$attributeGroupLabels = [
    'attributes' => 'Thuộc tính',
    'variants' => 'Biến thể'
];

$wrp = $wrapper->copy();
$wrp->removeClass()->addClass("product-attributes");
$wrp->name = null;
$wrp->id = 'product-attributes';
$wrp->type = null;
$wrp->placeholder = null;

?>


<div {!! $wrp->attrsToStr() !!}>
    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--info" role="tablist">
        @foreach ($inputParams as $group => $inputs)
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link {{$loop->index==0?'active show':''}}" data-toggle="tab" href="#product-{{$group}}-tab" role="tab" aria-selected="true">
                {{$attributeGroupLabels[$group]}}

                @if (($group == 'attributes' && $errors->first('attributes')) || ($group == 'variants' && ($errors->first('variant_price') || $errors->first('variant_images') || $errors->first('variant_colors')))))
                    <span class="m-badge m-badge--danger m-badge--dot"></span>
                @endif
            </a>
        </li>
            
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($inputParams as $group => $attributes)
        
        <div class="tab-pane {{$loop->index==0?'active show':''}}" id="product-{{$group}}-tab" role="tabpanel">
            @if ($group == 'attributes')
                @foreach ($attributes as $rule => $attrs)
                    <div id="product-attributes-{{$rule}}">
                        @foreach ($attrs as $attr)
                            @include('admin.forms.attribute-input', [
                                'params' => $attr->toProductInputParam($wrapper->parent->hidden_id->val()),
                                'root_name' => $wrapper->name
                            ])
                        @endforeach
                    </div>
                
                    
                    
                @endforeach
            @else
                <div id="product-attributes-variants">
                    
                    @foreach ($attributes as $attribute)
                        @include('admin.forms.attribute-input', [
                            'params' => $attribute->toProductInputParam($wrapper->parent->hidden_id->val()),
                            'root_name' => $wrapper->name
                        ])
                    @endforeach
                </div>
            @endif
        </div>
            
        @endforeach
    </div>
</div>