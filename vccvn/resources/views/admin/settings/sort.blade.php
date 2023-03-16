@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = 'Sắp xếp '.$groupLabel)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Sắp xếp thứ tự ưu tiên
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm {{$groupLabel}}" class="ml-3 btn btn-outline-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air btn-add-setting-item"><i class="fa fa-plus"></i></a>
                    <a href="{{route($route_name_prefix.'settings.group.form', ['group' => $group])}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Form" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air "><i class="fa fa-tasks"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="setting-list">
                    
                    <div class="dd nestable setting-item-list-body" id="crazy-setting-item-list" data-max-depth="1" data-callback="App.setting.items.sortCallback">
                        <ol class="dd-list">
                            @if (count($list))
                                @foreach ($list as $item)
                                <li class="dd-item" data-id="{{$item->id}}">
                                    @if ($item->can_delete)
                                        
                                    <div class="item-actions">
                                        <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{{$item->id}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{{$item->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="dd-handle">
                                        <span class="item-name">{{$item->label}}</span>
                                    </div>
                                </li>    
                                @endforeach
                            @endif                        
                        </ol>
                    </div>
                </div>
            </div>
            <div class="nesttable-template d-none">
                <span class="skill-name">{$name}</span>
            </div>
            <div class="item-action-template d-none">
                <div class="item-actions">
                    <a href="javascript:void(0);" class="edit btn-edit-item" data-id="{$id}">
                        <i class="fa fa-pencil-alt"></i>
                    </a>
                    <a href="javascript:void(0);" class="remove btn-delete-item" data-id="{$id}">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

    <!--end::Form-->
</div>


<div class="modal fade setting-item-modal" id="setting-item-modal" tabindex="-1" role="dialog" aria-labelledby="setting-item-modal-title">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{route($route_name_prefix.'settings.item.save', ['group' => $group])}}" method="POST" id="add-setting-item-form">
                <input type="hidden" name="id" id="setting-item-id" value="">

                <div class="modal-header custom-style bg-info">
                    <h5 class="modal-title" id="setting-item-modal-title">
                        <i class="fa fa-info-circle"></i>
                        <span>Thêm {{$groupLabel}}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Tên</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="name" id="setting-item-name" class="form-control m-input" placeholder="Nhập tên có dạng: item_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Nhãn</label>
                        <div class="col-md-8 col-lg-9">
                            <input type="text" name="label" id="setting-item-label" class="form-control m-input" placeholder="Nhập nhãn">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Kiểu input</label>
                        <div class="col-md-8 col-lg-9">
                            @include($_base.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    'type' => 'crazyselect',
                                    'name' => 'type',
                                    'id' => 'input_type',
                                    'data' => web_cfg('option_input_types'),
                                    '@change' => 'App.setting.items.changeInputType'
                                ])
                            ])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-lg-3 col-form-label">Kiểu giá trị</label>
                        <div class="col-md-8 col-lg-9">
                                @include($_base.'forms.templates.crazyselect', [
                                    'input' => html_input([
                                        'type' => 'crazyselect',
                                        'name' => 'value_type',
                                        'id' => 'value_type',
                                        'data' => [
                                            'text' => 'Chữ, số, ký tự',
                                            'number' => 'Số',
                                            'boolean' => 'Boolean'
                                        ]
                                    ])
                                ])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-submit">Thêm</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
    


@endsection

{{-- Nhúng link css --}}
@section('css')
    <link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
    
@endsection

{{-- Nhúng js --}}

@section('jsinit')
    {{-- <script>
        var setting_data = {
            urls: {
                sort: "{{admin_setting_item_url('sort.save')}}",
                delete: "{{admin_setting_item_url('delete')}}"
            }
        };
    </script> --}}
@endsection

@section('js')
<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/setting.items.js')}}"></script>

@endsection
