<?php
$columns = [
    'name'=>'Tên danh mục',
    // 'type' => 'Loại tin bài'
];
extract(get_result_blade_vars('danh mục', (isset($type) && strtolower($type) == 'trash')?'trash':'default'));

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
                    <a href="{{route($route_name_prefix.'products.categories.create')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm danh mục" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        @endif

    </div>
    
    <div class="m-portlet__body">

        <div class="m-section">
            <div class="m-section__sub">
                @include($_template.'list-filter',[
                    'sortable'=> array_merge($columns, [
                        'updated_at' => 'Thời gian cập nhật'
                    ]),
                    'searchable' => $columns
                ])
            </div>
        </div>
        @if (isset($results) && count($results))
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                
                                <th>Ảnh</th>
                                <th class="min-160 max-250">Tên danh mục</th>
                                <th class="min-160 max-250">Danh mục cha</th>
                                <th class="min-160">Mô tả</th>
                                <th>Số sản phẩm</th>
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                                
                            <tr id="crazy-item-{{$item->id}}" data-name="{{$item->name}}">
                                <td class="text-center">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                
                                <td>
                                    <a style="font-weight:500" href="#">
                                        <img src="{{$item->getFeatureImage()}}" class="image-thumbnail" alt="{{$item->name}}">
                                    </a>
                                </td>
                                <td class="min-160 max-250"><a href="#">{{$item->name}}</a></td>
                                @if ($item->parent)
                                    <td class="min-160 max-250 category category-map" data-category-id="{{ $item->parent_id }}">{{ $item->parent->name }}</td>    
                                @else
                                    <td class="min-160 max-250">{{ $item->parent?:'không' }}</td>
                                @endif
                                
                                <td class="min-160">{{ $item->getShortDesc(120) }}</td>
                                <td>{{ $item->product_count??0 }}</td>
                                <td class="min-100 actions">

                                    
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="{{route($route_name_prefix.'products.categories.update', ['id'=>$item->id])}}" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
