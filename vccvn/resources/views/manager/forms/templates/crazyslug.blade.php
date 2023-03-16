<?php
add_js_src('static/crazy/js/slug.js');
$input->type = "text";


$wrapper = $input->copy();

$wrapper->type = "crazyslug";
$wrapper->prepareCrazyInput();

$cf = $wrapper->data('check-field')??'custom_'.$input->name;
$custom = ($input->parent && $c = $input->parent->get($cf))?$c:(html_input([
    'type' => 'checkbox',
    'name' => $cf,
    'value' => $cf
]));

$wrapper->removeClass();
$wrapper->addClass("input-group crazy-slug");
$wrapper->id.='-wrapper';
$wrapper->name.='-wrapper';
?>

<div {!! $wrapper->attrsToStr() !!}>
    <div class="input-group-prepend">
        <span class="input-group-text check-addon">
            <label class="checkbox-label m-checkbox m-checkbox--solid m-checkbox--primary ">
                {!! $custom->raw() !!}
                <span class="check-spacing"></span> 
                <i class="checkbox-label-span">{{$custom->check_label??'Tùy chỉnh'}}</i>
            </label>
        </span>
    </div>

    {!! $input !!}

    <div class="input-group-append">
        <span class="input-group-text">{{$input->data('extension')??'.html'}}</span>
    </div>

</div>