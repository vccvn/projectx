@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách các Giao diện')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Giao diện')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('static/css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'templates.results', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"theme",
				title:"{{$title}}",
				urls:{
					move_to_trash_url: @json(route('themes.move-to-trash'))
				}
			})
		};
		window.crazyThemeInit = function () {
			App.theme.init({
				urls:{
					extract: @json(route('themes.extract'))
				}
			})
		};
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script src="{{asset('static/manager/js/theme.js')}}"></script>
@endsection
