@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách giao diện đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Giao diện đã bị xóa')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('static/css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'templates.results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"theme",
				title:"Giao diện",
				
				urls:{
					delete_url: @json(route('themes.delete')),
					restore_url: @json(route('themes.restore'))
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
