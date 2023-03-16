@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách trang')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Trang')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
	<?php
	admin_action_menu([
		[
			'url' => route($route_name_prefix.'pages.trash'),
			'text' => 'Mục đã xoa',
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
				module:"pages",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'pages.move-to-trash'))
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
