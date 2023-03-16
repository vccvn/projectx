@php
    $profile = getUser();
    extract($rates);
    $oldArea = old('area');

@endphp
@extends($_layout.'master')
@section('title', 'Thiết lập nhánh')
@section('show_sidebar', 1)
@section('header_title', 'Nhánh')


@section('content')
<div class="row">


    <div class="col-md-8">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>Thiết lập nhánh</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('branchs.setting')}}" class="smart-form auto-validation" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="branch-register-url">Url Đăng Ký</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="branch-register-url" placeholder="Register Url" value="{{route('auth.register', ['secret'=>$setting->secret_key])}}" readonly>
                                <div class="input-group-append"><a href="#" class="btn btn-primary btn-copy-token">Copy</a></div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="lowest_point">Điểm sàn</label>
                            <div class="input-group">
                                <input type="number" min="0" step="1" name="lowest_point" id="lowest_point" value="{{old('lowest_point', $setting->lowest_point)}}" placeholder="Nhập tên / Biệt danh" class="form-control {{($lowest_point = $errors->first('lowest_point'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$lowest_point?$lowest_point:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="hightest_point">Điểm trần</label>
                            <div class="input-group">
                                <input type="number" min="0" step="1" name="hightest_point" id="hightest_point" value="{{old('hightest_point', $setting->hightest_point)}}" placeholder="Nhập hightest_point" class="form-control {{($hightest_point = $errors->first('hightest_point'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$hightest_point?$hightest_point:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="hold_point">Điểm Giữ lại</label>
                            <div class="input-group">
                                <input type="number" min="0" step="1" name="hold_point" id="hold_point" value="{{old('hold_point', $setting->hold_point)}}" placeholder="Nhập hold_point" class="form-control {{($hold_point = $errors->first('hold_point'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$hold_point?$hold_point:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    @if (count($areas))
                        <div class="mt-3 pt-3 ps-border top size-1 primary">
                            <div class="betting-sub-type-select radio-nav nav-skew nav-sm nav-filled ps-border bottom size-1 prymary" data-ref="rate-areas">
                                @foreach ($areas as $area)
                                    
                                <label for="{{$area->slug}}">
                                    <input type="radio" name="area" id="{{$area->slug}}" value="{{$area->id}}" @if((!$oldArea && $loop->first) || $oldArea == $area->id) checked @endif> <span>{{$area->name}}</span>
                                </label>
            
                                @endforeach
                            </div> 
    
                            <div class="ref-items" data-ref-toggle="rate-areas">
                                
                                @foreach ($areas as $area)
                                    <div class="ref-item" data-ref-id="{{$area->id}}" data-ref="rate-areas">
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

                    

                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="reset" class="btn btn-secondary">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include($_template.'profile-card')
    </div>
</div>

@endsection

@section('js')
    <script>
        window.branchInit = function(){
            App.branch.init({
                urls:{
                    refresh: "{{route('branchs.refresh-token')}}"
                }
            });
        };
    </script>
        <script src="{{asset('assets/app/js/app.branch.js')}}"></script>
@endsection