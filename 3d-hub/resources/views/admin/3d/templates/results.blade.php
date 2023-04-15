<?php
$columns = [
    'name'=>'Tiêu đề',
    'keywords' => 'Từ khoa'
];
extract(get_result_blade_vars("Template", (isset($type) && strtolower($type) == 'trash')?'trash':'default'));
$current_page = request()->page;
if(!is_numeric($current_page) || $current_page < 1) $current_page = 1;
$index = ($current_page - 1) * 10 + 1;

?>
@include($_template.'list-filter',[
    'sortable'=> array_merge($columns, [
        'updated_at' => 'Thời gian cập nhật'
    ]),
    'searchable' => $columns
])

@if (count($results))
    <div class="list-template crazy-list">
        <div class="row">
            @foreach ($results as $item)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-4" id="crazy-item-{{$item->id}}" data-name="{{$item->name}}">

                <!--begin:: Widgets/Blog-->
                <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force" >
                    
                    <div class="m-portlet__head m-portlet__head--fit">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-action">
                                <button type="button" class="btn btn-sm m-btn--pill  btn-dark">
                                    @if ($item->category)
                                    {{$item->category->name}}
                                    @else 
                                    Unftitled
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                        
                    
                    <div class="m-portlet__body">
                        <div class="m-widget19">
                            <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px">
                                <img src="{{$item->getThumbnail()}}" alt="">
                                <h3 class="m-widget19__title m--font-light">
                                    {{$item->name}}
                                </h3>
                                <div class="m-widget19__shadow"></div>
                            </div>
                            <div class="m-widget19__content">
                                @if ($type!='trash')
                                <div class="mt-4 mb-4">


                                        <a href="{{route($route_name_prefix.'3d.templates.update', ['id'=>$item->id])}}" class="btn m-btn--pill m-btn--air         btn-primary btn-sm">Sửa thông tin</a>
                                        {{-- <button type="button" class="btn m-btn--pill m-btn--air         btn-secondary btn-sm">Small button</button> --}}
                                        {{-- <button type="button" class="btn m-btn--pill m-btn--air         btn-outline-success btn-sm">Small button</button> --}}
                                        <button type="button" class="btn m-btn--pill m-btn--air         btn-outline-info btn-sm btn-edit-3d" data-id="{{$item->secret_id}}">Sửa 3D</button>
                                        <button type="button" class="btn m-btn--pill m-btn--air         btn-outline-danger btn-sm {{$btn_class}}" data-id="{{$item->id}}">Xóa</button>
                                        {{-- <button type="button" class="btn m-btn--pill m-btn--air         btn-outline-brand btn-sm">Small button</button> --}}
                                </div>
                                @endif
                                <div class="m-widget19__body">
                                    {{$item->description}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end:: Widgets/Blog-->
            </div>
            @endforeach
        </div>
    </div>
@elseif($type!="trash")
    <div class="col-12 my-5 py-5">
        <div class="btn-s text-center">
            <a href="{{route('admin.3d.templates.create')}}" class="btn btn-info">
                <i class="fa fa-plus"></i>
                Upload Template
            </a>
        </div>
    </div>
@endif