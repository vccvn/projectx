@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', isset($title)?$title:"Thông báo")

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', isset($module)?$module:"Thông báo")


@section('content')

<?php
    $type = (isset($type) && $type)?$type:(session('type')?session('type'):'success');
    $message = (isset($message) && $message)?$message:(session('message')?session('message'):'Hello World');
    $link = isset($link)?$link:route('admin.dashboard');
    $text = isset($text)?$text:'<i class="fa fa-home"></i> Dashboard';
    
?>
<div class="row">
    <div class="col-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Thông báo
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <div class="alert alert-{{$type}} text-center">{!! $message !!}</div>
                        <div class="buttons text-center" style="margin: 20px auto;">
                            <a href="{{$link}}" class="theme-btn btn-style-two">{!! $text !!}</a>
                        </div>
                    </div>
                </div>

                <!--end::Section-->
            </div>


            
        </div>

        <!--end::Portlet-->

    </div>
</div>

@endsection