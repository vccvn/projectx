<?php
add_css_link('manager/css/cube-select.min.css');

add_js_src('manager/js/cube-select.js');
$input->data('id', $input->id);
$input->type = "cubeselect";
?>
    {!! $input !!}
