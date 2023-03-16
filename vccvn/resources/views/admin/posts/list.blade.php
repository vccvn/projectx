@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách '.$dynamic->name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = $dynamic->name)

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
	<?php
	admin_action_menu([
		[
			'url' => admin_dynamic_url('trash'),
			'text' => $dynamic->name . ' đã xoa',
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
					move_to_trash_url: @json(admin_dynamic_url('move-to-trash'))
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
