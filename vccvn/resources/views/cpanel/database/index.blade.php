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
								Database
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="http://phpmyadmin.{{get_cfg_domain()}}" target="_blank" data-toggle="m-tooltip" data-placement="top" title data-original-title="phpMyAfmin" class="ml-2 btn btn-danger m-btn btn-sm"><i class="fab fa-php"></i> <span class="d-none d-md-inline-block">phpMyAfmin</span></a>
                            </li>
                        </ul>
                    </div>
				</div>
				@if (!$dbExists)
				<div class="m-portlet__body">
					<!--begin::Section-->
					<div class="m-section m-section--last">
					
						<div class="alert alert-warning mb-3">
							Hiện tại bạn chưa thiết lập CSDL
						</div>

					</div>

					<!--end::Section-->
				</div>

				<form method="post" action="{{route('database.create')}}" class="m-form m-form--fit m-form--label-align-right">
					@csrf
					<div class="m-portlet__body">

						<div class="form-group m-form__group row {{$errors->has('db_name')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_name">Database</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_name_label">
											<i class="fa fa-database"></i>
										</span>
									</div>
									<input type="text" name="db_name" value="{{$user->secret_id}}" id="db_name" class="form-control m-input" placeholder="Tên CSDL" aria-describedby="db_name_label" readonly disabled>
									
									
								</div>

								@if ($dbnErr =  $errors->first('db_name'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						<div class="form-group m-form__group row {{$errors->has('db_username')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_username">Userame</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_username_label">
											<i class="fa fa-user"></i>
										</span>
									</div>
									<input type="text" name="db_username" value="{{$user->secret_id}}" id="db_username" class="form-control m-input" placeholder="Tên người dùng" aria-describedby="db_username_label" readonly disabled>
									
									
								</div>

								@if ($dbUnErr =  $errors->first('db_username'))
									<div class="form-control-feedback">{{$dbUnErr}}</div>
								@endif
							</div>
						</div>

						<div class="form-group m-form__group row {{$errors->has('db_password')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_password">Password</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_password_label">
											<i class="fa fa-key"></i>
										</span>
									</div>
									<input type="password" name="db_password" id="db_password" class="form-control m-input" placeholder="Mật khẩu CSDL" aria-describedby="db_password_label">
									
									
								</div>

								@if ($dbPwErr =  $errors->first('db_password'))
									<div class="form-control-feedback">{{$dbPwErr}}</div>
								@endif
							</div>
						</div>
						
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions text-center">
							<button type="submit" class="btn btn-success">Khởi tạo</button>
							
						</div>
					</div>
				</form>

				@else

				<div class="m-form m-form--fit m-form--label-align-right">
					<div class="m-portlet__body">

						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3" for="db_name">Database</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_name_label">
											<i class="fa fa-database"></i>
										</span>
									</div>
									<input type="text" name="db_name" value="{{$user->secret_id}}" id="db_name" class="form-control m-input" placeholder="Tên CSDL" aria-describedby="db_name_label" readonly>
								</div>

							</div>
						</div>
						
						<div class="form-group m-form__group row ">
							<label class="col-form-label col-lg-3" for="db_username">Userame</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_username_label">
											<i class="fa fa-user"></i>
										</span>
									</div>
									<input type="text" name="db_username" value="{{$user->secret_id}}" id="db_username" class="form-control m-input" placeholder="Tên người dùng" aria-describedby="db_username_label" readonly>
									
									
								</div>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3" for="db_password">Password</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_password_label">
											<i class="fa fa-key"></i>
										</span>
									</div>
									<input type="password" value="**********" name="db_password" id="db_password" class="form-control m-input" placeholder="Mật khẩu CSDL" aria-describedby="db_password_label" readonly>
									<div class="input-group-append">
										<button class="btn btn-info btn-show-password">
											<i class="fa fa-eye"></i>
										</button>
									</div>
									
									
								</div>
							</div>
						</div>
						
					</div>

				</div>

				@endif
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
								Database Hosting
							</h3>
						</div>
					</div>
					
				</div>
				<div class="m-portlet__body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<tbody>
								<tr>
									<td>Số lượng</td>
									<td>1</td>
								</tr>
								<tr>
									<td>Host</td>
									<td>
										{{$_SERVER['SERVER_ADDR']}} / localhost / 127.0.0.1
									</td>
								</tr>
								<tr>
									<td>Port</td>
									<td>
										3306
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
						App.api.post("{{route('database.get-password')}}", data).then(function (rs) {
							if(rs.status){
								$('#db_password').val(rs.data.value);
								$('#db_password').attr('type', 'text');
							}else{
								App.Swal.warning(rs.message);
							}
						})
						.catch(function (e) {
							App.Swal.error("Lỗi không xác định");
						})
					}
				})
			})
		})
	</script>
		
@endsection
