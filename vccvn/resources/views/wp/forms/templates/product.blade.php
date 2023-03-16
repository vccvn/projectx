<?php

$baseName = $input->name;
$wrapper = $input->copy();
$wrapper->removeClass(['form-control', 'm-input']);
$wrapper->type = null;
$wrapper->id = $baseName.'-wrapper-block';
$wrapper->prepareCrazyInput();


$old = old($baseName);
$items = $old??$input->value;
$maxIndex = (is_array($items) && $items)?count($items):0;
$wrapper->data('max-index', $maxIndex);
$nextIndex=0;
?>

<div {!! $wrapper->attrsToStr() !!}>

    <div class="product-items">
        @if ($maxIndex)
            @foreach ($items as $index => $item)
            
                @if (isset($item['product_id']) && $item['product_id'] && $param = get_order_product_item_input($item['product_id'], (isset($item['attr_values']) && is_array($item['attr_values']))?$item['attr_values']:[]))
                    <?php $nextIndex = $index+1; ?>
                    @include($_base.'forms.templates.order-item', 
                        array_merge($param, [
                            'name' => $baseName,
                            'index' => $index,
                            'quantity' => $item['quantity']??1
                        ])
                    )
                @endif
            @endforeach
        @endif
    </div>
    <div class="d-none next-index" data-next-index="{{$nextIndex}}"></div>
    <div class="add-product-block">
        <div class="mt-1 mb-4 crazy-form-group row">
            <label class="col-12 coll-sm-4 col-md-3 col-lg-2 col-form-label" for="product-search" >
                Thêm sản phẩm
                
            </label>
            <div class="col-12 coll-sm-8 col-md-9 col-lg-10">
        
                <?php
                    
                ?>
                
        
                <div class="input-group">
                    @include($_base.'forms.templates.crazyselect', [
                        'input' => html_input([
                            'type' => 'crazyselect',
                            'name' => $baseName . '_items',
                            'id' => $baseName . '-items',
                            'call' => 'get_product_select_options',
                            '@select-type' => 'search',
                            '@search-route' => $route_name_prefix.'products.select-options'
                            
                        ])
                    ])
                    <div class="input-group-append">
                        <a href="javascript:void(0);" class="btn-add-product-item btn btn-success" >
                            Thêm
                        </a>
                    </div>
                </div>
                
                
            </div>
            {{-- end input group --}}
        </div>
    </div>
</div>