<?php
$types = ['multi-page' => 'Multi Page', 'spa' => 'SPA'];
$columns = [
    'name'=>'Tên theme',
    'type' => 'Loại theme',
    'version'=>'phiên bãn'
];
$list_config = [
    'default' => [
        'title' => 'Danh sách theme',
        'btn_class' => 'btn-move-to-trash',
        'tooltip' => 'Xóa tạm thời',
    ],
    'trash' => [
        'title' => 'Danh sách theme đã xóa',
        'btn_class' => 'btn-delete',
        'tooltip' => 'Xóa vĩnh viễn',
    ],
];
$list_type = (isset($type) && strtolower($type) == 'trash')?'trash':'default';
$title = $list_config[$list_type]['title'];
$btn_class = $list_config[$list_type]['btn_class'];
$btn_tooltip = $list_config[$list_type]['tooltip'];

$privacy = [
    'protected' => 'Được bảo vệ',
    'public'    => 'Công khai'
];

$available = ["Không", "Sẵn sàng"];

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
                    <table class="table table-bordered table-striped list-center">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th class="max-200">Tên</th>
                                <th class="min-100">Loại</th>
                                <th class="min-80">Phiên bản</th>
                                <th class="min-160 max-200">Mô tả</th>
                                <th>Riêng tư</th>
                                @if ($list_type!='trash')
                                <th>Có thể sử dụng</th>
                                @endif
                                <th class="min-160">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                                
                            <tr class="tr_user" id="crazy-item-{{$item->id}}" data-name="{{$item->name}}">
                                <td class="text-center">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-center">{{$item->id}}</td>
                                <td class="max-200"><a href="{{$edit = route('themes.update', ['id'=>$item->id])}}">{{$item->name}}</a></td>
                                <td class="min-100">{{ isset($types[$item->view_type])?$types[$item->view_type]:$item->view_type }}</td>
                                <td class="text-center min-80">{{ $item->version }}</td>
                                <td class="text-center min-160 max-200">{{ $item->getShortDesc(100) }}</td>
                                <td class="text-center min-100">{{ isset($privacy[$item->privacy])?$privacy[$item->privacy]:'mặc định' }}</td>
                                @if ($list_type!='trash')
                                
                                <td>{{isset($available[$item->available])?$available[$item->available]:'không'}}</td>


                                @endif
                                <td class="text-center min-160">

                                    
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="{{$edit}}" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>
                                    
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Tải về file zip" href="{{route('themes.download', ['slug'=>$item->slug])}}" class="text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-download"></i>
                                    </a>
        
                                    @if ($list_type!='trash')
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="giải nén file zip" class="text-swarning btn btn-outline-warning btn-extract btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-folder-1"></i>
                                    </a>

                                    @else
                                    
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                        
                                    @endif

                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="{{$btn_tooltip}}" class="{{$btn_class}} text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                    {{-- <a href="{{route('user.add')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm người dùng" class="btn btn-outline-primary m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-user-add"></i>
                                    </a> --}}
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
            <div class="alert alert-warning">Danh sách trống</div>
        @endif
        
    </div>

    <!--end::Form-->
</div>
