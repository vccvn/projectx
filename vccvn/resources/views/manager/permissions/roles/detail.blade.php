<?php
use Crazy\Html\Input;
?>
@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Chi tiết quyển ' . $detail->name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Quyền '.$detail->name)

@section('content')
	

<div class="row">
	<div class="col-12">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--head-sm" m-portlet="true">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{$detail->name}}
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row">
					<label class="col-lg-2 col-form-label" for="">Người dùng</label>
					<div class="col-lg-8">
						@include($_base.'forms.templates.crazytag', [
							'input' => new Input([
								'type' => 'crazytag',
								'name' => 'users',
								'id' => 'users',
								'value' => [],
								'data' => $detail->getUserOptions(),
								'placeholder' => 'Nhập tênl hoạc emai',
								'@search-route' => $route_name_prefix.'users.select-option'
							])
						])
					</div>
				</div>
				
			
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions m-form__actions--solid" style="padding: 30px;">
					<div class="row">
						<div class="col-lg-2"></div>
						<div class="col-lg-8">
							<button type="button" class="btn btn-success btn-save-user-role">Cập nhật</button>
							<a href="{{route($route_name_prefix.'permissions.roles.list')}}" class="btn btn-secondary">Hủy</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.permissionRolesInit = function () {
			App.permissionRoles.init({
				urls:{
					save: @json(route($route_name_prefix.'permissions.roles.save-user-role'))
				},
				role_id: {{$detail->id}}
			})
		};
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/manager/js/roles.js')}}"></script>
@endsection
