<?php
	add_js_data('auth', [
		'login'=> route('post-login'),
		'fotgot' => route('post-forgot'),
		'reset' => route('password.reset.save'),
		
		'page' => isset($page)?$page:'signin',
		'error' => isset($error)?$error:null,
		
	]);
	
?>
@extends($_layout.'auth')

{{-- khai báo title --}}
@section('title', $page_title = isset($title)?$title:"Đăng nhập hệ thống")

@section('content')
    

			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{asset('static/manager/assets/app/media/img//bg/bg-3.jpg')}});">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="#">
								<img src="{{siteinfo('admin_login_logo', asset('static/images/logos/admin-logo.png'))}}">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Đăng nhập</h3>
							</div>
							<form class="m-login__form m-form" action="{{route('post-login')}}" method="POST">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Tài khoản" name="username" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Mật khẩu" name="password">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--focus">
											<input type="checkbox" name="remember"> Ghi nhớ đăng nhập
											<span></span>
										</label>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">Quên mật khẩu ?</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Đăng nhập</button>
								</div>
							</form>
						</div>

						<div class="m-login__signup">
							<div class="m-login__head">
								<h3 class="m-login__title">Đặt lại mật khẩu</h3>
								{{-- <div class="m-login__desc">Enter your details to create your account:</div> --}}
							</div>
							<form class="m-login__form m-form" action="{{route('password.reset.save')}}" method="POST">
								<input type="hidden" name="token" value="{{isset($token)?$token:uniqid()}}">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Mật khẩu mới" name="password">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Nhập lại mật khẩu" name="password_confirmation">
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Đặt lại mật khẩu</button>&nbsp;&nbsp;
									<button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Hủy</button>
								</div>
							</form>
						</div>
						
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">Quân mật khẩu ?</h3>
								<div class="m-login__desc">Nhập email để đặt lại mật khẩu:</div>
							</div>
							<form class="m-login__form m-form" action="{{route('post-forgot')}}" method="POST">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email">
								</div>
								<div class="m-login__form-action">
									<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">Gửi yêu cầu</button>&nbsp;&nbsp;
									<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Hủy</button>
								</div>
							</form>
						</div>
						<div class="m-login__account">
							<span class="m-login__account-msg">
								<!-- Don't have an account yet ? -->
							</span>&nbsp;&nbsp;
							{{-- <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a> --}}
						</div>
					</div>
				</div>
            </div>
            
@endsection


@section('js')
	<script src="{{asset('static/manager/js/login.js')}}" type="text/javascript"></script>
	
@endsection