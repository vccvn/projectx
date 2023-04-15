@extends($_layout.'auth')

{{-- khai báo title --}}
@section('title', 'Đăng nhập')

@section('content')

<form class="needs-validation {{$errors->first()?'was-validated':''}}" id="login-form" novalidate="" method="POST" action="{{route('auth.login')}}">
    @csrf
    <h3>Đăng nhập tài khoản</h3>
    <!-- <p>Please enter your email and password to continue</p> -->
    @if ($err = session('error'))
        <div class="alert alert-danger text-center">
            {{$err}}
        </div>
    @endif
        
    <div class="mb-3">
        <label for="email">Tài khoản</label>
        <div class="input-group">
            <input type="text" class="form-control {{$errors->has('username')?'is-invalid':''}}" id="email" name="username" value="{{old('username')}}"
                placeholder="Email hoặc tên đăng nhập" required="">
            <div class="invalid-feedback">Không được bỏ trống</div>
        </div>
    </div>
    <div class="mb-2">
        <label for="password">Mật khẩu</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control  {{$errors->has('password')?'is-invalid':''}}" name="password" id="password"
                placeholder="Nhập mật khẩu" required="">
            <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
        </div>
    </div>
    <div class="form-group">
        <label class="d-block mt-3">
            {{-- <a href="#" class="btn-link" data-toggle="modal"  data-target="#forgot-modal">Quên mật khẩu?</a> --}}
            <a href="{{route('auth.forgot')}}">Quên mật khẩu?</a>
        </label>
    </div>
    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Đăng nhập</button>
    
</form>

@endsection

@section('modal')
    
        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="forgot-modal">
            <div class="modal-dialog modal-dialog-centered modal-min" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button> <i class="flaticon-secure-shield d-block"></i>
                        <h1>Quên mật khẩu?</h1>
                        <p>Nhập email để lấy lại mật khẩu</p>
                        <form method="post" action="{{route('auth.forgot')}}" id="forgot-modal-form">
                            <div class="ms-form-group has-icon">
                                <input type="email" class="form-control" name="email" value="" placeholder="Email"> <i class="material-icons">email</i>
                            </div>
                            <div class="ms-form-group">
                                <div class="input-group">
                                    <div class="g-recaptcha" data-sitekey="{{setting()->googleReCapchaKey}}"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary shadow-none">Đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection