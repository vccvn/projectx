@php
    $profile = getUser();
    $google = 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=vi';
    $apple = 'https://apps.apple.com/us/app/google-authenticator/id388497605';
@endphp
@extends($_layout.'master')
@section('title', 'Thiết lập 2FA')
@section('show_sidebar', 1)

@section('content')


<div class="row">
    <div class="col-md-10 col-lg-8 ml-auto mr-auto">
        <div class="ms-panel ms-panel-fh">
          <div class="ms-panel-header">
            <h6>Setup 2FA</h6>
          </div>
          <div class="ms-panel-body">
            <form class="ms-form-wizard ms-wizard-pill style2-wizard" id="g2fa-wizard">
              <h3>Tải Ứng dụng</h3>
              <div class="ms-wizard-step g2fa-app-download">
                <p class="mt-5 pt-5 px-md-4 fs-18 mb-4">
                    Để có thể sử dụng tính năng 2FA, trước tiên bạn cần tải về ứng dụng <br> <span class="d-inline"><strong>Google Authenticator</strong></span>
                </p>
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <a target="_blank" href="https://apps.apple.com/us/app/google-authenticator/id388497605">
                            <img src="{{asset('static/images/g2fa-ios.png')}}" alt="">
                        </a>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=vi">
                            <img src="{{asset('static/images/g2fa-android.png')}}" alt="">
                        </a>
                    </div>
                </div>
              </div>
              <h3>Quét QR Code</h3>
              <div class="ms-wizard-step">
                <p class="mt-5 pt-1 px-md-4 fs-18 mb-2 text-center">
                    Vui lòng quét mã QR hoặc chép lại mã Auth để thiết lập 2FA
                </p>
                
                <div class="mx-md-1 mx-lg-3 px-md-1 px-lg-4">
                    <div class="row">
                        <div class="col-sm-6 col-md-5 text-center text-md-right">
                            <img src="{{ $QR_Image }}">
                        </div>
                        <div class="col-sm-6 col-md-7 pt-sm-1 pt-md-4">
                            <p>
                                Thiết lập cho <strong>{{auth()->user()->email}}</strong>. <br>
                                Mã: <strong>{{ $secret }}</strong>
                            </p>
                        </div>
                    </div>
                    
                </div>
              </div>
              <h3>Xác minh</h3>
              <div class="ms-wizard-step">
                <p class="mt-5 pt-1 px-md-4 fs-18 mb-2 text-center">
                    Nhập mã xác minh để hoàn tất thiết lập
                </p>
                
                <div class="mb-2 mt-4 form-group max-400 mx-auto">
                    <label for="one_time_password"></label>
                    <div class="input-group">
                        <input type="text" class="form-control {{($one_time_password = $errors->first('one_time_password'))?'is-invalid':''}}" id="one-time-password-input" placeholder="Nhập Mã 2-FA" required="">
                            <div class="invalid-feedback">
                                {{$one_time_password?$one_time_password:'Vui lòng nhập mã xác thực'}}
                            </div>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>


</div>
@endsection

@section('js')
    <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script>
    <script src="{{asset('assets/app/js/app.2fa.js')}}"></script>
    
@endsection