<?php
	add_js_data('install', [
		'create'=> route('install.create'),
		'page' => isset($page)?$page:'signin',
		'error' => isset($error)?$error:null,

	]);

?>
@extends('manager._layouts.auth', [
    '_base' => 'manager.',
    '_template' => 'manager._templates.'

    ])

{{-- khai báo title --}}
@section('title', $page_title = isset($title)?$title:"Thiết lập hệ thống")

@section('content')


			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{asset('static/manager/assets/app/media/img//bg/bg-3.jpg')}});">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="#">
								<img src="{{asset('static/images/logos/admin-logo.png')}}">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Tạo tài khoản thiết lập</h3>
							</div>
                            <form class="m-login__form m-form" action="{{ route('install.create') }}" method="POST">
								{{ csrf_field() }}
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="email" placeholder="Email" name="email" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Mật khẩu" name="password">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Xác nhận Mật khẩu" name="password_confirmation">
								</div>

								<div class="m-login__form-action">
									<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--success">Cài đặt</button>
								</div>
							</form>
						</div>
						<div class="m-login__account">
							<span class="m-login__account-msg">
								Cần trợ giúp?
							</span>&nbsp;&nbsp;
							<a href="//vcc.vn/lien-he.html" class="m-link m-link--light m-login__account-link">Liên hệ</a>
						</div>
					</div>
				</div>
            </div>

@endsection


@section('js')
	<script src="{{asset('static/manager/js/installform.js')}}" type="text/javascript"></script>

@endsection
