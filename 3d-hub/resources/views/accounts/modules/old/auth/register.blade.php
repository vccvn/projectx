@extends($_layout.'auth')

{{-- khai báo title --}}
@section('title', 'Đăng ký')

@section('content')

<form method="POST" action="{{route('auth.register')}}" class="needs-validation {{$errors->first()?'was-validated':''}}" id="forgot-form" novalidate="">
    @csrf
    <h3>Đăng ký</h3>
    <p>Đăng ký tài khoản để kiếm tiền online</p>
    <!-- <p>Please enter your email and password to continue</p> -->
    @if ($err = session('error'))
        <div class="alert alert-danger text-center">
            {{$err}}
        </div>
    @endif
    <div class="mb-3">
        <label for="name">Tên</label>
        <div class="input-group">
            <input type="text" name="name" id="name" value="{{old('name')}}" placeholder="Nhập tên / Biệt danh" class="form-control {{($name = $errors->first('name'))?'is-invalid':''}}" required>
            <div class="invalid-feedback">
                {{$name?$name:"Không được bỏ trống"}}
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="email">Email</label>
        <div class="input-group">
            <input type="email" name="email" id="email" value="{{old('email')}}" placeholder="Nhập email" class="form-control {{($email = $errors->first('email'))?'is-invalid':''}}" required>
            <div class="invalid-feedback">
                {{$email?$email:"Không được bỏ trống"}}
            </div>
        </div>
    </div>
    <div class="mb-2">
        <label for="password">Mật khẩu</label>
        <div class="input-group">
            <input type="password" name="password" id="password" value="" placeholder="Nhập mật khẩu" class="form-control {{($password = $errors->first('password'))?'is-invalid':''}}" required>
            <div class="invalid-feedback">
                {{$password?$password:"Không được bỏ trống"}}
            </div>
        </div>
    </div>
    
    <div class="mb-2">
        <label for="">Anti-spam</label>
        <div class="input-group">
            <div class="g-recaptcha" data-sitekey="{{setting()->googleReCapchaKey}}"></div>
            <div class="feedback text-danger">{{$errors->first('g-recaptcha-response')}}</div>
        </div>
    </div>
    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Tiếp tục</button>
    <p class="mb-0 mt-3 text-center">Đã có tài khoản? <a class="btn-link" href="{{route('auth.login')}}">Đăng nhập</a> 
</form>

@endsection

@section('js')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection