@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách sản phẩm')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Sản phẩm')


@section('content')
	<?php
	admin_action_menu([
		[
			'url' => route($route_name_prefix.'products.trash'),
			'text' => 'Sản phẩm đã xoa',
			'icon' => 'fa fa-trash'
		]
	]);
	?>
    @include($_current.'results', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"products",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'products.move-to-trash'))
				}
			})
		};
		// khai báo ở dây
		
		window.categoryInit = function () {
			Category.init({
				categories: @json(get_product_attribute_category_options())
			})
		};
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script src="{{asset('static/manager/js/categories.js')}}"></script>
@endsection
