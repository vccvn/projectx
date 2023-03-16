<?php
add_css_link('static/manager/css/deep-select.min.css');
add_js_src('static/manager/js/deep-select.js');
$input->type = "deepselect";
$slt = '';

$def = [];
$opts = $input->getInputData();
if(is_array($opts) || is_object($opts)){
    
    $df = $input->defVal();
    $slt = $input->toDeepSelectOptions($opts, $df);
    $def = $input->getDefaultOption($opts, $df);
    
}
$select_type = $input->data('select-type');
if(!$select_type){
    $select_type = 'static';
}
$input->data('id', $input->id);
?>

    <input type="hidden" name="{{$input->name}}" value="{{($def?$def[0]:'')}}" id="{{$input->id}}" class="{{$input->className}} d-none" />
    <div class="dropdown deep-select-group {{$select_type}}" @if($input->data('changed-callback')) data-changed-callback="{{$input->data('changed-callback')}}" @endif >
        <button type="button" class="btn btn-secondary dropdown-toggle show-text-value" id="{{$input->id}}-dropdown" value="{{($def?$def[0]:'')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{($def?$def[1]:"Chưa chọn giá trị")}}
        </button>
        <div class="dropdown-menu" data-ref="{{$input->id}}" aria-labelledby="{{$input->id}}-dropdown">
            <div class="search-block p-2">
                <input type="search" name="search_options" class="form-control m-input" placeholder="Tìm kiếm..." />
            </div>
            <div class="message p-2 text-center" style="display:none;">Không có kết quả phù hợp</div>
            <div class="option-list">
    
                {!! $slt !!}
            </div>
        </div>
    </div>