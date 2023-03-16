<?php

extract(get_result_blade_vars('sản phẩm', (isset($type) && strtolower($type) == 'trash')?'trash':'default'));
$product_status = ['Hết hàng', 'Còn hàng'];
?>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{$title}}
                </h3>
            </div>
        </div>
        @if ($list_type!='trash')
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{route($route_name_prefix.'products.create')}}" data-original-title="Thêm sản phẩm" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        @endif

    </div>
    
    <div class="m-portlet__body">

        <div class="m-section">
            <div class="m-section__sub">
                @include($_current.'list-filter',[
                    'sortable'=> [
                        'name' => 'Tên sản phẩm',
                        'category_name' => 'Danh mục',
                        'list_price' => 'Giá sản phẩm',
                        'code' => 'Mã sản phẩm',
                        'status' => 'Trạng thái còn hàng',
                        'created_at' => 'Thời gian đăng',

                    ]
                ])
            </div>
        </div>
        @if (isset($results) && count($results))
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list product-list">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                <th>Mã</th>
                                <th>Ảnh</th>
                                <th class="min-160 max-250 name">Tên sản phẩm</th>
                                <th class="min-160 max-250 category">Danh mục</th>
                                <th class="min-100">Loại</th>
                                <th class="min-160 max-250 description">Mô tả</th>
                                <th>Giá bán</th>
                                <th class="min-100">Trạng thái</th>
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                                
                            <tr id="crazy-item-{{$item->id}}" data-name="{{$item->name}}" class="crazy-item-{{$item->parent_id}}">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    <a style="font-weight:500" href="{{$edit = route($route_name_prefix.'products.update', ['id'=>$item->id])}}">
                                        <img src="{{$item->getFeatureImage()}}" class="image-thumbnail" alt="{{$item->title}}">
                                    </a>
                                </td>
                                <td class="min-160 max-250 name"><a href="{{$edit}}">{{$item->name}}</a></td>
                                <td class="min-160 max-250 category category-map" data-category-id="{{ $item->category_id }}">{{ $item->category_name }}</td>
                                <th class="min-100">{{$item->getTypeLabel()}}</th>
                                <td class="min-160 max-250 description">{{ $item->getShortDesc(150) }}</td>
                                <td>{{ $item->priceFormat() }}</td>
                                <td class="min-100">{{ $product_status[$item->status]??'' }}</td>
                                <td class="min-100 actions">

                                    
                                    <a title data-original-title="Sửa" href="{{$edit}}" data-toggle="m-tooltip" data-placement="left" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>
                                    
        
                                    @if ($list_type=='trash')
                                    
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                        
                                    @endif

                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="{{$btn_tooltip}}" class="{{$btn_class}} text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                    
                                </td>
                            </tr>

                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- nút phân trang --}}
        <div class="list-toolbar">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-check"></i>
                        </a>

                        @if ($list_type=='trash')
                        
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Khôi phục tất cả" class="crazy-btn-restore-all text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-undo"></i>
                        </a>
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        @else
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="crazy-btn-move-to-trash-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        
                        @endif

                        
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    {{$results->links($_pagination.'default')}}
                </div>
            </div>
        </div>
        <!--end::Section-->

        @else
        <div class="alert alert-default text-center">Danh sách trống</div>
        @endif
        
    </div>

    <!--end::Form-->
</div>
