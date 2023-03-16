@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách package đã bị xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Danh sách package đã bị xóa')

@section('content')
	@include($_current.'templates.list', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"package",
				title: "Package",
				urls:{
					delete_url: @json(route('packages.delete')),
					restore_url: @json(route('packages.restore'))
					
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
