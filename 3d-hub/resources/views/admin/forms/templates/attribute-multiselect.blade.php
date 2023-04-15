<?php
$input->removeClass();
// $input->addClass('form-control m-select2 multi-select');
$input->addClass("form-control m-input attribute-".$input->data('attribute-id'). "-wrapper");
$input->attr("multiple","multiple");
$input->name.='[]';
?>
<div class="multiselect-wrapper">
    {!! $input !!}


    <div class="add-attribute-block mt-1">
        <a href="javascript:void(0);" class="btn-add-attribute-value ref-multiselect" 
            data-id="{{$input->data('attribute-id')}}" 
            data-value-type="{{$input->data('attribute-value-type')}}" 
            data-label="{{$input->data('attribute-label')}}">
            Thêm mới
        </a>
    </div>
</div>