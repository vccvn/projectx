
@php
$profile = getUser();
$u = isset($user)?$user:crazy_arr();
$txt = $u->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Thông tin người dùng')
@section('header_title', 'Người dùng')

@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} người dùng</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.users.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{$u->id}}">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Tên</label>
                        <div class="input-group">
                            <input type="text" name="name" id="name" value="{{old('name', $u->name)}}" placeholder="Nhập tên / Biệt danh" class="form-control {{($name = $errors->first('name'))?'is-invalid':''}}" required>
                            <div class="invalid-feedback">
                                {{$name?$name:"Không được bỏ trống"}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <input type="email" name="email" id="email" value="{{old('email', $u->email)}}" placeholder="Nhập email" class="form-control {{($email = $errors->first('email'))?'is-invalid':''}}" required>
                            <div class="invalid-feedback">
                                {{$email?$email:"Không được bỏ trống"}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="username">Tên đăng nhập</label>
                        <div class="input-group">
                            <input type="text" name="username" id="username" value="{{old('username', $u->username)}}" placeholder="Nhập Tên đăng nhập" class="form-control {{($username = $errors->first('username'))?'is-invalid':''}}" required>
                            <div class="invalid-feedback">
                                {{$username?$username:"Không được bỏ trống"}}
                            </div>
                        </div>
                    </div>
                        
                    @if (!$u->id)
                        
                    <div class="col-md-6 mb-2">
                        <label for="password">Mật khẩu {{$u->id?'(Bỏ qua nếu không muốn thay đổi)': ''}}</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" value="" placeholder="Nhập mật khẩu" class="form-control {{($password = $errors->first('password'))?'is-invalid':''}}" {{$u->id?'': 'required'}}>
                            <div class="invalid-feedback">
                                {{$password?$password:"Không được bỏ trống"}}
                            </div>
                        </div>
                    </div>
                    
                    @endif
                    <div class="col-md-6 mb-2">
                        <label for="usertype">Loại user</label>
                        <div class="input-group">
                            @include($_theme.'forms.templates.radio', [
                                'name' => 'type',
                                'value' => old('type', $u->type?$u->type:'user'),
                                'data' => [
                                    'user' => 'Người chơi',
                                    'agency' => 'Đại lý cấp ' . ($profile->agency_level+1),
                                    'admin' => 'Admin'
                                ]
                            ])
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="status">Trạng thái</label>
                        <div class="input-group">
                            {!! html_input([
                                'type' => 'select',
                                'name' => 'status',
                                'id' => 'status',
                                'class' => 'form-control ' . (($status = $errors->first('status'))?'is-invalid':''),
                                'default' => old('status', $u->status),
                                'data' => [
                                    '200' => 'Đã kích hoạt',
                                    '0' => 'Chờ kích hoạt',
                                    '-1' => 'Khóa'
                                ]
                            ]) !!}
                            <div class="invalid-feedback">
                                {{$status?$status:"Không được bỏ trống"}}
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