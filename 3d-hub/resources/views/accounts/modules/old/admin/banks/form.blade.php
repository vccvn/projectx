@php
$model = isset($bank)?$bank:crazy_arr();
$txt = $model->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Thông tin Ngân hàng')
@section('header_title', 'Ngân hàng')
    
@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h6>{{$txt}} Ngân hàng</h6>
            </div>
            <div class="ms-panel-body">
                <form method="POST" action="{{route('admin.banks.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{$model->id}}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Tên Ngân hàng</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name" value="{{old('name', $model->name)}}" placeholder="Nhập Ngân hàng" class="form-control {{($name = $errors->first('name'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$name?$name:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="area">Tên Khu vực</label>
                            <div class="input-group">
                                <input type="text" name="area" id="area" value="{{old('area', $model->area)}}" placeholder="Nhập Khu vực" class="form-control {{($area = $errors->first('area'))?'is-invalid':''}}">
                                <div class="invalid-feedback">
                                    {{$area?$area:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="branch">Chi nhánh</label>
                            <div class="input-group">
                                <input type="text" name="branch" id="branch" value="{{old('branch', $model->branch)}}" placeholder="Nhập Ngân hàng" class="form-control {{($branch = $errors->first('branch'))?'is-invalid':''}}">
                                <div class="invalid-feedback">
                                    {{$branch?$branch:"Không được bỏ trống"}}
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