<?php
$input->type = "crazyselect";
$input->prepareCrazyInput();
$slt = '';

$def = [];
$opts = $input->getInputData();
if(is_array($opts) || is_object($opts)){
    
    $df = $input->defVal();
    $slt = $input->toClientSelectOptions($opts, $df);
    $def = $input->getDefaultOption($opts, $df);
    
}
$select_type = $input->data('select-type');
if(!$select_type){
    $select_type = 'static';
    $input->data('select-type', 'static');
}


$input->data('id', $input->id);
$classNAme = $input->className;

$input->className = "crazy-select $select_type " .($input->hasClass('d-block')?'d-block':'');

?>

    <input type="hidden" name="{{$input->name}}" value="{{($def?$def[0]:'')}}" id="{{$input->id}}" />

    <?php 
    $id = $input->id;
    $input->tagName = 'div'; 
    $input->id .= '-wrapper';
    
    ?>
    
    <div {!! $input->attrsToStr() !!} >
        <button type="button" class="btn-dropdown-select show-text-value {{$classNAme}}" id="{{$id}}-dropdown" value="{{($def?$def[0]:'')}}">
            {!!($def?$def[1]:"Chưa chọn giá trị")!!}
        </button>
        <div class="select-option-menu" data-ref="{{$id}}">
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

