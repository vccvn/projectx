@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách tài khoản đã bị xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Danh sách tài khoản đã bị xóa')

@section('content')
	@include($_current.'templates.list', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"user",
				title:"Người dùng",
				urls:{
					delete_url: @json(route($route_name_prefix.'users.delete')),
					restore_url: @json(route($route_name_prefix.'users.restore'))
					
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
