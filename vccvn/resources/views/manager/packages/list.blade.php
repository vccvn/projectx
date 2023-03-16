@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách package hoạt động')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Danh sách package')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
	@include($_current.'templates.list', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"package",
				title:"package",
				urls:{
					move_to_trash_url: @json(route('packages.move-to-trash'))
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
