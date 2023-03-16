@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách các mục đăng bài')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Mục')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
	<?php
	admin_action_menu([
		[
			'url' => route($route_name_prefix.'dynamics.trash'),
			'text' => 'Mục đã xoa',
			'icon' => 'fa fa-trash'
		]
	]);
	?>
    @include($_current.'templates.results', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"dynamics",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'dynamics.move-to-trash'))
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
