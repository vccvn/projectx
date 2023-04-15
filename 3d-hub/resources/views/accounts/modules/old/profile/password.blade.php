@php
    $profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Thay đổi mật khẩu')
@section('show_sidebar', 1)

@section('content')



<div class="row">
    <div class="col-xl-6 col-md-10 col-lg-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thay đổi mật khẩu</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('profile.password')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="form-control {{($current_password = $errors->first('current_password'))?'is-invalid':''}}" id="current_password"
                                    placeholder="Mật khẩu hiện tại" required>
                                <div class="invalid-feedback">
                                    {{$current_password?$current_password:"Vui lòng nhập Mật khẩu hiện tại"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="password">Mật khẩu mới</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control {{($password = $errors->first('password'))?'is-invalid':''}}" id="password"
                                    placeholder="Mật khẩu mới" required>
                                <div class="invalid-feedback">
                                    {{$password?$password:"Vui lòng nhập Mật khẩu hiện tại"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="password_confirmation">Nhập lại mật khẩu</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control {{($password_confirmation = $errors->first('password_confirmation'))?'is-invalid':''}}" id="password_confirmation"
                                    placeholder="Nhập lại mật khẩu" required>
                                <div class="invalid-feedback">
                                    
                                    {{$password_confirmation?$password_confirmation:"Vui lòng Nhập lại mật khẩu."}}
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