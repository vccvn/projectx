<?php
if(!get_web_data('set_icon_picker_model')){
    set_admin_template_data('modals', 'icon-picker-modal');
    add_js_src('static/manager/js/iconpicker.js');
    set_web_data('set_icon_picker_model', true);
}

$input->type = 'text';
$input->addClass('icon-picker form-control iconpicker');
$val = $input->val();

?>

<div class="input-group input-icon-picker-group">
    {!! $input !!}
    <div class="input-group-prepend">
        <button type="button" class="btn btn-info btn-show-icon-picker"><i class="fa fa-crow"></i></button>
    </div>
</div>