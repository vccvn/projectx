<?php
$input->addClass('cropit-image-input');
$input->attr('accept', 'image/jpeg,image/png,image/gif');
$w = $input->data('width');
$h = $input->data('height');
$width = $w?$w:300;
$height = $h?$h:300;
add_custom_css(
    "#$input->id-editor-wrapper .cropit-editor", 
    [
        'width' => $width.'px',
        'height' => ($height+40).'px',
        'position' => 'relative'
    ]
);
add_custom_css(
    "#$input->id-editor-wrapper .cropit-preview", 
    [
        'width' => $width.'px',
        'height' => $height.'px',
    ]
);
add_custom_css("#$input->id-editor-wrapper .addons, #$input->id-editor-wrapper .keep-original", [
    'width' => $width.'px',
    'margin' => '10px auto'
]);

add_css_link('plugins/cropit/cropit.css');
add_js_src('plugins/cropit/cropit.js');

add_js_data('cropit_data', [
    [
        'selector' => "#$input->id-editor-wrapper",
        'image' => $input->val()?$input->val():asset('images/default/no-image.png')
    ]
]);
?>

<div id="{{$input->id}}-editor-wrapper" class="m-auto">
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
    @if ($input->hiddenData('keep-original'))
    <?php
        $kon = $input->name . '_keep_original';
    ?>
    <div class="form-group keep-original">
        <label for="{{$kon}}" class="m-checkbox m-checkbox--solid m-checkbox--success">
            <input type="checkbox" name="{{$kon}}" id="{{$kon}}" {{old($kon, (isset($form_data) && isset($form_data[$kon])? $form_data[$kon] : null ))?"checked":''}}> <span></span> Giữ nguyên kích thước
        </label>
    </div>
    @endif
    
    <div class="form-group addon">
        @if ($input->hiddenGroup && is_array($input->hiddenGroup))
            @foreach ($input->hiddenGroup as $item)
                {!! $item !!}
            @endforeach
        @endif
    </div>


</div>