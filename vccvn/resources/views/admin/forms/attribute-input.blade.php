<?php
$input = html_input($params);
$attr_id = $input->hidden('id');
$attr_name = $input->name;

$is_variant = $input->hidden('is-variant');

$rname = $is_variant?'variants':$root_name;

$price_type = $input->hidden('price-type');
$input->id = $rname.'-'.$input->name.'-'.$attr_id;

$input->name = $rname.'['.$attr_name.']';
$ns = $input->nameToNamespace();

if($input->hidden('value-type') == 'decimal'){
    $input->step = 0.1;
}
if($errors->has($ns)){
    $input->error = $errors->first($ns);
}
$input->value = old($ns, $input->value);

$input->addClass('form-control m-input attribute-input attribute-input-'.$input->type);
$col_class = 'col-12 col-sm-8 col-md-9 col-lg-10';
$lbl_class = 'col-12 col-sm-4 col-md-3 col-lg-2';
$advance_value_type = $input->hidden('advance-value-type');
if($is_variant){
    $col_class = 'col-12';
    $lbl_class = 'col-12';
}
elseif ($advance_value_type=='color') {
    $col_class = 'col-12 col-md-9 col-lg-10';
    $lbl_class = 'col-12 col-md-3 col-lg-2';
}
if($input->type=='number'){
    $col_class = 'col-12 col-sm-4 ';
}


?>

