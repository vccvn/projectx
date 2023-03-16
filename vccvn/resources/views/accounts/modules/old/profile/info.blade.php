@php
    $profile = getUser();
    $tab = request()->tab;
    if(!$tab) $tab = session('tab');
    $infoActive = $tab != 'account' ? 'active show': '';
    $accountActive = $infoActive ? '' : 'active show';
@endphp
@extends($_layout.'master')
@section('title', 'Trang cá nhân')
@section('show_sidebar', 1)

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-7 col-lg-8">
        <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-body clearfix">
            
                <ul class="nav nav-tabs tabs-bordered left-tabs nav-justified" role="tablist" aria-orientation="vertical">
                    <li role="presentation"><a href="#profile-info" aria-controls="profile-info" class="{{$infoActive}}" role="tab" data-toggle="tab">Base Info </a></li>
                    <li role="presentation"><a href="#profile-account" aria-controls="profile-account" class="{{$accountActive}}" role="tab" data-toggle="tab"> Account </a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane {{$infoActive}} fade in" id="profile-info">
                        <form method="POST" action="{{route('profile.info')}}" class="auto-validation smart-form {{$errors->has('name') || $errors->has('password')?'was-validated':''}}" novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Biệt danh</label>
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control {{($nameErr = $errors->first('name'))?'is-invalid':''}}" id="name" placeholder="Biệt danh" value="{{old('name', $profile->name)}}" required>
                                        <div class="invalid-feedback">
                                            {{$nameErr?$nameErr:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
            
                                <div class="col-md-12 mb-2">
                                    <label for="current_password1">Mật khẩu hiện tại</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control {{($passwordErr = $errors->first('current_password'))?'is-invalid':''}}" id="current_password1" placeholder="Mật khẩu hiện tại" required>
                                        <div class="invalid-feedback">
                                            {{$passwordErr?$passwordErr:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- <div class="mb-2">
                                <label for="google2fa_secret">Mã 2-FA</label>
                                <div class="input-group">
                                    <input type="password" class="form-control  {{($passwordErr = $errors->first('google2fa_secret'))?'is-invalid':''}}" id="google2fa_secret" placeholder="Nhập Mã 2FA" required="">
                                    <div class="invalid-feedback">{{$passwordErr?$passwordErr:"Vui lòng nhập Mã 2-FA"}}</div>
                                </div>
                            </div> --}}

                            <button class="btn btn-primary mt-4 d-block w-100" type="submit">Cập nhật</button>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade {{$accountActive}}" id="profile-account">
                        <form method="POST" action="{{route('profile.account')}}" class="smart-form auto-validation" novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="username">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control  {{($usernameErr = $errors->first('username'))?'is-invalid':''}}" id="username" placeholder="Username" value="{{old('username', $profile->username)}}"
                                            required>
                                        <div class="invalid-feedback">
                                            {{$usernameErr??'Không dược bỏ trống'}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom08">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control {{($emailErr = $errors->first('email'))?'is-invalid':''}}" id="validationCustom08" placeholder="Email" value="{{old('email', $profile->email)}}"
                                            required>
                                        <div class="invalid-feedback">
                                            {{$emailErr??"Email không hợp lệ"}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="current_password2">Mật khẩu hiện tại</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control {{($passwordErr = $errors->first('current_password'))?'is-invalid':''}}" id="current_password2" placeholder="Mật khẩu hiện tại" required>
                                        <div class="invalid-feedback">
                                            {{$passwordErr?$passwordErr:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>
                                @if ($profile->google2fa_secret)
                                    
                                <div class="mb-2">
                                    <label for="google2fa_secret">Mã 2-FA</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control {{($google2fa_secret = $errors->first('google2fa_secret'))?'is-invalid':''}}" id="google2fa_secret" placeholder="Nhập lại mật khẩu" required="">
                                            {{$google2fa_secret??'Vui lòng nhập mã xác thực'}}
                                    </div>
                                </div>
                                
                                @endif
                            </div>
                            <button class="btn btn-primary mt-4 d-block w-100" type="submit">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-5">
        @include($_template.'profile-card')
    </div>
</div>
    
@endsection