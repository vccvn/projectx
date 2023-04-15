@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách item của slider '. $slider->name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = $slider->name)

<?php
        admin_action_menu([
            [
                'url' => admin_slider_item_url('sort.form'),
                'text' => 'Sắp xếp slider',
                'icon' => 'fa fa-sort-amount-down'
            ]
        ]);

?>

@section('content')

    <?php
	$columns = [
		'title'=>'Tiêu đề'
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
						{{'Slider: '.$title}}
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="{{admin_slider_item_url('create')}}" data-original-title="Thêm item" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
					</li>
				</ul>
			</div>
			
		</div>
		
		<div class="m-portlet__body">
	
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
									
                                    <th>Ảnh</th>
									<th class="min-160 max-250">Tiêu đề</th>
									<th class="min-160 max-250">Mô tả</th>
									<th class="min-160 max-250">Liên kết</th>
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
									
									<td>
                                        <a href="{{$url = admin_slider_item_url('update', ['id'=>$item->id])}}">
                                            <img src="{{$item->getImage()}}" class="image-thumbnail" alt="{{$item->title}}">
                                        </a>
                                    </td>
                                    <td class="min-160 max-250"><a href="{{$url}}">{{$item->title}}</a></td>
                                    <td class="min-160 max-250">{{ $item->getShortDesc(150) }}</td>
                                    <td class="min-160 max-250"><a href="{{$item->link}}">{{$item->link}}</a></td>
									<td class="min-100 actions">
										<a href="{{$url}}" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
				module:"items",
				title:"Item",
				urls:{
					delete_url: @json(admin_slider_item_url('delete'))
				}
			})
		};

		
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('static/css/users.css')}}"> --}}
@endsection


{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	
@endsection
