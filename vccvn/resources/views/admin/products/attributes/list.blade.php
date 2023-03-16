<?php
set_admin_template_data('modals', 'colorpicker-modal');

?>

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách thuộc tính sản phẩm')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Thuộc tính sản phẩm')

@section('content')

    <?php
	$columns = [
		'name'=>'Tên thuộc tính',
		'label'=>'Nhãn',
		// 'type' => 'Loại tin bài'
	];

	$price_types = ['Cộng dồn', 'Thay thế giá sản phẩm'];
	$checkTag = '<i class="fa fa-check text-success"></i>';
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
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{route($route_name_prefix.'products.attributes.create')}}" data-original-title="Thêm thuộc tính" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
					</li>
				</ul>
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
						<table class="table table-bordered table-striped list-center">
							<thead>
								<tr>
									<th class="check-col">
										<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" class="crazy-check-all"> 
											<span></span>
										</label>
									</th>
									
									<th>Thuộc tính</th>
									<th class="min-160 max-250">Danh mục</th>
									<th>Bắt buộc nhập</th>
									<th>Trong đơn hàng</th>
									<th>Biến thể</th>
									<th>Giá trị</th>
									<th class="min-100 actions">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($results as $item)
									
								<tr id="crazy-item-{{$item->id}}" data-name="{{$item->label??$item->name}}">
									<td class="check-col">
										<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
											<span></span>
										</label>
									</td>
									
									<td><a href="javascript:void(0);">{{$item->label??$item->name}}</a></td>
									<td class="min-160 max-250 attribute-category" data-id="{{$item->category_id}}">
										{{$item->category_name??"Tất cả"}}
									</td>
									<td>{!! $item->is_required?$checkTag:'' !!}</td>
									<td>{!! $item->is_order_option?$checkTag:'' !!}</td>
									<td>{{ $item->is_variant?(isset($price_types[$item->price_type])?$price_types[$item->price_type] : 'Không') : 'Không' }}</td>
									<td>
										@if (!$item->is_unique && $item->value_type != 'text')
											<a href="javascript:void(0);" data-id="{{$item->id}}" class="btn-view-attribute-values">Xem danh sách</a>
										@endif
										
									</td>
									<td class="min-100 actions">
										<a href="{{route($route_name_prefix.'products.attributes.update', ['id'=>$item->id])}}" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
											<i class="flaticon-edit-1"></i>
										</a>
										<a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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

							<a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
								<i class="flaticon-delete-1"></i>
							</a>
							
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
	
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"products.attributes",
				title:"{{$title}}",
				urls:{
					delete_url: @json(route($route_name_prefix.'products.attributes.delete'))
				}
			})
		};

		window.productAttributeInit = function () {
			Product.attributes.init({
				categories: @json(get_product_attribute_category_options())
			})
		};

		
		window.attributeValuesInit = function () {
			Attribute.values.init({
				urls:{
					attribute_detail_url: @json(route($route_name_prefix.'products.attributes.detail-values')),
					add_url: @json(route($route_name_prefix.'products.attributes.values.store')),
					update_url: @json(rtrim(route($route_name_prefix.'products.attributes.values.update'), '/')),
					detail_url: @json(rtrim(route($route_name_prefix.'products.attributes.values.detail'), '/')),
					delete_url: @json(route($route_name_prefix.'products.attributes.values.delete'))
				}
			})
		};

		
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script src="{{asset('static/manager/js/product.attributes.js')}}"></script>
	<script src="{{asset('static/manager/js/attribute.values.js')}}"></script>
@endsection
