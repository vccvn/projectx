<?php
$input->prepareCrazyInput();
set_admin_template_data('modals', 'modal-library');

$type = in_array($t = $input->hiddenData('filetype'), ['image', 'video', 'audio', 'all'])?$t:'image';
if($input->value === '<!---DEFAULT--->') $input->value = null;
$file = ($input->value && $f = get_media_file(['id' => $input->value])) ? $f : crazy_arr([
    'filename' => 'Không có file nào được chọn',
    'size' => 0,
    'size_unit' => 'KB',
    'thumbnail' => asset('static/images/default.png'),
    'type' => 'unknow'
]);

?>

<div class="input-media" data-type="{{$type}}">
    
    <div class="input-group">
        <input type="hidden" name="{{$input->name}}" id="{{$input->id?$input->id:$input->name}}" value="{{$input->value}}" class="media-input-hidden">
        <div class="input-group-prepend">
            <img src="{{$file->thumbnail}}" alt="{{$file->filename}}" class="media-image-thumbnail">
        </div>
        <input type="text" name="{{$input->name}}{{count(explode(']', $input->name)) > 1 ? '[text]': '_text'}}" value="{{$file->filename}}" class="media-input-text form-control m-input" readonly disabled>
        <div class="input-group-append">
            <span class="input-group-text file-size">{{$input->value?$file->size.$file->size_unit:''}}</span>
        </div>
    

    </div>

    
</div>