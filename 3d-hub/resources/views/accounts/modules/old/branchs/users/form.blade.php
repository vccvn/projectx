@php
$profile = getUser();
$u = isset($user)?$user:crazy_arr();
$txt = $u->id?'Cập nhật':'Thêm';

@endphp
@extends($_layout.'master')
@section('show_sidebar', 1)
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
            <form method="POST" action="{{route('branchs.users.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
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
                </div>
                <div class="form-row">
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
                    
                </div>
                
                <div class="form-row">
                    @if (is_null($max = setting('max_agency_level')) || $max > $profile->agency_level)
                        
                    <div class="col-md-6 mb-2">
                        <label for="usertype">Loại user</label>
                        <div class="input-group">
                            @include($_theme.'forms.templates.radio', [
                                'name' => 'type',
                                'value' => old('type', $u->type?$u->type:'user'),
                                'data' => [
                                    'user' => 'Người chơi',
                                    'agency' => 'Đại lý'
                                ]
                            ])
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="type" value="user">
                    @endif
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

                @if (!$u->id)
                    @php
                        extract($rates);
                        $oldArea = old('area');
                    @endphp
                    
                                        
                    @if (count($areas))
                        <div class="mt-3 pt-3 ps-border top size-1 primary">
                            <h6 class="mb-3">Tỷ lệ cược</h6>
                            <div class="betting-sub-type-select radio-nav nav-skew nav-sm nav-filled ps-border bottom size-1 prymary" data-ref="rate-areas">
                                @foreach ($areas as $area)
                                    
                                <label for="{{$area->slug}}">
                                    <input type="radio" name="area" id="{{$area->slug}}" value="{{$area->id}}" @if((!$oldArea && $loop->first) || $oldArea == $area->id) checked @endif> <span>{{$area->name}}</span>
                                </label>
            
                                @endforeach
                            </div> 
    
                            <div class="ref-items" data-ref-toggle="rate-areas">
                                
                                @foreach ($areas as $area)
                                    <div class="ref-item" data-ref="rate-areas" data-ref-id="{{$area->id}}">
                                        @if (count($types))
                                            @foreach ($types as $type)
                                                @if (count($type->notTrashedChildren))
                                                    <h6 class="">{{$type->name}}</h6>
                                                    <div class="form-row">
                                                        @foreach ($type->notTrashedChildren as $child)
                                                    
                                                            <div class="col-sm-6 col-md-4">
                                                                <label for="rates-{{$area->id}}-{{$child->id}}">{{$child->name}}</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="rates[{{$area->id}}][{{$child->id}}]" id="rates-{{$area->id}}-{{$child->id}}" min="0" step="0.1" max="9999.9" value="{{old('rates.'.$area->id.'.'.$child->id, (isset($data[$area->id]) && isset($data[$area->id][$child->id]))?$data[$area->id][$child->id]:($child->default_rate?$child->default_rate:1))}}" placeholder="Nhập tỷ lệ" class="form-control {{($rate = $errors->first('rates.'.$area->id.'.'.$child->id))?'is-invalid':''}}" required>
                                                                    <div class="invalid-feedback">
                                                                        {{$rate?$rate:"Không được bỏ trống"}}
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="field">
                                                        <h6><label for="rates-{{$area->id}}-{{$type->id}}">{{$type->name}}</label></h6>
                                                        <div class="input-group">
                                                            <input type="number" name="rates[{{$area->id}}][{{$type->id}}]" id="rates-{{$area->id}}-{{$type->id}}" min="0" step="0.1" max="9999.9" value="{{old('rates.'.$area->id.'.'.$type->id, (isset($data[$area->id]) && isset($data[$area->id][$type->id]))?$data[$area->id][$type->id]:($type->default_rate?$type->default_rate:1))}}" placeholder="Nhập tỷ lệ" class="form-control {{($rate = $errors->first('rates.'.$area->id.'.'.$type->id))?'is-invalid':''}}" required>
                                                            <div class="invalid-feedback">
                                                                {{$rate?$rate:"Không được bỏ trống"}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    
                @endif
                                
                <div class="text-center mt-3 pt-3 ps-border top size-1 primary">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="reset" class="btn btn-secondary">Hủy</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection