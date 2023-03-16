<?php
add_js_src('static/crazy/js/select.js');
$input->type = "crazyselect";
$input->prepareCrazyInput();
$slt = '';

$def = [];
$opts = $input->getInputData();
if(is_array($opts) || is_object($opts)){
    
    $df = $input->defVal();
    $slt = $input->toCrazySelectOptions($opts, $df);
    $def = $input->getDefaultOption($opts, $df);
    
}
$select_type = $input->data('select-type');
if(!$select_type){
    $select_type = 'static';
    $input->data('select-type', 'static');
}


$input->data('id', $input->id);
?>

    <input type="hidden" name="{{$input->name}}" value="{{($def?$def[0]:'')}}" id="{{$input->id}}" />

    <?php 
    $id = $input->id;
    $input->tagName = 'div'; 
    $input->id .= '-wrapper';
    $input->addClass("dropdown crazy-select $select_type");
    ?>
    <div {!! $input->attrsToStr() !!} >
        <button type="button" class="btn btn-secondary dropdown-toggle show-text-value" id="{{$id}}-dropdown" value="{{($def?$def[0]:'')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{($def?$def[1]:"Chưa chọn giá trị")}}
        </button>
        <div class="dropdown-menu" data-ref="{{$id}}" aria-labelledby="{{$id}}-dropdown">
            <div class="search-block p-2">
                <input type="search" data-name="search_options" class="form-control m-input" placeholder="{{$input->placeholder?$input->placeholder:'Tìm kiếm...'}}" />
            </div>
            <div class="message p-2 text-center" style="display:none;">Không có kết quả phù hợp</div>
            <div class="option-list">
    
                {!! $slt !!}
            </div>
            <div class="buttons" style="display:none;">
                <a href="javascript:void(0);" class="btn btn-block m-btn--square btn-outline-info m-btn m-btn--custom crazy-select-asvance-button">{{$input->data('advance-text')}}</a>
            </div>
        </div>
    </div>