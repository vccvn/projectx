@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'File Manager')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'File Manager')

@section('css')
    <link rel="stylesheet" href="{{asset('static/manager/assets/fi-icons/css-file-icons.css')}}">
    <link rel="stylesheet" href="{{asset('static/manager/css/dropzone.gallery.css')}}">
    <style>
        thead tr th{
            font-weight: 600;
        }
    </style>
@endsection
@section('content')

@php
    $pt = rtrim($path , '/');

@endphp

    <div class="row">
        <div class="col-12">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Đường dẫn: {{$pt.'/'}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="{{route('filemanager') . '?p=' . $relativePath}}" data-toggle="m-tooltip" data-placement="top" title data-original-title="Quay về" class="ml-2 btn btn-outline-warning m-btn btn-sm"><i class="fa fa-arrow-left"></i> <span class="d-none d-md-inline-block">Quay về</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">


                    <!--begin::Section-->
                    <div class="m-section">
                        <div class="m-section__content">
                            <form class="m-dropzone m-dropzone--primary dropzone-gallery" action="{{route($route_name_prefix.'filemanager.upload.save')}}" id="upload-files">
                                @csrf
                                <input type="hidden" name="path" value="{{$pt}}">
                                <div class="m-dropzone__msg dz-message needsclick">
                                    <h3 class="m-dropzone__msg-title">Kéo và thả file vào đây hoặc click để chọn file tải lên</h3>
                                    <span class="m-dropzone__msg-desc">Tối đa 50 file</span>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="{{route('filemanager') . '?p=' . $relativePath}}" data-toggle="m-tooltip" data-placement="top" title data-original-title="Quay về" class="btn btn-primary m-btn btn-sm"><i class="fa fa-arrow-left"></i> Quay về</a>
                            </div>
                            
                        </div>
                    </div>
                            
                </div>
            </div>

            <!--end::Portlet-->
        </div>
    </div>

@endsection

@section('js')
    <script>

    

        
        var m1uploadManager={
            init:function(){
                var uploadManager = new Dropzone("#upload-files", {
                    paramName:"file",
                    maxFiles:10,
                    maxFilesize:1024,
                    addRemoveLinks:!0,
                    renameFile:true,
                    // acceptedFiles:"*.*,*/*",
                    accept:function(e,o){"justinbieber.jpg"==e.name?o("Naha, you don't."):o()}
                });
                uploadManager.on("complete", function(file) { 
                    if(file.xhr){
                        if(file.xhr.response){
                            var response = JSON.parse(file.xhr.response);
                            if(response.status){
                                setTimeout(function(){
                                    // GalleryModal.prepand(response.data);
                                    // uploadManager.removeFile(file);
                                }, 1000);
                            }
                            
                        }
                    }
                });
            }
        };

        m1uploadManager.init();

    </script>
@endsection
