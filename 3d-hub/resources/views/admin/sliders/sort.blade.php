@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = 'Sắp xếp slider')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Sắp xếp thứ tự ưu tiên của slider
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{route($route_name_prefix.'sliders.list')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Danh sách" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-profile-slider"><i class="fa fa-images"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="slider-list">
                    
                    <div class="dd nestable slider-list-body" id="crazy-slider-list" data-max-depth="1" data-callback="App.slider.sortCallback">
                        <ol class="dd-list">
                            @if (count($sliders))
                                <?php
                                    $showLabels = ["", '<i class="fa fa-check"></i>'];
                                ?>
                                @foreach ($sliders as $slider)
                                <li class="dd-item" data-id="{{$slider->id}}">
                                    <div class="item-actions">
                                        <a href="{{route($route_name_prefix.'sliders.update', ['id' => $slider->id])}}" class="edit btn-edit-item" data-id="{{$slider->id}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{{$slider->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle">
                                        <div class="row">
                                            <div class="col-7 col-lg-8"><span class="slider-name">{{$slider->name}}</span></div>
                                            <div class="col-3 col-lg-2 text-center"><span class="slider-percentage">{{$slider->getSizeText()}}</span></div>
                                            <div class="col-2 col-lg-2 text-center"><span class="slider-show">{!! $showLabels[$slider->status] !!}</span></div>
                                        </div>
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
<script src="{{asset('static/manager/js/sliders.js')}}"></script>

@endsection
