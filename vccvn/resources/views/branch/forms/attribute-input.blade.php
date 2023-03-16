<?php 
$attrInput = html_input($params);
$attrInput->id = $root_name.'-'.$attrInput->name;
$attrInput->name = $root_name.'['.$attrInput->name.']';
$ns = $attrInput->nameToNamespace();
if($errors->has($ns)){
    $attrInput->error = $errors->first($ns);
}
$attrInput->value = old($ns, $attrInput->value);

$attrInput->addClass('form-control m-input attribute-input attribute-input-'.$attrInput->type);

$col_class = 'col-12 col-sm-8 col-md-9 col-lg-10';
if($attrInput->type=='number'){
    $col_class = 'col-12 col-sm-4 ';
}
?>

<div class="mt-1 mb-4 crazy-form-group row scope-{{$attrInput->hiddenData('scope')}} {{$attrInput->error?'has-danger':''}}" id="{{$attrInput->id}}-form-group">
    <label class="col-12 coll-sm-4 col-md-3 col-lg-2 col-form-label" for="{{$attrInput->id}}" >
        {{$attrInput->label}}
        
        
    </label>
    <div class="{{$col_class}}">

        <?php
            $is_template = is_support_template($attrInput->template, $attrInput->type);

            $dig = $attrInput->data('input-group');
            $input_group_class = ($attrInput->prepend_text || $attrInput->append_text || ($dig && $dig!='false') || $attrInput->type == 'select')?'input-group':'';

        
        ?>
        

        <div class="{{$input_group_class}}" id="attr-input-{!! $attrInput->id !!}-group">
            {{-- prepend addon group --}}
            @if ($attrInput->prepend_text)
                <div class="input-group-prepend">
                    <span class="input-group-text">{!!$attrInput->prepend_text!!}</span>
                </div>
            @endif
            {{-- nếu có tempplate và (kieu attrInput phai bang hoac nam trong danh sach cua tem plate do) --}}
            @if($is_template)
                @include($_current.'templates.attribute-'.$attrInput->template, ['input' => $attrInput])
            
            @elseif ($attrInput->type == 'file')
                <div class="custom-file">
                    <?php $attrInput->addClass('custom-file-attrInput'); ?>
                    {!! $attrInput !!}
                    <label class="custom-file-label selected" for="{{$attrInput->id}}">{{$attrInput->val()?$attrInput->val():'Chưa có file nào dc chọn'}}</label>
                </div>
            
            @elseif(in_array($attrInput->type, ['checkbox', 'radio', 'checklist']))
                <div class="checkbox-radio {{$attrInput->data('display') == 'list'?'display-list':"display-inline"}}">
                    {!! $attrInput !!}
                </div>
            @else
            
                {!! $attrInput !!}    
            @endif

            @if ($attrInput->append_text)
                <div class="input-group-append">
                    <span class="input-group-text">{!!$attrInput->append_text!!}</span>
                </div>
            @endif
            @if ($attrInput->type == 'select')
                <div class="input-group-append">
                    <a href="javascript:void(0);" class="btn-add-attribute-value btn btn-success ref-select" 
                        data-id="{{$attrInput->data('attribute-id')}}" 
                        data-value-type="{{$attrInput->data('attribute-value-type')}}" 
                        data-label="{{$attrInput->data('attribute-label')}}">
                        Thêm
                    </a>
                </div>
            @endif
            
        </div>
        <div class="form-control-feedback input-message-alert" id="input-{!! $attrInput->id !!}-message-alert">{{$attrInput->error}}</div>    
        
        
    </div>
    {{-- end input group --}}
</div>