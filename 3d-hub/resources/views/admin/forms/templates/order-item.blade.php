<?php
$namespace = "$name.$index";

$hasError = $errors->has($namespace);
$errorMessage = $errors->first($namespace);

?>
<!-- product item -->
<div class="order-item order-product-item row {{$hasError?'has-danger':''}}" id="order-item-{{$index}}">
    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
        <div class="product-image">
            <img src="{{$product->getFeatureImage()}}" class="product-thumbnail">
        </div>
    </div>
    <div class="col-sm-6 col-md-8 col-lg-9 col-xl-10">
        <input type="hidden" name="{{$name}}[{{$index}}][product_id]" value="{{$product->id}}">
        <input type="hidden" name="{{$name}}[{{$index}}][id]" value="">
        <h2 class="{{$hasError?'text-danger':''}}">{{$product->name}}</h2>
        <div class="price">
            <div class="form-group row">
                <label for="{{$name}}-{{$index}}-price" class="col-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Giá</label>
                <div class="col-12 col-sm-6 col-md-5 col-lg-2">
                    @if ($product->hasPromo())
                        <div class="text-danger line-through">{{$product->priceFormat('list', 2, ',', '.')}} VNĐ</div>
                        <div class="text-success">{{number_format($product->getFinalPrice(), 2, ',', '.')}} VNĐ</div>
                    @else
                        <div class="text-success">{{$product->priceFormat('list', 2, ',', '.')}} VNĐ</div>
                    @endif
                </div>
            </div>
            
        </div>
        <div class="attributes">
            @if (isset($attr_values) && is_array($attr_values))
                @foreach ($attr_values as $k => $attr)
                    <?php 
                    $key = $loop->index;
                    $input = html_input($attr); 
                    $is_template = is_support_template($input->template, $input->type);
                    $input->name = $name. "[$index][attr_values][$input->name]";
                    $input->id = $name. "-$index-attr_values-$input->name";

                    ?>
                    
                    <div class="form-group row">
                        <label for="{{$input->id}}" class="col-12 col-sm-4 col-md-3 col-lg-2 col-form-label">{{$input->label}}</label>
                        <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                            @if ($is_template)
                                @include('admin.forms.templates.'.$input->template)
                            @elseif(in_array($input->type, ['checkbox', 'radio', 'checklist']))
                                <div class="checkbox-radio {{$input->data('display') == 'list'?'display-list':"display-inline"}}">
                                    {!! $input !!}
                                </div>
                            @else
                            
                                {!! $input !!}    
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="quantity">
            <div class="form-group row">
                <label for="{{$name}}-{{$index}}-quantity" class="col-12 col-sm-4 col-md-3 col-lg-2 col-form-label">Số lượng</label>
                <div class="col-12 col-sm-6 col-md-5 col-lg-2">
                    <input type="number" name="{{$name. "[$index][quantity]"}}" value="{{$quantity??1}}" id="{{$name}}-{{$index}}-quantity" min="1" step="1" class="form-control m-input" placeholder="Nhập số lượngr">
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="javascript:void(0);" data-index="{{$index}}" data-toggle="m-tooltip" data-placement="right" data-original-title="Xóa san phẩm" class="btn-delete-order-product-item text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                <i class="flaticon-delete-1"></i>
            </a>
            
        </div>

        <div class="form-control-feedback input-message-alert" id="input-item-{{$index}}-message-alert">{{$errorMessage}}</div>    
    </div>
</div>