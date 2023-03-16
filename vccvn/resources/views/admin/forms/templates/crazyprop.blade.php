<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('static/crazy/js/prop.js');
// $input->type = "text";

$wrapper = $input->copy();

$wrapper->type = "crazyprop";
$wrapper->prepareCrazyInput();

$wrapper->removeClass();
$wrapper->addClass("crazy-prop");
$wrapper->id.='-wrapper';
$wrapper->name.='-wrapper';
$selectData = [
    "text","number","email","textarea","select","radio", "checkbox", "checklist", "switch", "crazyselect", "crazytag", "options", "touchspin", "file", 'media'
];

$data = $input->defval();
if(!is_array($data)) $data = [];
$maxIndex = -1;

?>

<div {!! $wrapper->attrsToStr() !!}>
    <div class="crazy-prop-list">
        @if ($data)
            @foreach ($data as $index => $prop)
                <?php
                    $p = new Arr($prop);
                    $maxIndex = $index;
                    $name = $input->name."[$index]";
                    $type = new Input([
                                'type' => 'select',
                                'name' => $name.'[type]',
                                'data' => $selectData,
                                "data_value_type" => 'value',
                                'class' => 'form-control m-input',
                                'value' => $prop['type']
                            ]);

                    $propList = $p->prop_list;
                    if($propList){
                        if(!is_array($propList)){
                            $propList = json_decode($propList, true);
                        }
                    }else{
                        $propList = [];
                    }
                ?>
                <div class="crazy-prop-item row" id="crazy-prop-item-{{$index}}" data-index="{{$index}}">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Tên trường (field name)</label>
                                <input type="text" name="{{$name.'[name]'}}" class="form-control m-input" placeholder="name" value="{{$p->name}}">
                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Loại (input type)</label>
                                {!! $type !!}
                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Nhãn (label)</label><input type="text" name="{{$name.'[label]'}}" class="form-control m-input" placeholder="label (Nhãn)" value="{{$p->label}}">
                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Validate </label>
                                <input type="text" name="{{$name.'[validate]'}}" class="form-control m-input" placeholder="validate (ví dụ: required|string)" value="{{$p->validate}}">
                            </div>
                            
                            <div class="col-12 mb-xs-4">
                                <label for="">Thuộc tính (dạng key-value): </label> <a href="javascript:void(0);" data-index="{{$index}}" class="crazy-btn-add-prop-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                                <div class="prop-list" data-max-index="{{count($propList)}}">
                                    @if ($propList)
                                        @foreach ($propList as $item)
                                            <?php
                                                $propItem = new Arr($item);
                                            ?>
                                            <div class="row prop-list-item mt-3" id="{{$input->name.'-'.$index.'-prop-list-'.$loop->index}}">
                                                <div class="col-12 col-sm-10 col-md-11">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-5 col-md-4">
                                                            <input type="text" name="{{$name.'[prop_list]['.$loop->index.'][key]'}}" class="form-control m-input" value="{{$propItem->key}}" placeholder="key">
                                                        </div>
                                                        <div class="col-6 col-sm-7 col-md-8">
                                                            <textarea name="{{$name.'[prop_list]['.$loop->index.'][value]'}}" placeholder="value: Có thể nhập json theo cú pháp @[...] hoặc @{...}" cols="30" rows="1" class="form-control m-input auto-height">{{$propItem->value}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-2 col-md-1 ">
                                                    <a href="javascript:void(0);" data-list-index="{{$index}}" data-item-index="{{$loop->index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop-data text-warning btn btn-default">
                                                            <span class="fa fa-ban"></span> Xóa
                                                    </a>    
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="buttons">
                                        
                                </div>

                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-1 prop-actions mb-xs-4">
                        <a href="javascript:void(0);" data-index="{{$index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa trường này" class="crazy-btn-delete-prop text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                    </div>
                    
                    @if ($errors->has($input->name.'.'.$index))
                        <div class="col-12 mt-3">
                            <span class="text-danger">{{$errors->first($input->name.'.'.$index)}}</span>
                        </div>
                    @endif    
                </div>
                
            @endforeach
        @endif
    </div>

    <div class="crazy-prop-buttons mt-3 text-right">
        <div class="crazy-btn-add-prop btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
            <span>
                <i class="la la-plus"></i>
                <span>Thêm field</span>
            </span>
        </div>
    </div>

    <div class="crazy-prop-template d-none" style="display: none" data-max-index="{{$maxIndex}}">
            <?php
            $index = '{$index}';
            $name = $input->name."[$index]";

            $type = new Input([
                        'type' => 'select',
                        'name' => $name.'[type]',
                        'data' => $selectData,
                        "data_value_type" => 'value',
                        'class' => 'form-control m-input'
                    ]);
        ?>
        <div class="crazy-prop-item row" id="crazy-prop-item-{{$index}}" data-index="{{$index}}" style="display: none">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Tên trường (field name)</label>
                        <input type="text" name="{{$name.'[name]'}}" class="form-control m-input" placeholder="name">
                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Loại (input type)</label>
                        {!! $type !!}
                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Nhãn (label)</label><input type="text" name="{{$name.'[label]'}}" class="form-control m-input" placeholder="label (Nhãn)" >
                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Validate </label>
                        <input type="text" name="{{$name.'[validate]'}}" class="form-control m-input" placeholder="validate (ví dụ: required|string)">
                    </div>
                    
                    <div class="col-12 mb-xs-4">
                        <label for="">Thuộc tính (dạng key-value):</label>  <a href="javascript:void(0);" data-index="{{$index}}" class="crazy-btn-add-prop-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                            <div class="prop-list" data-max-index="0">
                                
                            </div>

                    </div>
                    
                </div>
            </div>
            <div class="col-md-1 prop-actions mb-4">
                <a href="javascript:void(0);" data-index="{{$index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="flaticon-delete-1"></i>
                </a>    
            </div>
            
        </div>
        
    </div>

    <div class="prop-template d-none" style="display: none">
        <div class="row prop-list-item mt-3" id="{$name}-{$index}-prop-list-{$loop_index}">
            <div class="col-12 col-sm-10 col-md-11">
                <div class="row">
                    <div class="col-6 col-sm-5 col-md-4">
                        <input type="text" name="{$name}[{$index}][prop_list][{$loop_index}][key]" class="form-control m-input" placeholder="key">
                    </div>
                    <div class="col-6 col-sm-7 col-md-8">
                        <textarea name="{$name}[{$index}][prop_list][{$loop_index}][value]" placeholder="value: Có thể nhập json theo cú pháp @[...] hoặc @{...}" cols="30" rows="1" class="form-control m-input auto-height"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-1">
                <a href="javascript:void(0);" data-list-index="{$index}" data-item-index="{$loop_index}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop-data text-warning btn btn-default">
                        <span class="fa fa-ban"></span> Xóa
                </a>    
            </div>    
        </div>
    </div>
</div>