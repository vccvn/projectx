@php
$profile = getUser();
$model = isset($crawler) && $crawler ? $crawler : crazy_arr();
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
            <h6>{{$txt}} Trình crawler</h6>
        </div>
        <div class="ms-panel-body">
            <form method="POST" action="{{route('admin.crawlers.save')}}" class="smart-form auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
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
                            <label for="url">Đường dẫn</label>
                            <div class="input-group">
                                <input type="text" name="url" id="url" value="{{old('url', $model->url)}}" placeholder="Nhập Đường dẫn" class="form-control {{($url = $errors->first('url'))?'is-invalid':''}}" required>
                                <div class="invalid-feedback">
                                    {{$url?$url:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        {{-- @foreach ($order as $n => $label)
                            
                        <div class="field">
                            <label for="selectors-{{$n}}">{{is_numeric($label)?'Giài ' . $label : $label}}</label>
                            <div class="input-group">
                                <textarea name="selectors[{{$n}}]" id="selectors-{{$n}}" cols="30" rows="2" placeholder="Nhập selector
Nếu giải có nhiều kết quả thì ngăn cách nhau bằng dấu |" class="form-control {{($selectors = $errors->first('selectors'))?'is-invalid':''}}">{{old('selectors.'.$n, $model->get('selectors.'.$n))}}</textarea>
                                <div class="invalid-feedback">
                                    {{$selectors?$selectors:"Không được bỏ trống"}}
                                </div>
                            </div>
                        </div>
                        
                        @endforeach --}}
                        <div class="comment mt-4">
                            <strong>Nguồn RSS: </strong> <a href="https://xskt.com.vn/rss/" target="_blank">https://xskt.com.vn/rss/</a>
                        </div>
        

                <button class="btn btn-primary mt-4 d-block w-100" type="submit">Thêm</button>
                
            </form>
        </div>
    </div>
    </div>
</div>
@endsection
