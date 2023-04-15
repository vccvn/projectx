<?php
// add_css_link('manager/css/deep-select.min.css');
// add_js_src('static/manager/js/deep-select.js');
if($js = $input->hiddenData('js')){
    add_js_src($js);
}
if($css = $input->hiddenData('css')){
    add_css_link($css);
}

$input->type = "package";
$data = $input->getInputData();
$defVal = $input->defVal();


$wrapper = $input->copy();
$wrapper->removeClass(['form-control', 'm-input']);


$old = old($input->name);
$packages = $old??$input->value;
$maxIndex = (is_array($packages) && $packages)?count($packages):0;
$wrapper->data('max-index', $maxIndex);
$nextIndex=0;
$baseName = $input->name;

$pfname = $baseName.'[{$index}]';
$pfid = $baseName.'-{$index}-';
add_custom_css(
    ".package-input .package-list .package-item", 
    [
        'padding' => '15px 15px'
    ]
);

add_custom_css(
    ".package-input .package-list .package-item:nth-child(odd)", 
    [
        'background' => '#fbfbfb'
    ]
);

if($errors->first()){
    add_js_data('crazy_data', 'errors', $errors->all());
}

?>
<div class="package-input package" id="package-{{$input->id}}" data-max-index="{{$maxIndex}}" data-next-index="{{$maxIndex}}">
    <div class="package-list">
        @if ($packages && is_array($packages))
            @foreach ($packages as $index => $item)
            @php
                $pid = str_replace('{$index}', $loop->index, $pfid);
                $pname=str_replace('{$index}', $loop->index, $pfname);
                $data = crazy_arr($item);
                $nsp = $pid = str_replace('-', '.', str_replace('{$index}', $index, $pfid));
                
            @endphp
            <div id="package-item-{{$loop->index}}" class="package-item" data-index="{{$loop->index}}">
                <input type="hidden" name="{{$pname.'[id]'}}" value="{{$data->id}}">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'package_name'))?'has-danger':''}}">
                        <label for="{{$pid.'package_name'}}">Tên gói</label>
                        <input type="text" name="{{$pname}}[package_name]" class="form-control" placeholder="Tên gói" value="{{$data->package_name}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'account_type'))?'has-danger':''}}">
                        <label for="{{$pid.'account_type'}}">Loại gói</label>
                        {!!
                            html_input([
                                'type' => 'select',
                                'name' => $pname . '[account_type]',
                                "class"=>"form-control",
                                'data' => [
                                    'demo' => 'Demo',
                                    'pro' => 'Pro',
                                    'max' => 'Max'
                                ],
                                'value' => $data->account_type
                            ])
                        !!}
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 mb-3 {{($error = $errors->first($nsp.'features'))?'has-danger':''}}">
                        <label for="{{$pid.'features'}}">Đặc điểm / tính năng nổi bật</label>
                        <textarea name="{{$pname}}[features]" class="form-control auto-height" rows="10" placeholder="Đặc điểm / tính năng nổi bật">{{$data->features}}</textarea>
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'storage_limited'))?'has-danger':''}}">
                        <label for="{{$pid.'storage_limited'}}">Dung lượng (MB)</label>
                        <input type="number" name="{{$pname}}[storage_limited]" class="form-control" placeholder="Dung lượng (MB)" min="0" step="1" value="{{$data->storage_limited?$data->storage_limited:500}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'cycle_unit'))?'has-danger':''}}">
                        <label for="{{$pid.'cycle_unit'}}">Chu kỳ</label>
                        <div class="input-group">
                            {!! html_input([
                                'type' => 'radio',
                                'name' => $pname . '[cycle_unit]',
                                'data' => [
                                    'forever' => 'Vĩnh viễn',
                                    'year' => 'Năm',
                                    'month' => 'Tháng'
                                ],
                                'value' => $data->cycle_unit
                            ]) !!}
                        </div>
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'price'))?'has-danger':''}}">
                        <label for="{{$pid.'price'}}">Giá gói</label>
                        <input type="number" name="{{$pname}}[price]" class="form-control" placeholder="Giá gói" min="0" step="1" value="{{$data->price}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'maintenance_fee'))?'has-danger':''}}">
                        <label for="{{$pid.'maintenance_fee'}}">Phí duy trì</label>
                        <input type="number" name="{{$pname}}[maintenance_fee]" class="form-control" placeholder="Phí duy trì" min="0" step="1" value="{{$data->maintenance_fee}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>


                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'need_fee_after_number'))?'has-danger':''}}">
                        <label for="{{$pid.'need_fee_after_number'}}">Bắt đầu tính phí sau: </label>
                        {{-- <input type="number" name="{{$pname}}[need_fee_after_number]" class="form-control" placeholder="Giá gói" min="0" step="1" value="{{$data->need_fee_after_number??0}}"> --}}
                        {!!
                            html_input([
                                'type' => 'number',
                                'name' => $pname . '[need_fee_after_number]',
                                "class"=>"form-control",
                                'default' => 0,
                                'value' => $data->need_fee_after_number,
                                'placeholder' => 'Nhập số ngày hoặc tháng hoặc số năm mà sau đó cần trả phí'
                            ])
                        !!}
                        
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'need_fee_after_unit'))?'has-danger':''}}">
                        <label for="{{$pid.'need_fee_after_unit'}}">Đơn vị thời gian</label>
                        {!!
                            html_input([
                                'type' => 'select',
                                'name' => $pname . '[need_fee_after_unit]',
                                "class"=>"form-control",
                                'data' => [
                                    'day' => 'Ngày',
                                    'month' => 'Tháng',
                                    'year' => 'Năm',
                                    'never' => 'Không bao giờ'
                                ],
                                'default' => 'month',
                                'value' => $data->need_fee_after_unit
                            ])
                        !!}
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    

                    
                </div>
                <div class="btns mb-3">
                    <a 
                        href="javascript:void(0);" 
                        class="btn-delete-package-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air"
                        data-index="{{$loop->index}}" data-toggle="m-tooltip" data-placement="right" data-original-title="Xóa gói">
                        <i class="flaticon-delete-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="buttons mt-2 text-center">
        <a 
            class="btn-add-package-item text-info btn btn-outline-info btn-sm m-btn m-btn--pill m-btn--air"
            href="javascript:void(0);" 
            data-toggle="m-tooltip" 
            data-placement="top" 
            data-original-title="Thêm gói " >
            Thêm gói
        </a>
    </div>
    {{-- <textarea class="ft value d-none">{!! $defVal?json_encode($defVal):'' !!}</textarea> --}}
    <div class="ft template d-none">
        <div id="package-item-{$index}" class="package-item" data-index="{$index}">
            <div class="row">
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'package_name'}}">Tên gói</label>
                    <input type="text" name="{{$pfname}}[package_name]" class="form-control" placeholder="Tên gói">
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'account_type'}}">Loại gói</label>
                    {!!
                        html_input([
                            'type' => 'select',
                            'name' => $pfname . '[account_type]',
                            "class"=>"form-control",
                            'data' => [
                                'demo' => 'Demo',
                                'pro' => 'Pro',
                                'max' => 'Max'
                            ]
                        ])
                    !!}
                </div>
                <div class="col-12 mb-3">
                    <label for="{{$pfid.'features'}}">Đặc điểm / tính năng nổi bật</label>
                    <textarea name="{{$pfname}}[features]" class="form-control auto-height" rows="10" placeholder="Đặc điểm / tính năng nổi bật"></textarea>
                </div>
                <div class="col-12 col-sm-6 col-sm-6 mb-3">
                    <label for="{{$pfid.'storage_limited'}}">Dung lượng (MB)</label>
                    <input type="number" name="{{$pfname}}[storage_limited]" class="form-control" placeholder="Dung lượng (MB)" min="0" step="1" value="500">
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'cycle_unit'}}">Chu kỳ</label>
                    <div class="input-group">
                        {!! html_input([
                            'type' => 'radio',
                            'name' => $pfname . '[cycle_unit]',
                            'data' => [
                                'forever' => 'Vĩnh viễn',
                                'year' => 'Năm',
                                'month' => 'Tháng'
                            ]
                        ]) !!}
                    </div>
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'price'}}">Giá gói</label>
                    <input type="number" name="{{$pfname}}[price]" class="form-control" placeholder="Giá gói" min="0" step="1">
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'maintenance_fee'}}">Phí duy trì</label>
                    <input type="number" name="{{$pfname}}[maintenance_fee]" class="form-control" placeholder="Phí duy trì" min="0" step="1">
                </div>

                
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'need_fee_after_number'}}">Bắt đầu tính phí sau: </label>
                    {{-- <input type="number" name="{{$pname}}[need_fee_after_number]" class="form-control" placeholder="Giá gói" min="0" step="1" value="{{$data->need_fee_after_number??0}}"> --}}
                    {!!
                        html_input([
                            'type' => 'number',
                            'name' => $pfname . '[need_fee_after_number]',
                            "class"=>"form-control",
                            'default' => 0,
                            'value' => 0,
                            'placeholder' => 'Nhập số ngày hoặc tháng hoặc số năm mà sau đó cần trả phí'
                        ])
                    !!}
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'need_fee_after_unit'}}">Đơn vị thời gian</label>
                    {!!
                        html_input([
                            'type' => 'select',
                            'name' => $pfname . '[need_fee_after_unit]',
                            "class"=>"form-control",
                            'data' => [
                                'day' => 'Ngày',
                                'month' => 'Tháng',
                                'year' => 'Năm',
                                'never' => 'Không bao giờ'
                            ],
                            'default' => 'month',
                            'value' => 'month'
                        ])
                    !!}
                </div>
                

            </div>
            <div class="btns mb-3">
                <a 
                    href="javascript:void(0);" 
                    class="btn-delete-package-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air"
                    data-index="{$index}" data-toggle="m-tooltip" data-placement="right" data-original-title="Xóa gói">
                    <i class="flaticon-delete-1"></i>
                </a>
            </div>
        </div>
    </div>
    
</div>