<?php
$page = request()->page;


$list_config = [
    'default' => [
        'title' => 'Phương thức thanh toán',
        'btn_class' => 'btn-move-to-trash',
        'tooltip' => 'Xóa tạm thời',
    ],
    'trash' => [
        'title' => 'Danh sách tài khoản đã xóa',
        'btn_class' => 'btn-delete',
        'tooltip' => 'Xóa vĩnh viễn',
    ],
];

$list_type = (isset($type) && strtolower($type) == 'trash')?'trash':'default';

$columns = [
    'name'=>'Tên hiển thị',
    'method'=>'Phương thức',
    'description' => 'Mô tả',

];


$title = $list_config[$list_type]['title'];
$btn_class = $list_config[$list_type]['btn_class'];
$btn_tooltip = $list_config[$list_type]['tooltip'];
$method_options = get_payment_select_options();


?>


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{$title}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    {{-- <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm {{$config->name??$module_name}}" class="btn-add-method ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a> --}}
                    <div class="create-button">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Thêm Phương Thức
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start">
                            @if (is_array($method_options))
                                @foreach ($method_options as $value => $text)
                                    <a class="dropdown-item btn-create-payment" href="javascript:void(0);" data-method="{{$value}}">{{$text}}</a>
                                @endforeach
                            @endif


                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--end::Form-->
</div>
@if (count($results))
<div class="row crazy-list" id="m_sortable_portlets">
    <div class="col-lg-12">
        @foreach ($results as $item)
            @if (!($methodData = get_payment_method_inputs($item->method)))
                @continue
            @endif
            @php
                $config = $item->config;
                $inputs = crazy_arr($methodData['inputs'])->copyWithout(['name', 'description', 'method', 'guide']);

            @endphp
            <!--begin::Portlet-->
            <div class="m-portlet method-item m-portlet--collapsed m-portlet--head-sm m-portlet--sortable" data-name="{{$name = $item->name?$item->name:(isset($method_options[$method->method])?$method_options[$method->method]:$method->method)}}" m-portlet="true" id="crazy-item-{{$item->id}}" data-id="{{$item->id}}">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                @include($_base.'forms.templates.switch', [
                                    'input' => html_input([
                                        'type' => 'checkbox',
                                        'data-method-id' => $item->id,
                                        'name' => 'payment_methods['.$item->id.'][status]',
                                        'id' => 'payment-methods-'.$item->id.'-status',
                                        'value' => $item->status,
                                        '@change' => 'App.payments.methods.changeStatus'

                                    ])
                                ])
                            </span>
                            <h3 class="m-portlet__head-text">
                                {{$name}}
                            </h3>
                        </div>
                    </div>

                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down" style="transform: rotate(-180deg)"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="javascript:void(0);" data-id="{{$item->id}}" class="m-portlet__nav-link m-portlet__nav-link--icon {{$btn_class}}">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form method="post" action="{{route($route_name_prefix.'payments.methods.ajax.save')}}" class="m-form update-payment-method-form">
                        <input type="hidden" name="method" value="{{$item->method}}">
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <div class="form-group m-form__group ml-0 mr-0">
                            <label for="name-{{$item->id}}">Tên hiển thị</label>
                            <input type="text" name="name" class="form-control m-input m-input--air" id="{{$item->id}}" value="{{$name}}" placeholder="{{isset($methodData['inputs']['name']['placeholder'])?$methodData['inputs']['name']['placeholder']:'Viết gì đó'}}">
                        </div>

                        <div class="form-group m-form__group">
                            <label for="description-{{$item->id}}">Mô tả</label>
                            <textarea class="form-control m-input m-input--air" name="description" id="description-{{$item->id}}" rows="3">{{$item->description}}</textarea>
                        </div>

                        @if (is_array($config) && $config)
                            <h4>Cấu hình</h4>
                            <div class="table-responsive">
                                <table class="table table-bordere">
                                    <thead>
                                        <tr>
                                            @foreach ($inputs as $name => $input)
                                                <th>{{$input['label']}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($inputs as $name => $input)
                                                @php
                                                    $opt = $input;
                                                    $opt['name'] = $name;
                                                @endphp
                                                <td class="pl-0 pr-0">
                                                    {!!
                                                        html_input($opt)->val(isset($config[$name])?$config[$name]:'')->addClass('form-control m-input m-input--air')
                                                    !!}
                                                </td>

                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        @endif

                        @if (isset($methodData['inputs']['guide']))
                        <div class="form-group m-form__group">
                            <label for="guide-{{$item->id}}">Hướng dẫn</label>
                            <textarea class="form-control m-input m-input--air" name="guide" id="guide-{{$item->id}}" rows="3">{{$item->guide}}</textarea>
                        </div>


                        @endif
                        <div class="text-center mt-2 buttons">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <button type="button" class="btn btn-secondary">Huỷ bỏ</button>
                        </div>
                    </form>
                </div>

            </div>

            <!--end::Portlet-->

        @endforeach



        <!-- begin:Empty Portlet: sortable porlet required for each columns! -->
        <div class="m-portlet m-portlet--sortable-empty">
        </div>

        <!--end::Empty Portlet-->
    </div>
</div>
@else

@endif
