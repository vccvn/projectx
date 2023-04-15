@php
$profile = getUser();
$model = isset($type)?$type:crazy_arr();
$txt = $model->id?'Cập nhật':'Thêm';
@endphp
@extends($_layout.'admin')
@section('title', 'Thông tin loại cược')
@section('header_title', 'Loại cược')

@section('content')


<div class="row">
    <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">
        <div class="ms-panel">
        <div class="ms-panel-header">
            <h6>{{$txt}} loại cược</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.bettings.types.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{$model->id}}">
                <div class="form-row">

                    <div class="col-md-6">
                        <div class="field">
                            <label for="name">Tên</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name" value="{{old('name', $model->name)}}" placeholder="Nhập tên" class="form-control {{($name = $errors->first('name'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$name?$name:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="parent_id">Loại cha</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'parent_id',
                                    'id' => 'parent_id',
                                    'class' => 'form-control ' . (($parent_id = $errors->first('parent_id'))?'is-invalid':''),
                                    'value' => old('parent_id', $model->parent_id),
                                    'data' => get_betting_type_parent_options($model->id, 'Không')
                                ]) !!}
                                <div class="invalid-feedback">
                                    {{$parent_id?$parent_id:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="jackpot_order">Giải tham chiếu</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'jackpot_order',
                                    'id' => 'jackpot_order',
                                    'class' => 'form-control ' . (($jackpot_order = $errors->first('jackpot_order'))?'is-invalid':''),
                                    'value' => old('jackpot_order', $model->jackpot_order?$model->jackpot_order:"all"),
                                    'data' => ['all' => 'Tất cả', 0 => 'Giải đặc biệt', 1 => "Giải nhất"]+get_number_options(2, 8)
                                ]) !!}
                                <div class="invalid-feedback">
                                    {{$jackpot_order?$jackpot_order:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="description">Mô tả</label>
                            <div class="input-group">
                                <textarea name="description" id="description" cols="30" rows="8" class="form-control {{($description = $errors->first('description'))?'is-invalid':''}}">{{old('description', $model->description)}}</textarea>
                                <div class="invalid-feedback">
                                    {{$description?$description:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        {{-- <div class="field">
                            <label for="crop_length">Độ dài chuỗi gốc</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'crop_length',
                                    'id' => 'crop_length',
                                    'class' => 'form-control ' . (($crop_length = $errors->first('crop_length'))?'is-invalid':''),
                                    'default' => old('crop_length', $model->crop_length?$model->crop_length:2),
                                    'data' => get_number_options(1, 7)
                                ]) !!}
                                
                                <div class="invalid-feedback">
                                    {{$crop_length?$crop_length:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div> --}}
                        <div class="field">
                            <label for="number_length">Số chữ số</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'number_length',
                                    'id' => 'number_length',
                                    'class' => 'form-control ' . (($number_length = $errors->first('number_length'))?'is-invalid':''),
                                    'default' => old('number_length', $model->number_length?$model->number_length:2),
                                    'data' => get_number_options(1, 4)
                                ]) !!}
                                
                                <div class="invalid-feedback">
                                    {{$number_length?$number_length:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <label for="number_position">Vị trí lấy kết quả</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'number_position',
                                    'id' => 'number_position',
                                    'class' => 'form-control ' . (($number_position = $errors->first('number_position'))?'is-invalid':''),
                                    'default' => old('number_position', $model->number_position),
                                    'data' => get_number_options(0, 7)
                                ]) !!}
                                
                                <div class="invalid-feedback">
                                    {{$number_position?$number_position:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <label for="number_combine">Tổ hợp kết quả</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'number_combine',
                                    'id' => 'number_combine',
                                    'class' => 'form-control ' . (($number_combine = $errors->first('number_combine'))?'is-invalid':''),
                                    'default' => old('number_combine', $model->number_combine?$model->number_combine:1),
                                    'data' => get_number_options(0, 5)
                                ]) !!}
                                
                                <div class="invalid-feedback">
                                    {{$number_combine?$number_combine:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>

                        
                        <div class="field">
                            <label for="default_rate">Tỉ lệ mặc định</label>
                            <div class="input-group">
                                <input type="number" name="default_rate" id="default_rate" min="0" step="0.1" max="9999.9" value="{{old('default_rate', $model->default_rate?$model->default_rate:1)}}" placeholder="Nhập tỷ lệ" class="form-control {{($default_rate = $errors->first('default_rate'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$default_rate?$default_rate:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        

                        <div class="field">
                            <ul class="ms-list d-flex">
                                <li class="ms-list-item pl-0">
                                  <label>
                                    Cộng đòn điểm
                                  </label> 
                                </li>
                                <li class="ms-list-item">
                                  <label class="ms-switch">
                                    <input type="checkbox" name="incremental" id="incremental" @if(old('incremental', $model->incremental)) checked @endif> <span class="ms-switch-slider round"></span>
                                  </label> <label for="incremental"></label>
                                </li>
                              </ul>
                        </div>
                        
                    </div>



                </div>

                <button class="btn btn-primary mt-4 d-block w-100" type="submit">Lưu</button>
                
                <div class="comment mt-4">
                    <strong>Chú thích: </strong> Vị trí lấy kết quả tính từ bên phải sang
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection