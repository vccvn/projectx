@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = 'Sắp xếp Menu')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Sắp xếp thứ tự ưu tiên của Menu
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{route($route_name_prefix.'menus.list')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Danh sách" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-profile-menu"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="menu-list">
                    
                    <div class="dd nestable menu-list-body" id="crazy-menu-list" data-max-depth="1" data-callback="App.menu.form.sortCallback">
                        <ol class="dd-list">
                            @if (count($menus))
                                <?php
                                    $showLabels = ["", '<i class="fa fa-check"></i>'];
                                ?>
                                @foreach ($menus as $menu)
                                <li class="dd-item" data-id="{{$menu->id}}">
                                    <div class="item-actions">
                                        <a href="{{route($route_name_prefix.'menus.update', ['id' => $menu->id])}}" class="edit btn-edit-item" data-id="{{$menu->id}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="remove btn-delete-menu" data-id="{{$menu->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                        <span class="menu-name">{{$menu->name}}</span>
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

@section('js')
<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/menu.form.js')}}"></script>

@endsection
