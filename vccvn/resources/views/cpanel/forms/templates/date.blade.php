
<?php
$input->type='text';
$input->addClass('inp-date');
add_js_data('datepicker_selectors', '#'.$input->id);
$input->autocomplete = "off";
$input_group_class = ($input->prependGroup || $input->prepend_text || $input->append_text || $input->appendGroup || ($dig && $dig!='false'))?'':'input-group';
?>

    <div class="{{$input_group_class}}">
        {!! $input !!}
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-calendar"></i>
            </span>
        </div>
    </div>
    

