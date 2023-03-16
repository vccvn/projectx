@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = 'Sắp xếp item')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)

<?php
        admin_action_menu([
            [
                'url' => admin_slider_item_url('list'),
                'text' => 'Danh sách',
                'icon' => 'fa fa-th-list'
            ]
        ]);

?>

@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Sắp xếp thứ tự ưu tiên
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{admin_slider_item_url('list')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Danh sách" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-profile-slider"><i class="fa fa-images"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="slider-list">
                    
                    <div class="dd nestable slider-item-list-body" id="crazy-slider-item-list" data-max-depth="1" data-callback="App.slider.items.sortCallback">
                        <ol class="dd-list">
                            @if (count($list))
                                @foreach ($list as $item)
                                <li class="dd-item" data-id="{{$item->id}}">
                                    <div class="item-actions">
                                        <a href="{{admin_slider_item_url('update', ['id' => $item->id])}}" class="edit btn-edit-item" data-id="{{$item->id}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{{$item->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                        <span class="item-name">{{$item->title}}</span>
                                    </div>
                                </li>    
                                @endforeach
                            @endif                        
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

    <!--end::Form-->
</div>



@endsection

{{-- Nhúng link css --}}
@section('css')
    <link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
    
@endsection

{{-- Nhúng js --}}

@section('jsinit')
    <script>
        var slider_item_data = {
            urls: {
                sort: "{{admin_slider_item_url('sort.save')}}",
                delete: "{{admin_slider_item_url('delete')}}"
            }
        };
    </script>
@endsection

@section('js')
<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/slider.items.js')}}"></script>

@endsection
