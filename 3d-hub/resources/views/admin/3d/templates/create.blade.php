<?php
add_css_link('static/manager/css/3d-form.min.css');
add_js_src('static/manager/js/3d-form.js');
?>
@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Template 3D')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Template 3D')


@section('content')




        <form method="POST" action="{{ route($route_name_prefix . '3d.templates.save') }}" id="crazy-info-form">
            @csrf
            <input type="hidden" name="id" id="hidden-input-id">
            <input type="hidden" name="secret_id" id="hidden-input-secret-id">
            <input type="hidden" name="status" id="hidden-input-status" value="draft">

            <div class="row">
                <div class="col-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet  m-portlet--head-sm" m-portlet="true" id="crazy-info-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="la la-cube"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        <span id="template-name-title">Upload template</span>
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

                                        <div class="crazy-3d-preview" id="">
                                            <div class="frame-preview">
                                                <div class="canvas-wrapper" id="canvas-wrapper">

                                                </div>
                                                <div class="img-preview">
                                                    <div class="img-frame">
                                                        <img src="{{asset('static/images/default/no-image.png')}}" alt="" id="image-preview-target">
                                                    </div>
                                                </div>


                                            </div>
                                            <a href="#" class="btn btn-info btn-block btn-edit-3d">Chỉnh sửa 3D</a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-8 col-xl-8">

                                        <div class="form-group m-form__group">
                                            <label for="crazy-name">Tên / Tiêu đề</label>
                                            <input type="text" name="name" class="form-control m-input" id="crazy-name" aria-describedby="nameHelp" placeholder="Enter template-name">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label for="category_id">Danh mục</label>
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
                                            <label for="crazy-description">Mô tả</label>
                                            <textarea class="form-control m-input" id="crazy-description" name="description" rows="3" placeholder="Viết gì đó..."></textarea>
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






        @include($_template.'3d-editor-portlet')


@endsection
