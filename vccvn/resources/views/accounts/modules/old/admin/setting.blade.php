@php
    $profile = getUser();
    if(!$setting) $setting = crazy_arr([]);
@endphp
@extends($_layout.'admin')
@section('title', 'Thiết lập hệ thống')
@section('header_title', 'Thiết lập hệ thống')

@section('content')



<div class="row">
    <div class=" col-md-10 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thiết lập hệ thống</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('admin.setting.system')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <h6>Thời gian</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="betting_lock_time">Thời gian khóa chơi</label>
                                    <div class="input-group">
                                        <input type="text" name="betting_lock_time" id="betting_lock_time" class="form-control {{($betting_lock_time = $errors->first('betting_lock_time'))?'is-invalid':''}} datetime-picker" data-format="HH:mm:ss"
                                            placeholder="Thời gian khóa chơi" value="{{old('betting_lock_time', $setting->betting_lock_time)}}" required>
                                        <div class="input-groupp-append">
                                            <label for="betting_lock_time" class="input-group-text"><span class="add-on"><i class="icon-th fa fa-clock"></i></span></label>
                                            
                                        </div>
                                        <div class="invalid-feedback">
                                            {{$betting_lock_time?$betting_lock_time:"Không được bỏ trống"}}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="betting_lock_time">Thời gian khóa chuyển bảng</label>
                                    <div class="input-group">
                                        <input type="text" name="transfer_lock_time" id="transfer_lock_time" class="form-control {{($transfer_lock_time = $errors->first('transfer_lock_time'))?'is-invalid':''}} datetime-picker" data-format="HH:mm:ss"
                                            placeholder="Thời gian khóa chơi" value="{{old('transfer_lock_time', $setting->transfer_lock_time)}}" required>
                                        <div class="input-groupp-append">
                                            <label for="transfer_lock_time" class="input-group-text"><span class="add-on"><i class="icon-th fa fa-clock"></i></span></label>
                                            
                                        </div>
                                        <div class="invalid-feedback">
                                            {{$transfer_lock_time?$transfer_lock_time:"Không được bỏ trống"}}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="report_time">Thời gian xuất báo cáo</label>
                                    <div class="input-group">
                                        <input type="text" name="report_time" id="report_time" class="form-control {{($report_time = $errors->first('report_time'))?'is-invalid':''}} datetime-picker" data-format="HH:mm:ss"
                                            placeholder="Thời gian khóa chơi" value="{{old('report_time', $setting->report_time)}}" required>
                                        <div class="input-groupp-append">
                                            <label for="report_time" class="input-group-text"><span class="add-on"><i class="icon-th fa fa-clock"></i></span></label>
                                            
                                        </div>
                                        <div class="invalid-feedback">
                                            {{$report_time?$report_time:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="max_trashed_days_ago">Số ngày vẫn hiển thị sau khi xóa của một số mục</label>
                                    <div class="input-group">
                                        <input type="number" name="max_trashed_days_ago" id="max_trashed_days_ago" min="0" step="1" class="form-control {{($max_trashed_days_ago = $errors->first('max_trashed_days_ago'))?'is-invalid':''}}" data-format="HH:mm:ss"
                                            placeholder="Thời gian khóa chơi" value="{{old('max_trashed_days_ago', $setting->max_trashed_days_ago)}}" required>
                                        <div class="input-groupp-append">
                                            <span class="input-group-text"><span class="add-on"><i class="icon-th fa fa-clock"></i></span></span>
                                            
                                        </div>
                                        <div class="invalid-feedback">
                                            {{$max_trashed_days_ago?$max_trashed_days_ago:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>                                

                            <h6 class="mt-3">Thiết lập Bot</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="crawl_time">Thời gian Chạy crawl và Bot</label>
                                    <div class="input-group">
                                        <input type="text" name="crawl_time" id="crawl_time" class="form-control {{($crawl_time = $errors->first('crawl_time'))?'is-invalid':''}} datetime-picker" data-format="HH:mm:ss"
                                            placeholder="Thời gian khóa chơi" value="{{old('crawl_time', $setting->crawl_time)}}" required>
                                        <div class="input-groupp-append">
                                            <label for="crawl_time" class="input-group-text"><span class="add-on"><i class="icon-th fa fa-clock"></i></span></label>
                                            
                                        </div>
                                        <div class="invalid-feedback">
                                            {{$crawl_time?$crawl_time:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="bot_type">Tùy chọn bot</label>
                                    <div class="input-group">
                                        {!!
                                            html_input([
                                                'type' => 'select',
                                                'name' => 'bot_type',
                                                'class' => 'form-control '.(($bot_type = $errors->first('bot_type'))?'is-invalid':''),
                                                'data' => [
                                                    '1' => 'Thao tác bằng tay',
                                                    '2' => 'tự động chốt xổ',
                                                    '3' => 'Tự động Chốt sổ và trả điểm'
                                                ],
                                                'default' => old('bot_type', $setting->bot_type)
                                            ])
                                        !!}
                                        <div class="invalid-feedback">
                                            {{$bot_type?$bot_type:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h6>Level đại lý và Email</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="max_agency_level">Level tối đa cho các nhánh</label>
                                    <div class="input-group">
                                        <input type="number" min="1" max="15" step="1" name="max_agency_level" class="form-control {{($max_agency_level = $errors->first('max_agency_level'))?'is-invalid':''}}" id="agency_level"
                                            placeholder="Level tối đa cho các nhánh" value="{{old('max_agency_level', $setting->max_agency_level)}}" required>
                                        <div class="invalid-feedback">
                                            {{$max_agency_level?$max_agency_level:"Vui lòng nhập Level tối đa cho các nhánh"}}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="email">Email để gửi thông báo</label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control {{($email = $errors->first('email'))?'is-invalid':''}}" id="email"
                                            placeholder="Email để gửi thông báo" value="{{old('email', $setting->email)}}" required>
                                        <div class="invalid-feedback">
                                            {{$email?$email:"Vui lòng nhập email"}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email_password">Mật khẩu đăng nhập email</label>
                                    <div class="input-group">
                                        <input type="password" name="email_password" class="form-control {{($email_password = $errors->first('email_password'))?'is-invalid':''}}" id="email_password"
                                            placeholder="Mật khẩu đăng nhập email" value="{{old('email_password', $setting->email_password)}}" required>
                                        <div class="invalid-feedback">
                                            {{$email_password?$email_password:"Vui lòng nhập Mật khẩu đăng nhập email."}}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>


                            <h6 class="mt-3">Thiết lập khác</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="recapcha_secret_key">ReCapcha Secret Key</label>
                                    <div class="input-group">
                                        <input type="text" name="recapcha_secret_key" class="form-control {{($recapcha_secret_key = $errors->first('recapcha_secret_key'))?'is-invalid':''}}" id="agency_level"
                                            placeholder="ReCapcha Secret Key" value="{{old('recapcha_secret_key', $setting->recapcha_secret_key)}}">
                                        <div class="invalid-feedback">
                                            {{$recapcha_secret_key?$recapcha_secret_key:"Vui lòng nhập ReCapcha Secret Key"}}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="recapcha_site_key">ReCapcha Site Key</label>
                                    <div class="input-group">
                                        <input type="email" name="recapcha_site_key" class="form-control {{($recapcha_site_key = $errors->first('recapcha_site_key'))?'is-invalid':''}}" id="recapcha_site_key"
                                            placeholder="ReCapcha Site Key" value="{{old('recapcha_site_key', $setting->recapcha_site_key)}}">
                                        <div class="invalid-feedback">
                                            {{$recapcha_site_key?$recapcha_site_key:"Vui lòng nhập ReCapcha Site Key"}}
                                        </div>
                                    </div>
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