@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách người dùng hoạt động')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Danh sách người dùng')

{{-- Nhúng link css --}}
@section('css')
    {{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')
    @include($_current.'templates.list', ['type' => 'default'])
@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
    <script>
        window.crazyItemsInit = function() {
            App.items.init({
                module: "user",
                title: "Người dùng",
                urls: {
                    move_to_trash_url: @json(route('users.move-to-trash'))
                }
            })
        };
        // khai báo ở dây
    </script>
@endsection

{{-- Nhúng js --}}

@section('js')
    <script src="{{ asset('static/crazy/js/items.js') }}"></script>


	<script>
		$(function(){
			$(document).on('click', ".btn-extension", function(e){
				e.preventDefault();

				try {
					var $this = $(this);
					var id = $this.data('id');
					var name = $this.data('name');
					var domain = $this.data('domain');
					var expired  = $this.attr('data-expired');

					App.modal.popup({
						title: "Gia hạn cho tên miền",
						size: "md",
						inputs: {
							domain: {
								
								type: "text",
								label: "Tên Miền",
								value: domain,
								readonly: "true",
								disabled: "true"

							},
							expired_at: {
								
								type: "text",
								label: "Hạn đến ngày",
								value: expired,
								className: "inp-time",
								format: "YYYY-mm-dd hh:ii:ss",
								validate: function(value){
									return value && value.length>=10;
								}

							}
						},
						done: function(data){
							data.id = id;
							App.api.post("{{route('users.extension')}}", data).then(function(rs){
								if(rs.status){
									App.Swal.success(rs.message);
									$('#crazy-item-' + id + " .expired-at").html(data.expired_at);
									$this.attr('data-expired', data.expired_at);
								}else{
									App.Swal.warning(rs.message)
								}
							}).catch(function(e){
								App.Swal.error("Lỗi không xác định")
							})
						}
					})
				} catch (error) {
					
				}
				return false;
			})
		});
	</script>

@endsection
