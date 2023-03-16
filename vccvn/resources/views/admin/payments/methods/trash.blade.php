@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách phương thức thanh toán đã xoá')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Phương thức đã xoá')


@section('content')

<?php
$type = 'trash';
$page = request()->page;


$list_config = [
    'default' => [
        'title' => 'Danh sách người dùng',
        'btn_class' => 'btn-move-to-trash',
        'tooltip' => 'Xóa tạm thời',
    ],
    'trash' => [
        'title' => 'Danh sách tài khoản đã xóa',
        'btn_class' => 'btn-delete',
        'tooltip' => 'Xóa vĩnh viễn',
    ],
];

$list_type = (isset($type) && strtolower($type) == 'trash')?'trash':'default';

$columns = [
    'name'=>'Tên hiển thị',
    'method'=>'Phương thức',
    'description' => 'Mô tả',
    
];


$title = $list_config[$list_type]['title'];
$btn_class = $list_config[$list_type]['btn_class'];
$btn_tooltip = $list_config[$list_type]['tooltip'];
$method_options = get_payment_select_options();
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
                    'sortable'=> $columns,
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
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                
                                <th>Tên hiển thị</th>
                                <th>Phương thức</th>
                                <th>Mô tả</th>
                                <th>Cấu hình</th>
                                <th class="text-center min-100">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $method)
                                
                            <tr class="tr_method" id="crazy-item-{{$method->id}}" data-name="{{$method->name}}">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$method->id}}" data-id="{{$method->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{$edit = 'javascript:void(0);'}}" class="btn-view-detail" data-id="{{$method->id}}">
                                        {{$method->name}}
                                    </a>
                                </td>
                                <td>
                                    <a style="font-weight:500" href="{{$edit}}" class="btn-view-detail" data-id="{{$method->id}}">
                                        {{isset($method_options[$method->method])?$method_options[$method->method]:$method->method}}
                                    </a>
                                </td>
                                <td>{{ $method->description }}</td>
                                <td>
                                    <a href="{{$edit}}" class="btn-view-detail" data-id="{{$method->id}}">
                                        Xem
                                    </a>
                                </td>
                                <td class="text-center min-100">
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="{{$edit}}" class="btn-edit-method text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-id="{{$method->id}}">
                                        <i class="flaticon-edit-1"></i>
                                    </a>

                                    @if ($list_type=='trash')
                                    
                                    <a href="javascript:void(0);" data-id="{{$method->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                        
                                    @endif

                                    <a href="javascript:void(0);" data-id="{{$method->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="{{$btn_tooltip}}" class="{{$btn_class}} text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
            <div class="alert alert-warning text-center">Danh sách trống</div>
        @endif
        
    </div>

    <!--end::Form-->
</div>

@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"payment.methods",
				title:"Phương thức thanh toán",
				urls:{
                    move_to_trash_url: @json(route($route_name_prefix.'payments.methods.move-to-trash')),
                    delete_url: @json(route($route_name_prefix.'payments.methods.delete')),
					restore_url: @json(route($route_name_prefix.'payments.methods.restore'))
				}
			})
		};
		// khai báo ở dây

		window.paymentMethodInit = function () {
			App.payments.methods.init({
				urls:{
					method_inputs: @json(route($route_name_prefix.'payments.methods.inputs')),
					ajax_save: @json(route($route_name_prefix.'payments.methods.ajax.save')),
					ajax_detail: @json(route($route_name_prefix.'payments.methods.ajax.detail'))
				},
				configMethods: {!! json_encode(get_payment_config('methods')) !!}
			})
		};
		// khai báo ở dây

		
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script src="{{asset('static/manager/js/payments.methods.js')}}"></script>
@endsection
