@php
    $profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Yêu cầu rút điểm')
@section('show_sidebar', 1)

{{-- @section('header_title', "Thanh toán") --}}

@section('content')



<div class="row">
    <div class="col-xl-6 col-md-10 col-lg-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Yêu cầu rút điểm</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('payment.requests.withdraw')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="withdraw">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="amount">Số điểm</label>
                            <div class="input-group">
                                <input type="number" name="amount" step="1" min="1" class="form-control {{($amount = $errors->first('amount'))?'is-invalid':''}}" id="amount"
                                    placeholder="Số điểm" required>
                                <div class="invalid-feedback">
                                    {{$amount?$amount:"Vui lòng nhập số điểm"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="payment_password">Mật khẩu cấp 2</label>
                            <div class="input-group">
                                <input type="password" name="payment_password" class="form-control {{($payment_password = $errors->first('payment_password'))?'is-invalid':''}}" id="payment_password"
                                    placeholder="Mật khẩu cấp 2 mới" required>
                                <div class="invalid-feedback">
                                    {{$payment_password?$payment_password:"Vui lòng nhập Mật khẩu cấp 2"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a href="{{route('profile.password2-forgot')}}">Quên mật khẩu cấp 2</a>
                        </div>
                        @if ($profile->google2fa_secret)
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
                        @endif
                    </div>
                    
                    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
@endsection