<div class="mt-1 mb-4 crazy-form-group row scope-{{$input->hiddenData('scope')}} {{$input->error?'has-danger':''}}" id="{{$input->id}}-form-group">
    <label class="{{$lbl_class}} col-form-label" for="{{$input->id}}" >
        {{$input->label}}
        @if ($input->required && !in_array($input->required, ["0", "false"]))
            <span class="m-badge m-badge--danger m-badge--dot"></span>
        @endif

    </label>
    <div class="{{$col_class}}">

        <?php
            $is_template = is_support_template($input->template, $input->type);

            $dig = $input->data('input-group');
            $input_group_class = ($input->prepend_text || $input->append_text || ($dig && $dig!='false') || $input->type == 'select')?'input-group':'';


        ?>


        <div class="{{$input_group_class}}" id="attr-input-{!! $input->id !!}-group">
            {{-- nru61 thuộc tính là variant --}}
            @if ($is_variant)
                <div id="product-variant-input-{{$input->hidden('id')}}" class="product-variant-input">
                    <?php

                    $def = [];
                    $options = $input->getInputData();
                    if(is_array($options) || is_object($options)){
                        if(is_array($df = $input->defVal())){
                            $def = $df;
                        }
                    }
                    $defaultValues = old($input->name, $def);

                    $name = $input->name.'[]';
                    $values = $input->hidden('values');

                    $oldDefault = old('attribute_default_selected.'.$attr_id);
                    $_i = 0;
                    ?>
                    @foreach ($options as $value => $valuedata)
                    <?php
                    if(!$_i && !$oldDefault){
                        $oldDefault = $value;
                    }
                    $_i ++;
                    $checked = in_array($value, $defaultValues) ? 'checked' : null;
                    $vdata = crazy_arr(isset($values[$value])?$values[$value]:[]);
                    if($vdata->is_default){
                        $oldDefault = $value;
                    }

                    ?>
                    <div id="product-variant-value-{{$value}}" class="variant-attribute-item">
                        <div class="variant-check-block">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--info">
                                <input
                                    type="checkbox"
                                    class="crazy-checkbox variant-input-checkbox"
                                    data-value="{{$value}}"
                                    data-attribute="{{$attr_id}}"
                                    name="{{$name}}"
                                    id="{{$input->id.'-'.str_slug($value)}}"
                                    value="{{$value}}"
                                    data-on-change="Product.form.onVariantChange"
                                    data-e="0"
                                    {{$checked}}>
                                {{$valuedata['text']}}
                                <span></span>
                            </label>
                            <label class="checkbox-label m-radio pull-right">
                                <input type="radio" class="" name="attribute_default_selected[{{$attr_id}}]" value="{{$value}}" {{$oldDefault == $value? 'checked': ''}}>
                                <span></span>
                            </label>
                        </div>
                        <div class="variant-option {{$checked?'show':''}}">
                            <?php
                                $priceError = $errors->first('variant_price.'.$value);
                            ?>
                            <div class="crazy-form-group row {{$priceError?'has-danger':''}}">
                                <label for="variant-price-{{$attr_id}}-{{$value}}" class="col-12 col-sm-4 col-md-3 col-form-label">
                                    Giá {{$price_type?"biến thể": "trị gia tăng"}}
                                </label>
                                <div class="col-12 col-sm-8 col-md-3">
                                    <input type="number" name="variant_price[{{$value}}]" id="variant-price-{{$attr_id}}-{{$value}}" class="form-control m-input" value="{{old('variant_price.'.$value, $vdata->price)}}" placeholder="Nhập giá tiền...">
                                    <div class="form-control-feedback input-message-alert" id="variant-price-{{$attr_id}}-{{$value}}-message-alert">{{$priceError}}</div>
                                </div>
                            </div>
                            @if ($advance_value_type == 'image')
                            <?php
                                $imgError = $errors->first('variant_images.'.$value);
                            ?>
                                <div class="crazy-form-group row mt-2 {{$imgError?'has-danger':''}}">
                                    <label for="variant-images-{{$attr_id}}-{{$value}}" class="col-12 col-sm-4 col-md-3 col-lg-2 col-form-label">
                                        Ảnh đính kèm
                                    </label>
                                    <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                                        @include($_base.'forms.templates.file', [
                                            'input' => html_input([
                                                'type' => 'file',
                                                'name' => 'variant_images['.$value.']',
                                                'choose_label' => $vdata->advance_value?$vdata->advance_value:($valuedata['advance_value']?$valuedata['advance_value']:'Chưa chọn file nào'),
                                                'accept' => 'image/*'
                                            ])
                                        ])
                                        <div class="form-control-feedback input-message-alert" id="variant-price-{{$attr_id}}-{{$value}}-message-alert">{{$imgError}}</div>
                                    </div>
                                </div>

                            @elseif ($advance_value_type == 'color')
                            <?php
                                $clrError = $errors->first('variant_colors.'.$value);
                            ?>
                                <div class="crazy-form-group row mt-2 {{$clrError?'has-danger':''}}">
                                    <label for="variant-color-{{$attr_id}}-{{$value}}" class="col-12 col-sm-4 col-md-3 col-lg-2 col-form-label">
                                        Mã màu
                                    </label>
                                    <div class="col-12 col-sm-8 col-md-3 col-lg-4">
                                        @include($_base.'forms.templates.colorpicker', [
                                            'input' => html_input([
                                                'type' => 'text',
                                                'name' => "variant_colors[{$value}]",
                                                'id' => "variant-colors-{$attr_id}-{$value}",
                                                'value' => old('variant_colors.'.$value, $vdata->advance_value?$vdata->advance_value:$valuedata['advance_value']),
                                                'placeholder'=>"Nhập mã màu"

                                            ])
                                        ])
                                        <div class="form-control-feedback input-message-alert" id="variant-price-{{$attr_id}}-{{$value}}-message-alert">{{$clrError}}</div>
                                    </div>
                                </div>

                            @else

                            @endif

                        </div>

                    </div>

                    @endforeach
                </div>

            {{-- nếu thuộc tính không phải variant --}}
            @else

                {{-- prepend addon group --}}
                @if ($input->prepend_text)
                    <div class="input-group-prepend">
                        <span class="input-group-text">{!!$input->prepend_text!!}</span>
                    </div>
                @endif
                {{-- nếu có tempplate và (kieu attrInput phai bang hoac nam trong danh sach cua tem plate do) --}}
                @if($is_template)
                    @include($_base.'forms.templates.attribute-'.$input->template, ['input' => $input])

                @elseif ($input->type == 'file')
                    <div class="custom-file">
                        <?php $input->addClass('custom-file-input'); ?>
                        {!! $input !!}
                        <label class="custom-file-label selected" for="{{$input->id}}">{{$input->val()?$input->val():'Chưa có file nào dc chọn'}}</label>
                    </div>

                @elseif(in_array($input->type, ['checkbox', 'radio', 'checklist']))
                    <div class="checkbox-radio {{$input->data('display') == 'list'?'display-list':"display-inline"}}">
                        {!! $input !!}
                    </div>
                @else

                    {!! $input !!}
                @endif

                @if ($input->append_text)
                    <div class="input-group-append">
                        <span class="input-group-text">{!!$input->append_text!!}</span>
                    </div>
                @endif
                @if ($input->type == 'select')
                    <div class="input-group-append">
                        <a href="javascript:void(0);" class="btn-add-attribute-value btn btn-success ref-select"
                            data-id="{{$input->data('attribute-id')}}"
                            data-value-type="{{$input->data('attribute-value-type')}}"
                            data-label="{{$input->data('attribute-label')}}">
                            Thêm
                        </a>
                    </div>
                @endif

            @endif


        </div>
        <div class="form-control-feedback input-message-alert" id="input-{!! $input->id !!}-message-alert">{{$input->error}}</div>


    </div>
    {{-- end input group --}}
</div>
