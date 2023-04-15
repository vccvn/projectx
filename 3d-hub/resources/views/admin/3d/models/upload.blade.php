<?php
add_css_link('static/manager/css/model-uploader.min.css');
add_js_src('static/manager/js/r3d.bundle.js');
add_js_src('static/manager/js/model-uploader.js');
?>
@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Upload Model')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Model')


@section('content')




    <div class="form-upload-block">
        <div class="row">
            <div class="col-12 col-md-8 ml-auto mr-auto">


                <h3 class="form-title">
                    Tải lên Model 3D của bạn
                </h3>
                <form id="model-upload-form" class="drop-files" action="{{ route($route_name_prefix . '3d.models.upload') }}" field="file" enctype="multipart/form-data">
                    @csrf
                    <div class="drag-and-drop text-center">
                        <label>Click hoặc kéo thả file vào đây để tải lên
                            <br>
                            <span>Tương thích: .<strong>zip</strong>, .<strong>gltf</strong>, .<strong>glb</strong>, .<strong>obj</strong>, .<strong>stl</strong></span>
                        </label>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <div id="model-upload-progress-bar" class="mb-progress-bar d-none">
        <div class="row">
            <div class="col-12">
                <div class="progress m-progress--lg">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="upload-progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-3">
                    <span class="filename-text mr-4"></span>
                    <span class="loading-text"></span>

                </div>

                <div class="message mt-3">

                </div>
            </div>
        </div>

    </div>

    <div id="info-form" class="d-none">
        <form method="POST" action="{{ route($route_name_prefix . '3d.models.save') }}" id="model-info-form">
            @csrf
            <input type="hidden" name="id" id="hidden-input-id">
            <input type="hidden" name="status" id="hidden-input-status" value="draft">

            <div class="row">
                <div class="col-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet  m-portlet--head-sm" m-portlet="true" id="model-info-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="la la-cube"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        <span id="model-name-title">Upload model</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">

                                    <li class="m-portlet__nav-item">
                                        <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon btn-close-form">
                                            <i class="la la-close"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            {{-- <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px"> --}}
                            <div>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">

                                        <div class="model-3d-preview" id="">
                                            <div class="frame-preview">
                                                <div class="canvas-wrapper" id="canvas-wrapper">

                                                </div>
                                                <div class="img-preview">
                                                    <div class="img-frame">
                                                        <img src="" alt="" id="image-preview-target">
                                                    </div>
                                                </div>

                                            </div>
                                            <a href="#" class="btn btn-info btn-block btn-edit-3d">Chỉnh sửa 3D</a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-8 col-xl-8">

                                        <div class="form-group m-form__group">
                                            <label for="model-name">Tên / Tiêu đề</label>
                                            <input type="text" name="name" class="form-control m-input" id="model-name" aria-describedby="nameHelp" placeholder="Enter Model name">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label for="model-category">Danh mục</label>
                                            @include('admin.forms.templates.crazyselect', [
                                            'input'=> html_input([
                                            'type' => 'crazyselect',
                                            'name' => 'category_id',
                                            'id' => 'category_id',
                                            'data' => get_3d_category_options()
                                            ])
                                            ])
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label for="model-description">Mô tả</label>
                                            <textarea class="form-control m-input" id="model-description" name="description" rows="3" placeholder="Viết gì đó..."></textarea>
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label for="model-download_urk">Download Url</label>
                                            <input type="text" name="download_urk" class="form-control m-input" id="model-download_urk" aria-describedby="nameHelp" placeholder="Enter download_urk">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot">
                            <button type="button" class="btn btn-info btn-save-public">Lưu &amp; Công khai</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <span class="m--margin-left-10">hoặc
                                <a href="#" class="m-link m--font-bold">Hủy</a>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi preview d-none" id="editor-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-statistics"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Dark Skin
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon btn-close-preview">
                            <i class="la la-close"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body" id="editor-portlet-body">
            <div class="btns-block">
                <button type="button" class="btn btn-sm btn-danger btn-close-editor"><i class="fa  fa-check"></i> Xong</button>
            </div>
            <div class="frame">
                
            </div>
        </div>
    </div>
@endsection
@section('jsinit')
    <script>
    </script>
@endsection
@section('js')
    <script>
        $(function() {
            var uploader = new ModelUploader("#model-upload-form", "model-info-portlet");
        })
    </script>


@endsection
