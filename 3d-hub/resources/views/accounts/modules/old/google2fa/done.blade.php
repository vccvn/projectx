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
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Setup 2FA</h6>
            </div>
            <div class="ms-panel-body text-center">
                <p>2 FA của bạn đã được thiết lập!</p>
                <p>Cần thiết lập lại?</p>

                <a class="btn btn-primary mt-1 max-50pc btn-renew-auth-code" href="javascript:void(0)">Tạo lại mã mới</a>

                <div class="row g2fa-app">
                    <div class="col-sm-6 mb-2">
                        <a target="_blank" href="https://apps.apple.com/us/app/google-authenticator/id388497605">
                            <img src="{{asset('images/g2fa-ios.png')}}" alt="">
                        </a>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=vi">
                            <img src="{{asset('images/g2fa-android.png')}}" alt="">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</div>


@endsection

@section('js')
<script src="{{asset('assets/app/js/app.2fa.js')}}"></script>
@endsection