@php
    $profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Quên mật khẩu cấp 2')
@section('show_sidebar', 1)

@section('content')



<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Quên Mật khẩu cấp 2</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('profile.password2-forgot')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="payment_password">Mật khẩu cấp 2 mới</label>
                            <div class="input-group">
                                <input type="password" name="payment_password" class="form-control {{($payment_password = $errors->first('payment_password'))?'is-invalid':''}}" id="payment_password"
                                    placeholder="Mật khẩu cấp 2 mới" required>
                                <div class="invalid-feedback">
                                    {{$payment_password?$payment_password:"Vui lòng nhập Mật khẩu cấp 2"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="password_confirmation">Nhập lại mật khẩu cấp 2</label>
                            <div class="input-group">
                                <input type="password" name="payment_password_confirmation" class="form-control {{($payment_password_confirmation = $errors->first('payment_password_confirmation'))?'is-invalid':''}}" id="payment_password_confirmation"
                                    placeholder="Nhập lại mật khẩu cấp 2" required>
                                <div class="invalid-feedback">
                                    {{$payment_password_confirmation?$payment_password_confirmation:"Vui lòng Nhập lại mật khẩu cấp 2."}}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="otp">Mã xác thực</label>
                            <div class="input-group">
                                <input type="number" class="form-control {{($otp = $errors->first('otp'))?'is-invalid':''}}" id="otp"
                                    placeholder="Mã xác thực" name="otp" required="">
                                <div class="invalid-feedback">
                                    {{$otp?$otp:"Không được bỏ trống."}}
                                </div>
                            </div>
                        </div>

                    
                    </div>

                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection