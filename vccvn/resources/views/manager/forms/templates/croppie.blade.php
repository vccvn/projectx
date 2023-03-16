<?php
$input->addClass('cropit-image-input');
$input->attr('accept', 'image/jpeg,image/png,image/gif');
$w = $input->data('width');
$h = $input->data('height');
$width = $w?$w:300;
$height = $h?$h:300;
$src = $input->val()?$input->val():asset('static/images/default/no-image.png');

add_css_link('static/plugins/cropit/cropit.css');

?>

<div id="{{$input->id}}-editor-wrapper">
    <h3 class="text-center">{{$input->comment?$input->comment:'Hình xem trước'}}</h3>
    <div class="select-file cropit-editor">
        <div class="cropit-preview"></div>
        
        
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-secondary rotate-ccw-btn" type="button">
                    <i class="fa fa-undo"></i>
                </button>
            </span>
            <span class="input-group-btn">
                <button class="btn btn-secondary rotate-cw-btn" type="button">
                    <i class="fa fa-redo"></i>
                </button>
            </span>
            <input type="range" class="cropit-image-zoom-input form-control" style="padding-left:0;padding-right:0; margin:0 5px " />
        </div>
        <input type="hidden" name="{{$input->name}}_data" class="hidden-image-data" />
        <div class="change-icon-wrapper">
            <div class="file-select">
                <div class="choose-icon">
                    <i class="fa fa-camera"></i> Chọn ảnh
                </div>
                {!! $input !!}
            </div>
        </div>
    </div>

    <div class="form-group keep-original">
        <label for="{{$input->id}}-keep-original" class="form-control-label ">
            <input type="checkbox" name="{{$input->name}}_keep_original" id="{{$input->id}}-keep-original" > Giữ nguyên kích thước
        </label>
    </div>


</div>