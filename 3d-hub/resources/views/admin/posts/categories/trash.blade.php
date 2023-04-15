@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh mục '.$dynamic->name.' đã xóa')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Danh mục '.$dynamic->name.' đã xóa')

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
				module:"posts.categories",
				title:"{{'Danh mục '.$dynamic->name}}",
				
				urls:{
					delete_url: @json(admin_dynamic_url('categories.delete')),
					restore_url: @json(admin_dynamic_url('categories.restore'))
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
