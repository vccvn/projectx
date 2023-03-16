<?php
add_js_src('static/plugins/ckeditor/ckeditor.js');
add_js_src('static/manager/js/ckeditor.js');
$input->addClass("crazy-ckeditor");
$input->type="textarea";

?>

{!! $input !!}