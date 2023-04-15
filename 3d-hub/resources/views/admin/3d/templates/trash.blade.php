@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách Template đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Template đã bị xóa')

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
				module:"templates",
				title:"Template",
				
				urls:{
					delete_url: @json(route($route_name_prefix.'3d.templates.delete')),
					restore_url: @json(route($route_name_prefix.'3d.templates.restore'))
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
