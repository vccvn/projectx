
<?php
add_js_src('crazy/js/switch.js');
$input->type = "crazyswitch";
$input->removeClass('form-control')->removeClass('m-input');
$input->prepareCrazyInput();
$input->type = "checkbox";

$input->removeClass('m-checkbox')->setOption('is_free', 1);
?>
<span class="m-switch m-switch--outline m-switch--icon m-switch--{{$input->template_type?$input->template_type:'primary'}}">
    <label>
        {!! $input !!}
        <span></span>
        @if ($input->check_label)
            <i class="ml-2 pt-2 d-inline-block">{{$input->check_label}}</i>
        @endif
    </label>
</span>
