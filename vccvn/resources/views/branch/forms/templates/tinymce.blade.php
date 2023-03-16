<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('plugins/tinymce/tinymce.min.js');
add_js_src('plugins/tinymce/jquery.tinymce.min.js');
add_js_src('plugins/tinymce/gallery.js');
add_js_src('manager/js/tinymce.js');
add_js_src('manager/js/gallery.modal.js');
add_js_data('crazy_form_data', 'include_modal', true);
add_js_data('gallery_data', 'get_file_url', route($route_name_prefix.'files.images.get-data'));
add_js_data('gallery_data', 'delete_file_url', route($route_name_prefix.'files.delete'));

$input->addClass("tiny-mce");
$input->type="textarea";

?>

{!! $input !!}