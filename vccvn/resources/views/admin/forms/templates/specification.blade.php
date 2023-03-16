<?php
use Crazy\Html\Input;
use Crazy\Helpers\Arr;

add_js_src('static/crazy/js/specification.js');
// $input->type = "text";

$wrapper = $input->copy();

$wrapper->type = "specification";
$wrapper->prepareCrazyInput();

$wrapper->removeClass();
$wrapper->addClass("crazy-specification");
$wrapper->id.='-wrapper';
$wrapper->name.='-wrapper';
$selectData = [
    "text","number","email","textarea","select","radio", "checkbox", "checklist", "switch", "crazyselect", "crazytag", "options", "touchspin"
];

$data = $input->defval();
if(!is_array($data)) $data = [];
$maxIndex = -1;

?>

<div {!! $wrapper->attrsToStr() !!}>
    <div class="crazy-specification-list">
        @if ($data)
            @foreach ($data as $index => $specification)
                <?php
                    $p = new Arr($specification);
                    $maxIndex = $index;
                    $name = $input->name."[$index]";

                    $specificationList = $p->list;
                    if($specificationList){
                        if(!is_array($specificationList)){
                            $specificationList = json_decode($specificationList, true);
                        }
                    }else{
                        $specificationList = [];
                    }
                ?>
                <div class="crazy-specification-item row" id="crazy-specification-item-{{$index}}" data-index="{{$index}}">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Tên nhóm thuộc tính</label>
                                <input type="text" name="{{$name.'[name]'}}" class="form-control m-input" placeholder="name" value="{{$p->name}}">
                            </div>

                            <div class="col-12 mb-xs-4">
                                <label for="">Thuộc tính (dạng label-value): </label> <a href="javascript:void(0);" data-index="{{$index}}" class="crazy-btn-add-specification-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                                <div class="specification-list" data-max-index="{{count($specificationList)}}">
                                    @if ($specificationList)
                                        @foreach ($specificationList as $item)
                                            <?php
                                                $specificationItem = new Arr($item);
                                            ?>
                                            <div class="row specification-list-item mt-3" id="{{$input->name.'-'.$index.'-specification-list-'.$loop->index}}">
                                                <div class="col-12 col-sm-10 col-md-11">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-5 col-md-4">
                                                            <input type="text" name="{{$name.'[list]['.$loop->index.'][key]'}}" class="form-control m-input" value="{{$specificationItem->key}}" placeholder="Key / Label ">
                                                        </div>
                                                        <div class="col-6 col-sm-7 col-md-8">
                                                            <input type="text" name="{{$name.'[list]['.$loop->index.'][value]'}}" placeholder="Giá trị" class="form-control m-input" value="{{$specificationItem->value}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-2 col-md-1 ">
                                                    <a href="javascript:void(0);" data-list-index="{{$index}}" data-item-index="{{$loop->index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-specification-data text-warning btn btn-default">
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
                    <div class="col-md-1 specification-actions mb-xs-4">
                        <a href="javascript:void(0);" data-index="{{$index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa trường này" class="crazy-btn-delete-specification text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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

    <div class="crazy-specification-buttons mt-3 ">
        <div class="crazy-btn-add-specification btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
            <span>
                <i class="la la-plus"></i>
                <span>Thêm</span>
            </span>
        </div>
    </div>

    <div class="crazy-specification-template d-none" style="display: none" data-max-index="{{$maxIndex}}">
            <?php
            $index = '{$index}';
            $name = $input->name."[$index]";


        ?>
        <div class="crazy-specification-item row" id="crazy-specification-item-{{$index}}" data-index="{{$index}}" style="display: none">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-12 mb-4">
                        <label>Tên nhóm</label>
                        <input type="text" name="{{$name.'[name]'}}" class="form-control m-input" placeholder="name">
                    </div>

                    <div class="col-12 mb-xs-4">
                        <label for="">Thuộc tính (dạng label - value):</label>  <a href="javascript:void(0);" data-index="{{$index}}" class="crazy-btn-add-specification-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                            <div class="specification-list" data-max-index="0">

                            </div>

                    </div>

                </div>
            </div>
            <div class="col-md-1 specification-actions mb-4">
                <a href="javascript:void(0);" data-index="{{$index}}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-specification text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="flaticon-delete-1"></i>
                </a>
            </div>

        </div>

    </div>

    <div class="specification-template d-none" style="display: none">
        <div class="row specification-list-item mt-3" id="{$name}-{$index}-specification-list-{$loop_index}">
            <div class="col-12 col-sm-10 col-md-11">
                <div class="row">
                    <div class="col-6 col-sm-5 col-md-4">
                        <input type="text" name="{$name}[{$index}][list][{$loop_index}][key]" class="form-control m-input" placeholder="key / Label">
                    </div>
                    <div class="col-6 col-sm-7 col-md-8">
                        <input type="text" name="{$name}[{$index}][list][{$loop_index}][value]" placeholder="Giá trị" cols="30" rows="1" class="form-control m-input" />
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-1">
                <a href="javascript:void(0);" data-list-index="{$index}" data-item-index="{$loop_index}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-specification-data text-warning btn btn-default">
                        <span class="fa fa-ban"></span> Xóa
                </a>
            </div>
        </div>
    </div>
</div>
