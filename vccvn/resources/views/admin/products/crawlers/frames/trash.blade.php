@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách Frame Đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Frame Đã xóa')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'.results', ['type' => 'trash'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"crawlers.frames",
				title:"Frame",
				urls:{
                    restore_url: @json(route($route_name_prefix.'products.crawlers.frames.restore')),
                    delete_url: @json(route($route_name_prefix.'products.crawlers.frames.delete'))
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
