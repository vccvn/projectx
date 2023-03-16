<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;
add_js_src('static/manager/js/input.video.js');
?>

    <div class="video-url-input" id="input-video-{{$input->id}}" data-id="{{$input->id}}">
        
        <div class="url-input">
            {!! $input !!}
        </div>
        <div class="video-preview">

        </div>

        
    </div>
    

