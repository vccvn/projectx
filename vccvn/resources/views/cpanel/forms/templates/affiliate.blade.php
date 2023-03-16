<?php
// add_css_link('static/manager/css/deep-select.min.css');
// add_js_src('static/manager/js/deep-select.js');
if($js = $input->hiddenData('js')){
    add_js_src($js);
}
if($css = $input->hiddenData('css')){
    add_css_link($css);
}

$input->type = "affiliate";
$data = $input->getInputData();
$defVal = $input->defVal();

$wrapper = $input->copy();
$wrapper->removeClass(['form-control', 'm-input']);


$old = old($input->name);
$affiliates = $old??$input->value;
$maxIndex = (is_array($affiliates) && $affiliates)?count($affiliates):0;
$wrapper->data('max-index', $maxIndex);
$nextIndex=0;
$baseName = $input->name;

$pfname = $baseName.'[{$index}]';
$pfid = $baseName.'-{$index}-';
add_custom_css(
    ".affiliate-input .affiliate-list .affiliate-item", 
    [
        'padding' => '15px 15px'
    ]
);

add_custom_css(
    ".affiliate-input .affiliate-list .affiliate-item:nth-child(odd)", 
    [
        'background' => '#fbfbfb'
    ]
);

if($errors->first()){
    add_js_data('crazy_data', 'errors', $errors->all());
}

?>
<div class="affiliate-input affiliate" id="affiliate-{{$input->id}}" data-max-index="{{$maxIndex}}" data-next-index="{{$maxIndex}}">
    <div class="affiliate-list">
        @if ($affiliates && is_array($affiliates))
            @foreach ($affiliates as $index => $item)
            @php
                $pid = str_replace('{$index}', $loop->index, $pfid);
                $pname=str_replace('{$index}', $loop->index, $pfname);
                $data = crazy_arr($item);
                $nsp = $pid = str_replace('-', '.', str_replace('{$index}', $index, $pfid));
                
            @endphp
            <div id="affiliate-item-{{$loop->index}}" class="affiliate-item" data-index="{{$loop->index}}">
                <input type="hidden" name="{{$pname.'[id]'}}" value="{{$data->id}}">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'affiliate_id'))?'has-danger':''}}">
                        <label for="{{$pid.'affiliate_id'}}">Trang Affiliate</label>
                        {!!
                            html_input([
                                'type' => 'select',
                                'name' => $pname . '[affiliate_id]',
                                "class"=>"form-control",
                                'data' => get_affiliate_options([], "Chọn một"),
                                'value' => $data->affiliate_id
                            ])
                        !!}
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-3 {{($error = $errors->first($nsp.'price'))?'has-danger':''}}">
                        <label for="{{$pid.'price'}}">Giá</label>
                        <input type="number" name="{{$pname}}[price]" class="form-control" placeholder="Giá gói" min="0" step="1" value="{{$data->price}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    <div class="col-12 mb-3 {{($error = $errors->first($nsp.'url'))?'has-danger':''}}">
                        <label for="{{$pid.'url'}}">Đường dẫn</label>
                        <input type="text" name="{{$pname}}[url]" class="form-control" placeholder="Đường dẫn" value="{{$data->url}}">
                        @if ($error)
                            <div class="form-control-feedback input-message-alert">{{$error}}</div>
                        @endif
                    </div>
                    
                </div>
                <div class="btns mb-3">
                    <a 
                        href="javascript:void(0);" 
                        class="btn-delete-affiliate-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air"
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
            class="btn-add-affiliate-item text-info btn btn-outline-info btn-sm m-btn m-btn--pill m-btn--air"
            href="javascript:void(0);" 
            data-toggle="m-tooltip" 
            data-placement="top" 
            data-original-title="Thêm Liên kết sản phẩm " >
            Thêm liên kết
        </a>
    </div>
    {{-- <textarea class="ft value d-none">{!! $defVal?json_encode($defVal):'' !!}</textarea> --}}
    <div class="ft template d-none">
        <div id="affiliate-item-{$index}" class="affiliate-item" data-index="{$index}">
            <div class="row">
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'account_type'}}">Trang Affiliate</label>
                    {!!
                        html_input([
                            'type' => 'select',
                            'name' => $pfname . '[affiliate_id]',
                            "class"=>"form-control",
                            'data' => get_affiliate_options([], "Chọn một")
                        ])
                    !!}
                </div>
                <div class="col-12 col-sm-6 mb-3">
                    <label for="{{$pfid.'price'}}">Giá</label>
                    <input type="number" name="{{$pfname}}[price]" class="form-control" placeholder="Giá" min="0" step="1">
                </div>
                <div class="col-12 mb-3">
                    <label for="{{$pfid.'url'}}">Liên kết</label>
                    <input type="text" name="{{$pfname}}[url]" class="form-control" placeholder="Liên kết sản phẩm">
                </div>
                
            </div>
            <div class="btns mb-3">
                <a 
                    href="javascript:void(0);" 
                    class="btn-delete-affiliate-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air"
                    data-index="{$index}" data-toggle="m-tooltip" data-placement="right" data-original-title="Xóa gói">
                    <i class="flaticon-delete-1"></i>
                </a>
            </div>
        </div>
    </div>
    
</div>