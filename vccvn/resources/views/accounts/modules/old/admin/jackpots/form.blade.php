@php
$profile = getUser();
$model = isset($jackpot) && $jackpot ? $jackpot : crazy_arr(request()->all());
$txt = $model->id?'Cập nhật':'Thêm';
$order = [0 => 'Giải đặc biệt', 1 => "Giải nhất", 2 => 'Giải nhì']+get_number_options(3, 8);
@endphp
@extends($_layout.'admin')
@section('title', 'Thông Kết quả xổ số')
@section('header_title', 'Kết quả xổ số')

@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} Kết quả xổ số</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.jackpots.addmore')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
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
                            <label for="open_date">Ngày mở thưởng</label>
                            <div class="input-group">
                                <input type="text" name="open_date" id="open_date" value="{{old('open_date', $model->open_date)}}" placeholder="Nhập nhập ngày tháng" class="form-control {{($open_date = $errors->first('open_date'))?'is-invalid':''}} date-picker" data-format="yy-mm-dd" autocomplete="off" required>
                                <div class="input-groupp-append">
                                    <label for="open_date" class="input-group-text"><span class="add-on"><i class="icon-th fa fa-calendar"></i></span></label>
                                    
                                </div>
                                <div class="invalid-feedback">
                                    {{$open_date?$open_date:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>

                        @foreach ($order as $n => $label)
                            
                        <div class="field">
                            <label for="results-{{$n}}">{{is_numeric($label)?'Giài ' . $label : $label}}</label>
                            <div class="input-group">
                                <textarea name="results[{{$n}}]" id="results-{{$n}}" cols="30" rows="2" placeholder="Nhập kết quả giải:
Ngăn cách bằng dấu chấm phẩy" class="form-control {{($results = $errors->first('results.'.$n))?'is-invalid':''}}">{{old('results.'.$n, $model->get('results.'.$n))}}</textarea>
                                <div class="invalid-feedback">
                                    {{$results?$results:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        
                        @endforeach

                        @if ($err = $errors->first('results'))
                            <div class="mt-2 mb-2 text-danger">
                                {{$err}}
                            </div>
                        @endif
                        
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
