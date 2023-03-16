@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách sản phẩm đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Sản phẩm đã bị xóa')

@section('content')
    @include($_current.'results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"products",
				title:"Sản phẩm",
				
				urls:{
					delete_url: @json(route($route_name_prefix.'products.delete')),
					restore_url: @json(route($route_name_prefix.'products.restore'))
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
