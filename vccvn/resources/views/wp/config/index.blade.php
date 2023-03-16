@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Config')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Config')


@section('content')
	<div class="row">
		<div class="col-md-8">
			<!--begin::Portlet-->
			<div class="m-portlet">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Config
							</h3>
						</div>
					</div>
				</div>
				@if ($wp)
				
				<form method="post" action="{{route('config.save')}}" class="m-form m-form--fit m-form--label-align-right">
					@csrf
					<div class="m-portlet__body">

						<div class="form-group m-form__group row {{$errors->has('debug')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="debug">Debug</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group">
									@include('wp.forms.templates.switch', [
										'input' => html_input([
											'type' => 'switch',
											'name' => 'debug',
											'id' => 'debug',
											'check_label' => 'Kích hoạt',
											'value' => old('debug', $wp->debug)
										])
									])
									
								</div>

								@if ($dbnErr =  $errors->first('debug'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>



						<div class="form-group m-form__group row {{$errors->has('db_host')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_host">DB Host</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_host_label">
											<i class="fa fa-globe"></i>
										</span>
									</div>
									<input type="text" name="db_host" value="{{old('db_host', $wp->db_host('localhost'))}}" id="db_host" class="form-control m-input" placeholder="DB Host" aria-describedby="db_host_label">
									
								</div>

								@if ($dbnErr =  $errors->first('db_host'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						
						<div class="form-group m-form__group row {{$errors->has('db_name')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_name">Database</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_name_label">
											<i class="fa fa-database"></i>
										</span>
									</div>
									<input type="text" name="db_name" value="{{old('db_name', $wp->db_name($user->secret_id))}}" id="db_name" class="form-control m-input" placeholder="Tên CSDL" aria-describedby="db_name_label">
									
									
								</div>

								@if ($dbnErr =  $errors->first('db_name'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						<div class="form-group m-form__group row {{$errors->has('db_user')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_user">DB User</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_user_label">
											<i class="fa fa-user"></i>
										</span>
									</div>
									<input type="text" name="db_user" value="{{old('db_user', $wp->db_user($user->secret_id))}}" id="db_user" class="form-control m-input" placeholder="Tên người dùng" aria-describedby="db_user_label">
									
									
								</div>

								@if ($dbUnErr =  $errors->first('db_user'))
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
									<input type="password" name="db_password" id="db_password" value="{{old('db_password', $wp->db_password)}}" class="form-control m-input" placeholder="Mật khẩu CSDL" aria-describedby="db_password_label">
									
									
								</div>

								@if ($dbPwErr =  $errors->first('db_password'))
									<div class="form-control-feedback">{{$dbPwErr}}</div>
								@endif
							</div>
						</div>


						<div class="form-group m-form__group row {{$errors->has('db_charset')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_charset">DB CHARSET</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_charset_label">
											<i class="fa fa-frog"></i>
										</span>
									</div>
									<input type="text" name="db_charset" value="{{old('db_charset', $wp->db_charset('utf8'))}}" id="db_charset" class="form-control m-input" placeholder="DB Charset" aria-describedby="db_charset_label">
									
								</div>

								@if ($dbnErr =  $errors->first('db_charset'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						<div class="form-group m-form__group row {{$errors->has('db_collate')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_host">DB COLLATE</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="db_collate_label">
											<i class="fa fa-frog"></i>
										</span>
									</div>
									<input type="text" name="db_collate" value="{{old('db_collate', $wp->db_collate)}}" id="db_collate" class="form-control m-input" placeholder="DB Collate" aria-describedby="db_collate_label">
								</div>

								@if ($dbnErr =  $errors->first('db_collate'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
								@endif
							</div>
						</div>
						
						<div class="form-group m-form__group row {{$errors->has('table_prefix')?'has-danger':''}}">
							<label class="col-form-label col-lg-3" for="db_host">Table Prefix</label>
							<div class="col-lg-9">
								
								<div class="input-group m-input-group m-input-group--air">
									<div class="input-group-prepend">
										<span class="input-group-text" id="table_prefix_label">
											<i class="fa fa-frog"></i>
										</span>
									</div>
									<input type="text" name="table_prefix" value="{{old('table_prefix', $wp->isset('table_prefix')?$wp->table_prefix:'')}}" id="table_prefix" class="form-control m-input" placeholder="DB Collate" aria-describedby="table_prefix_label">
								</div>

								@if ($dbnErr =  $errors->first('table_prefix'))
									<div class="form-control-feedback">{{$dbnErr}}</div>
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
										3360
									</td>
								</tr>

								<tr>
									<td>Database</td>
									<td>
										{{$user->secret_key}}_db
									</td>
								</tr>
								<tr>
									<td>Username</td>
									<td>
										{{$user->secret_key}}_master
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
		
	@if ($errorSession = session('error'))
		<script>
			App.modal.error(@json($errorSession));
		</script>
	@elseif ($validateError = $errors->first())
		<script>
			App.modal.error("Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin");
		</script>
	@endif
@endsection
