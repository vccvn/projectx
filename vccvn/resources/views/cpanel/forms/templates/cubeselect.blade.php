<?php
add_css_link('static/manager/css/cube-select.min.css');

add_js_src('static/manager/js/cube-select.js');
$input->data('id', $input->id);
$input->type = "cubeselect";
?>
    {!! $input !!}
