@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách phương thức thanh toán hiện đang có trên website')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Phương thức thanh toán')


@section('content')
	@include($_current.'results', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"payment.methods",
				title:"Phương thức thanh toán",
				urls:{
					move_to_trash_url: @json(route($route_name_prefix.'payments.methods.move-to-trash'))
				}
			})
		};
		// khai báo ở dây

		window.paymentMethodInit = function () {
			App.payments.methods.init({
				urls:{
					method_inputs: @json(route($route_name_prefix.'payments.methods.inputs')),
					ajax_save: @json(route($route_name_prefix.'payments.methods.ajax.save')),
					ajax_detail: @json(route($route_name_prefix.'payments.methods.ajax.detail')),
					ajax_status: @json(route($route_name_prefix.'payments.methods.ajax.update-status')),
					ajax_priority: @json(route($route_name_prefix.'payments.methods.ajax.update-priority'))
				},
				configMethods: {!! json_encode(get_payment_config('methods')) !!}
			})
		};
		// khai báo ở dây

		
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')

    <script src="{{asset('static/manager/assets/vendors/custom/jquery-ui/jquery-ui.bundle.js')}}" type="text/javascript"></script>
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
	<script src="{{asset('static/manager/js/payments.methods.js')}}"></script>
@endsection
