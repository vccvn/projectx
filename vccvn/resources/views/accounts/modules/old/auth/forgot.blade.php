@extends($_layout.'auth')

{{-- khai báo title --}}
@section('title', 'Quên mật khẩu')

@section('content')

<form method="POST" action="{{route('auth.forgot')}}" class="needs-validation {{$errors->first()?'was-validated':''}}" id="forgot-form" novalidate="">
    @csrf
    <h3>Quên mật khẩu</h3>
    <p>Nhập email cài lại mật khẩu</p>
    <!-- <p>Please enter your email and password to continue</p> -->
    <div class="mb-3">
        <label for="email">Email</label>
        @if ($err = session('error'))
            <div class="alert alert-danger text-center">
                {{$err}}
            </div>
        @endif
        <div class="input-group">
            <input type="text" class="form-control {{$errors->has('email')?'is-invalid':''}}" id="email" name="email" value="{{old('email')}}" placeholder="Email" required="">
            <div class="invalid-feedback">{{$errors->first('email')?$errors->first('email'):'Không được bỏ trống'}}</div>
        </div>
    </div>
    <div class="mb-2">
        <label for="password_confirmation">Anti-spam</label>
        <div class="input-group">
            <div class="g-recaptcha" data-sitekey="{{setting()->googleReCapchaKey}}"></div>
            <div class="feedback text-danger">{{$errors->first('g-recaptcha-response')}}</div>
        </div>
    </div>
    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Tiếp tục</button>
    <p class="mb-0 mt-3 text-center">Bạn nhớ ra mật khẩu? <a class="btn-link" href="{{route('auth.login')}}">Đăng nhập</a> 
</form>

@endsection

@section('js')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection