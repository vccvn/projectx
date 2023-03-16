@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách Nguồn')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Frame')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
	<?php
	admin_action_menu([
		[
			'url' => route($route_name_prefix.'products.crawlers.frames.trash'),
			'text' => 'Frame đã xoa',
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
				module:"crawlers.frames",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'products.crawlers.frames.move-to-trash'))
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
