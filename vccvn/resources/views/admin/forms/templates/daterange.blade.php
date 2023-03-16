<?php
$input->type='text';
$input->addClass('inp-daterange');
$input->attr('readonly',true);

add_js_data('daterange_selectors', '#'.$input->id .'-form-group .input-group');
?>
    <div class="input-group">
    
        {!! $input !!}
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="la la-calendar-check-o"></i>
            </span>
        </div>
    

    </div>