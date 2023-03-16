@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Dashboard')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Dashboard')


@section('content')
	<div class="row">
		<div class="col-md-8">
			<!--begin::Portlet-->
			<div class="m-portlet">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Api
							</h3>
						</div>
					</div>
				</div>
				<form method="post" action="{{route('domain.save')}}" class="m-form m-form--fit m-form--label-align-right">
					@csrf
					<div class="m-portlet__body">

						<div class="form-group m-form__group row {{$errors->has('subdomain')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="subdomain">Sub-Domain</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="subdomain_label">
											<i class="fa fa-globe"></i>
										</span>
									</div>
									<input type="text" name="subdomain" value="{{$webSetting->subdomain}}" id="subdomain" class="form-control m-input" placeholder="Tên miền" aria-describedby="subdomain_label">
									<div class="input-group-prepend">
										@include('cpanel.forms.templates.crazyselect', [
											'input' => html_input([
												'type' => 'crazyselect',
												'name' => 'domain',
												'data' => 'get_cfg_domain_options',
												'default' => old('domain', $webSetting->domain)
											])
										])
									</div>
									
									
								</div>

								@if ($dbnErr =  $errors->first('subdomain'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						<div class="form-group m-form__group row {{$errors->has('alias_domain')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="alias_domain">Alias Domain</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="alias_domain_label">
											<i class="fa fa-globe"></i>
										</span>
									</div>
									<input type="text" name="alias_domain" value="{{$webSetting->alias_domain}}" id="alias_domain" class="form-control m-input" placeholder="Tên miền alias" aria-describedby="alias_domain_label">
									
									
								</div>

								@if ($dbUnErr =  $errors->first('alias_domain'))
									<div class="form-control-feedback">{{$dbUnErr}}</div>
								@endif
							</div>
						</div>

						
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions text-center">
							<button type="submit" class="btn btn-success">Cập nhật</button>
							
						</div>
					</div>
				</form>

				
			</div>

			<!--end::Portlet-->
		</div>

		
		<div class="col-md-4">
								
			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--head-sm">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Hosting
							</h3>
						</div>
					</div>
					
				</div>
				<div class="m-portlet__body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<tbody>
								<tr>
									<td>IP</td>
									<td>{{$_SERVER['SERVER_ADDR']}}</td>
								</tr>
								<tr>
									<td>Sub-Domain</td>
									<td>
										
										<a href="http://{{$webSetting->subdomain . '.' . $webSetting->domain}}">
											{{$webSetting->subdomain . '.' . $webSetting->domain}}
										</a>
									</td>
								</tr>
								<tr>
									<td>Alias-Domain</td>
									<td>
										@if ($webSetting->alias_domain)
											<a href="http://{{$webSetting->alias_domain}}">{{$webSetting->alias_domain}}</a>
										@endif
									</td>
								</tr>
								<tr>
									<td>DOCUNENT_ROOT</td>
									<td>
										/public
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<!--end::Portlet-->

		</div>

	</div>

@endsection

@section('js')
	<script>
		$(function(){
			$(document).on("click", ".btn-show-password", function (e) {
				App.modal.popup({
					title: "Xác minh truy cập",
					inputs: {
						password:{
							type: "password",
							label: "Nhập mật khẩu",
							validate: function (mk) {
								return mk.length > 0;
							}
						}
					},
					btnDone: "OK",
					done: function (data) {
						App.ajax("{{route('database.get-password')}}", "POST", data, function (rs) {
							if(rs.status){
								$('#db_password').val(rs.data.value);
								$('#db_password').attr('type', 'text');
							}else{
								App.modal.warning(rs.message);
							}
						}, function (e) {
							App.modal.error("Lỗi không xác định");
						})
					}
				})
			})
		})
	</script>
@endsection