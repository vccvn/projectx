@extends($_layout.'auth')

{{-- khai báo title --}}
@section('title', 'Tạo mật khẩu')

@section('content')

<form method="POST" action="{{route('auth.new-password')}}" class="needs-validation show-process {{$errors->first()?'was-validated':''}}" id="reset-form" novalidate="">
    @csrf
    <h3>Tạo mật khẩu mới</h3>
    <!-- <p>Please enter your email and password to continue</p> -->
    @if ($err = session('error'))
        <div class="alert alert-danger text-center">
            {{$err}}
        </div>
    @endif
        
    <div class="mb-2">
        <label for="password">Mật khẩu mới</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control  {{$errors->has('password')?'is-invalid':''}}" id="password"
                placeholder="Nhập mật khẩu" required="">
            <div class="invalid-feedback">{{$errors->first('password')?$errors->first('password'):'Vui lòng nhập mật khẩu trên 6 ký tự'}}</div>
        </div>
    </div>
    <div class="mb-2">
        <label for="password_confirmation">Mật khẩu Xác nhận </label>
        <div class="input-group">
            <input type="password" name="password_confirmation" class="form-control  {{$errors->has('password_confirmation')?'is-invalid':''}}" id="password_confirmation"
                placeholder="Nhập mật khẩu xác nhận" required="">
            <div class="invalid-feedback">{{$errors->first('password_confirmation')?$errors->first('password_confirmation'):'Vui lòng nhập mật khẩu trên xác nhận'}}</div>
        </div>
    </div>
    <button class="btn btn-primary mt-4 d-block w-100" type="submit">Tạo mật khẩu</button>
    <div class="form-group">
        <label class="d-block mt-3 text-center">
            <a href="{{route('auth.login')}}" class="btn-link">Đăng nhập</a>
        </label>
    </div>
    
</form>

@endsection