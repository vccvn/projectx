@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách trang đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Trang đã bị xóa')

@section('content')
    @include($_current.'results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"pages",
				title:"Trang",
				
				urls:{
					delete_url: @json(route($route_name_prefix.'pages.delete')),
					restore_url: @json(route($route_name_prefix.'pages.restore'))
				}
			})
		};
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
@endsection
