@php
$profile = getUser();
$model = isset($lotto) && $lotto ? $lotto : crazy_arr();
$txt = $model->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Kết quả lotto')
@section('header_title', 'Kết quả lotto')

@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} Kết quả lotto</h6>
        </div>
        <div class="ms-panel-body">
            <form 
                method="POST" 
                action="{{route('admin.lottos.save')}}" 
                class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" 
                novalidate>
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
                            'data' => $areaOptions
                        ]) !!}
                        <div class="invalid-feedback">
                            {{$area_id?$area_id:"Không được bỏ trống"}}
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label for="betting_type_id">Loại cược</label>
                    <div class="input-group">
                        {!! html_input([
                            'type' => 'select',
                            'name' => 'betting_type_id',
                            'id' => 'betting_type_id',
                            'class' => 'form-control ' . (($betting_type_id = $errors->first('betting_type_id'))?'is-invalid':''),
                            'value' => old('betting_type_id', $model->betting_type_id?$model->betting_type_id:"all"),
                            'data' => $typeOptions
                        ]) !!}
                        <div class="invalid-feedback">
                            {{$betting_type_id?$betting_type_id:"Không được bỏ trống"}}
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
                    <label for="numbers">Các kết quả</label>
                    <div class="input-group">
                        <textarea name="numbers" id="numbers" cols="30" rows="4" placeholder="Nhập kết quả giải:
Ngăn cách bằng dấu chấm phẩy 
hoặc xuống dòng" class="form-control {{($numbers = $errors->first('numbers'))?'is-invalid':''}}">{{old('numbers', $model->getNumberStr())}}</textarea>
                        <div class="invalid-feedback">
                            {{$numbers?$numbers:"Không được bỏ trống"}}
                        </div>
                    </div>
                    <div>
                        <a href="#" class="btn-import px-2 py-1">Nhận dữ liệu từ kết quả xổ số</a>
                    </div>
                    
                </div>
                
                <div class="comment mt-4">
                    <strong>Chú thích: </strong> Các kết quả ngăn cách nhau bằng dấu chấm phẩy (;)
                </div>
                <button type="submit" class="btn btn-primary mt-4 d-block w-100">Thêm</button>
        
            </form>
        </div>
    </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function(){
            $('.btn-import').click(function(e){
                e.preventDefault();
                var data = {
                    area_id: $('#area_id').val(),
                    betting_type_id: $('#betting_type_id').val(),
                    open_date: $('#open_date').val()
                };
                showLoading(2000);
                App.api.get("{{route('admin.lottos.betting-results')}}", data)
                .then(function(res){
                    if(res.status){
                        if(res.data.length){
                            $('#numbers').val(res.data.join("; "));
                        }
                    }else{
                        App.Swal.warning(res.message)
                    }
                })
                .catch(function(error){
                    console.log(error);
                    App.Swal.warning("Lỗi không xác định!")
                })
            })
        })
    </script>
@endsection