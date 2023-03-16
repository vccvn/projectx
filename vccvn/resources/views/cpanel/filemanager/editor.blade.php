@php

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
add_js_src('static/plugins/codemirror/mode/clike/clike.js');
add_js_src('static/plugins/codemirror/mode/php/php.js');
add_js_src('static/plugins/codemirror/mode/htmlmixed/htmlmixed.js');

add_js_src('static/plugins/codemirror/addon/edit/matchtags.js');
add_js_src('static/plugins/codemirror/addon/selection/active-line.js');
add_js_src('static/plugins/codemirror/addon/edit/matchbrackets.js');

$modes = [
    'css' => 'text/css',
    'scss' => 'text/x-scss',
    'less' => 'text/x-less',
    'php' => 'application/x-httpd-php',
    'js' => 'text/javascript',
    'jsx' => 'text/javascript',
    'ts' => 'text/javascript',
    'xml' => 'application/xml',
];

$mode = isset($modes[$ext]) ? $modes[$ext] : 'text/html';

@endphp
@extends($_layout.'base')

{{-- khai báo title --}}
@section('title', 'Dashboard')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Dashboard')

@section('css')
    <style>
        #file-content {
            width: 100%;
            border: 1px solid #ebedf2;
            border-radius: 4px;
        }

    </style>
@endsection
@section('content')




    <!--begin::Portlet-->
    <div class="m-portlet">
        <form method="post" action="{{ route('filemanager.files.save') }}" class="m-form m-form--fit m-form--label-align-right crazy-form">
            @csrf

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Edit: {{ $filename }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">

                        <li class="m-portlet__nav-item">
                            <button type="submit" class="btn btn-info btn-sm">Lưu</button>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="{{ route('filemanager') . '?p=' . $path }}" data-toggle="m-tooltip" data-placement="top" title data-original-title="Quay về" class="ml-2 btn-make-dir btn btn-outline-warning m-btn btn-sm"><i class="fa fa-arrow-left"></i> <span class="d-none d-md-inline-block">Quay về</span></a>
                        </li>
                    </ul>
                </div>
            </div>


            <input type="hidden" name="path" value="{{ $path }}">
            <div class="m-portlet__body">
                <div class="form-group m-form__group">
                    <label for="exampleInputEmail1">Nội dung</label>
                    <div class="input-group m-input-group m-input-group--air">
                        <div id="file-content" class="input-group.m-input-group--air">

                        </div>
                        <textarea name="content" id="file-content-text" style="display: none">{{ $content }}</textarea>
                    </div>
                </div>
                <div class="form-group m-form__group">
                    <label for="filename">Tên tệp</label>
                    <div class="input-group m-input-group m-input-group--air">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="la la-h-square"></i>
                            </span>
                        </div>
                        <input type="text" name="filename" class="form-control m-input" placeholder="Tên tập tin" aria-describedby="basic-addon1" value="{{ $filename }}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                                {{ strtoupper($ext) }}
                            </span>
                        </div>

                    </div>
                </div>

                @if ($errors->first())

                    <div class="form-group m-form__group">
                        <label for="filename" class="text-danger">{{ $errors->first() }}</label>

                    </div>
                @endif
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions" class="text-center">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a class="btn btn-secondary" href="{{ route('filemanager') . '?p=' . $path }}">Huỷ</a>
                </div>
            </div>
        </form>

    </div>

    <!--end::Portlet-->

@endsection
@section('js')
    <script>
        var temp = document.getElementById("file-content-text");
        var content = temp.value;
        var cmo = {
            value: content,
            mode: "{{ $mode }}",
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            },
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,

            matchTags: {
                bothTags: true
            },
            extraKeys: {
                "Ctrl-J": "toMatchingTag"
            },
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Q": function(cm) {
                    cm.foldCode(cm.getCursor());
                }
            },
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
        }

        cmo.value = content;
        var h = 600;
        var myCodeMirror = CodeMirror(document.getElementById('file-content'), cmo);
        myCodeMirror.setSize(null, parseInt(h));


        myCodeMirror.on("change", function() {
            var cnt = myCodeMirror.getValue();
            temp.value = cnt;

        });
    </script>
@endsection
