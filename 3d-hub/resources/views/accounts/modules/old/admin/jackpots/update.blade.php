@php
$profile = getUser();
$model = isset($jackpot) && $jackpot ? $jackpot : crazy_arr(request()->all());
$txt = $model->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Kết quả xổ số')
@section('header_title', 'Kết quả xổ số')

@section('content')

<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} Kết quả xổ số</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.jackpots.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{$model->id}}">

                        <div class="field">
                            <label for="area_id">Khu vực</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'area_id',
                                    'id' => 'area_id',
                                    'class' => 'form-control ' . (($area_id = $errors->first('area_id'))?'is-invalid':''),
                                    'value' => old('area_id', $model->area_id),
                                    'data' => get_area_options([])
                                ]) !!}
                                <div class="invalid-feedback">
                                    {{$area_id?$area_id:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="jackpot_order">Giải tham chiếu</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'order',
                                    'id' => 'jackpot_order',
                                    'class' => 'form-control ' . (($order = $errors->first('order'))?'is-invalid':''),
                                    'value' => old('order', $model->order?$model->order:"all"),
                                    'data' => [0 => 'Giải đặc biệt', 1 => "Giải nhất"]+get_number_options(2, 8)
                                ]) !!}
                                <div class="invalid-feedback">
                                    {{$order?$order:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="open_date">Ngày mở thưởng</label>
                            <div class="input-group">
                                <input type="text" name="open_date" id="open_date" value="{{old('open_date', $model->open_date)}}" placeholder="Nhập nhập ngày tháng" class="form-control {{($open_date = $errors->first('open_date'))?'is-invalid':''}} date-picker" data-format="yy-mm-dd" autocomplete="off" required>
                                <div class="input-groupp-append">
                                    <span class="input-group-text"><span class="add-on"><i class="icon-th fa fa-calendar"></i></span></span>
                                    
                                </div>
                                <div class="invalid-feedback">
                                    {{$open_date?$open_date:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="number">Các kết quả</label>
                            <div class="input-group">
                                <textarea name="number" id="number" cols="30" rows="4" placeholder="Nhập kết quả giải:
Ngăn cách bằng dấu chấm phẩy 
hoặc xuống dòng" class="form-control {{($number = $errors->first('number'))?'is-invalid':''}}">{{old('number', $model->number)}}</textarea>
                                <div class="invalid-feedback">
                                    {{$number?$number:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="comment mt-4">
                            <strong>Chú thích: </strong> Các kết quả ngăn cách nhau bằng dấu chấm phẩy (;)
                        </div>
        

                <button class="btn btn-primary mt-4 d-block w-100" type="submit">Thêm</button>
                
            </form>
        </div>
    </div>
    </div>
</div>
@endsection
