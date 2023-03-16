@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách mục đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Mục đã bị xóa')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'templates.results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"dynamics",
				title:"{{$title}}",
				
				urls:{
					delete_url: @json(route($route_name_prefix.'dynamics.delete')),
					restore_url: @json(route($route_name_prefix.'dynamics.restore'))
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
