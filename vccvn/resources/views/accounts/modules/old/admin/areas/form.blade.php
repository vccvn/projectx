@php
$u = isset($area)?$area:crazy_arr();
$txt = $u->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Thông tin area')
@section('header_title', 'Area')
    
@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} area</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.areas.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{$u->id}}">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Tên Area</label>
                        <div class="input-group">
                            <input type="text" name="name" id="name" value="{{old('name', $u->name)}}" placeholder="Nhập tên / Biệt danh" class="form-control {{($name = $errors->first('name'))?'is-invalid':''}}" required>
                            <div class="invalid-feedback">
                                {{$name?$name:"Không được bỏ trống"}}
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