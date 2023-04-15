@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách model đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Model đã bị xóa')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('static/css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"models",
				title:"Model",
				
				urls:{
					delete_url: @json(route($route_name_prefix.'3d.models.delete')),
					restore_url: @json(route($route_name_prefix.'3d.models.restore'))
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
