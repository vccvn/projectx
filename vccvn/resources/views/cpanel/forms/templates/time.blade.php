
<?php
$input->type='text';
$input->addClass('inp-time');
add_js_data('timepicker_selectors', '#'.$input->id);
$input->autocomplete = "off";
$input_group_class = ($input->prependGroup || $input->prepend_text || $input->append_text || $input->appendGroup || ($dig && $dig!='false'))?'':'input-group';
?>

    <div class="{{$input_group_class}}">
        {!! $input !!}
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-clock-o"></i>
            </span>
        </div>
    </div>
    

