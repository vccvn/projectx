<?php
$sec_class = isset($section_class)?$section_class:null;
$att_class = isset($attribute_class)?$attribute_class:null;
$atn_class = isset($attribute_name_class)?$attribute_name_class:null;
$avl_class = isset($value_list_class)?$value_list_class:null;
$avi_class = isset($value_item_class)?$value_item_class:null;
$sel_class = isset($select_class)?$select_class:null;
$img_class = isset($image_class)?$image_class:null;
$txt_class = isset($value_text_class)?$value_text_class:null;
$rad_class = isset($radio_class)?$radio_class:null;
$lab_class = isset($label_class)?$label_class:(isset($value_label_class)?$value_label_class:null);

$sle_class = isset($select_class)?$select_class:null;
?>

@if ($variant_attributes = $product->getVariantAttributes())
    <div class="{{$sec_class}} {{parse_classname('product-variants')}}">
        @foreach ($variant_attributes as $attribute)
            <?php
                $avt = $attribute->advance_value_type;
            ?>
        <figure class="{{$att_class}} {{parse_classname('product-attribute-item','product-variant-'.$avt,'product-attribute-'.$avt)}}">
            <figcaption class="{{$atn_class}} ">{{$attribute->label}}</figcaption>
            @if ($avt != 'default')
                <ul class="{{$avl_class}} {{parse_classname('product-attribute-values', 'product-attribute-'.$avt.'-values')}} {{$attribute->list_class}}">

                    @php
                        $def = null;
                        foreach ($attribute->values as $attr) {
                            if($attr->is_defauly) $def = $attr->value_id;
                        }
                    @endphp
                    @foreach ($attribute->values as $attrValue)
                        <li class="{{$avi_class}} {{parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')}}">
                            <input type="radio" id="product-variants-{{$attribute->name}}-{{$attrValue->value_id}}" name="attrs[{{$attribute->name}}]" class="{{$rad_class}} {{parse_classname('radio-value-input')}} {{$attrValue->item_class}}" data-value-id="{{$attrValue->value_id}}" value="{{$attrValue->value_id}}" @if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)) checked @endif>
                            <label for="product-variants-{{$attribute->name}}-{{$attrValue->value_id}}" class="{{$lab_class}} " @if ($avt == "color") style="background-color:{{$attrValue->advance_value}}" @endif>
                                @if ($avt == 'image')
                                <img src="{{$attrValue->advance_value}}" alt="{{$attrValue->text}}" title="{{$attrValue->text}}" class="{{$img_class}}">
                                @endif
                                <span>{{$attrValue->text}}</span>
                            </label>
                            <span class="attr-text {{$txt_class}} "><span>{{$attrValue->text}}</span></span>
                        </li>
                    @endforeach


                </ul>
            @else
                <select class="{{$sel_class}}  {{$attribute->select_class}}" name="attrs[{{$attribute->name}}]">
                    @if ($attribute->values)
                        @foreach ($attribute->values as $option)
                            <option value="{{$option->value_id}}" {{$option->is_default?'selected':''}}>{{$option->text}}</option>
                        @endforeach
                    @endif
                </select>
            @endif

        </figure>
        @endforeach
    </div>
@endif



@if ($order_options = $product->getOrderAttributes())
    <div class="{{$sec_class}}  {{parse_classname('product-attributes')}}">

        @php
        $def = null;
        foreach ($order_options as $attr) {
            if($attr->is_defauly) $def = $attr->value_id;
        }
    @endphp
        @foreach ($order_options as $attribute)
            <?php
                $avt = $attribute->advance_value_type;
            ?>
        <figure class="{{$att_class}} {{parse_classname('product-attribute-item','product-attribute-'.$avt)}}">
            <figcaption class="{{$atn_class}} ">{{$attribute->label}}</figcaption>
            @if ($avt != 'default')
                <ul class="{{$avl_class}} {{parse_classname('product-attribute-values', 'product-attribute-'.$avt.'-values')}} {{$attribute->list_class}}">

                    @foreach ($attribute->values as $attrValue)
                        <li class="{{$avi_class}} {{parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')}}">
                            <input type="radio" id="product-attribute-{{$attribute->name}}-{{$attrValue->value_id}}" name="attrs[{{$attribute->name}}]" class="{{$rad_class}} {{parse_classname('radio-value-input')}} {{$attrValue->item_class}}" data-value-id="{{$attrValue->value_id}}" value="{{$attrValue->value_id}}" @if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)) checked @endif>
                            <label for="product-attribute-{{$attribute->name}}-{{$attrValue->value_id}}" class="{{$lab_class}} " @if ($avt == "color") style="background-color:{{$attrValue->advance_value}}" @endif>
                                @if ($avt == 'image')
                                <img src="{{$attrValue->advance_value}}" alt="{{$attrValue->text}}" title="{{$attrValue->text}}" class="{{$img_class}}">
                                @endif
                                <span>{{$attrValue->text}}</span>
                            </label>
                            <span class="attr-text {{$txt_class}} "><span>{{$attrValue->text}}</span></span>
                        </li>
                    @endforeach


                </ul>
            @else
                <select class="{{$sle_class}}  {{$attribute->select_class}}" name="attrs[{{$attribute->name}}]">
                    @if ($attribute->values)
                        @foreach ($attribute->values as $option)
                            <option value="{{$option->value_id}}" {{$option->is_default?'selected':''}}>{{$option->text}}</option>
                        @endforeach
                    @endif
                </select>
            @endif

        </figure>
        @endforeach
    </div>
@endif
