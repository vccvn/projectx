<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;



add_js_src('static/plugins/tinymce/tinymce.min.js');
add_js_src('static/plugins/tinymce/jquery.tinymce.min.js');
add_js_src('static/plugins/tinymce/gallery.js');



add_css_link('static/plugins/codemirror/lib/codemirror.css');
add_css_link('static/plugins/codemirror/addon/hint/show-hint.css');
add_css_link('static/plugins/codemirror/addon/fold/foldgutter.css');

add_js_src('static/plugins/codemirror/lib/codemirror.js');

add_js_src('static/plugins/codemirror/addon/hint/show-hint.js');
add_js_src('static/plugins/codemirror/addon/hint/xml-hint.js');
add_js_src('static/plugins/codemirror/addon/hint/html-hint.js');


add_js_src('static/plugins/codemirror/addon/fold/foldcode.js');
add_js_src('static/plugins/codemirror/addon/fold/foldgutter.js');
add_js_src('static/plugins/codemirror/addon/fold/brace-fold.js');
add_js_src('static/plugins/codemirror/addon/fold/xml-fold.js');
add_js_src('static/plugins/codemirror/addon/fold/indent-fold.js');
add_js_src('static/plugins/codemirror/addon/fold/markdown-fold.js');
add_js_src('static/plugins/codemirror/addon/fold/comment-fold.js');

add_js_src('static/plugins/codemirror/mode/markdown/markdown.js');


add_js_src('static/plugins/codemirror/addon/selection/selection-pointer.js');
add_js_src('static/plugins/codemirror/mode/xml/xml.js');
add_js_src('static/plugins/codemirror/mode/javascript/javascript.js');
add_js_src('static/plugins/codemirror/mode/css/css.js');
add_js_src('static/plugins/codemirror/mode/vbscript/vbscript.js');
add_js_src('static/plugins/codemirror/mode/php/php.js');
add_js_src('static/plugins/codemirror/mode/htmlmixed/htmlmixed.js');


add_js_src('static/plugins/codemirror/addon/edit/matchtags.js');
add_js_src('static/plugins/codemirror/addon/selection/active-line.js');
add_js_src('static/plugins/codemirror/addon/edit/matchbrackets.js');



add_js_src('static/manager/js/tinymce.js');
set_admin_template_data('modals', 'modal-library');


$input->addClass("tiny-mce");
$input->type="textarea";

?>





<div id="{!! $input->id.'-tabs' !!}" class="tiny-mce-wrapper">
    <ul class="nav nav-tabs justify-content-end" role="tablist">
        <li class="nav-item m-tabs__item mr-auto">
            <a class="btn btn-sm btn-secondary btn-insert-gallery" href="javascript:void(0)">
                <i class="fa fa-images mr-3"></i>
                    Thư viện
            </a>
        </li>
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#editor_tab" role="tab">
                <i class="fa fa-file-word d-none d-md-inline"></i>
                Văn bản
            </a>
        </li>

        
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link" data-toggle="tab" href="#code_tab" role="tab">
                <i class="fa fa-code d-none d-md-inline"></i> 
                Code
            </a>
        </li>
            
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="editor_tab" role="tabpanel">
                
            {!! $input !!}
        </div>
        <div class="tab-pane" id="code_tab" role="tabpanel">
            {{-- @php
                $input->className = 'code-editor';
                $input->id.='-code';
                $input->name.='_code';
            @endphp
            {!! $input !!} --}}
        </div>
    </div>
</div>
