<?php
$columns = [
    'name'=>'Tiêu đề',
    'keywords' => 'Từ khoa'
];
extract(get_result_blade_vars($dynamic->name, (isset($type) && strtolower($type) == 'trash')?'trash':'default'));
$current_page = request()->page;
if(!is_numeric($current_page) || $current_page < 1) $current_page = 1;
$index = ($current_page - 1) * 10 + 1;

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
        @if ($list_type!='trash')
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{admin_dynamic_url('create')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm {{$dynamic->name}}" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        @endif

    </div>
    
    <div class="m-portlet__body">

        <div class="m-section">
            <div class="m-section__sub">
                @include($_template.'list-filter',[
                    'sortable'=> array_merge($columns, [
                        'updated_at' => 'Thời gian cập nhật'
                    ]),
                    'searchable' => $columns
                ])
            </div>
        </div>
        @if (isset($results) && count($results))
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                
                                <th class="id-col">STT</th>
                                <th>Ảnh</th>
                                <th class="min-160 max-250">Tiêu đề</th>
                                @if ($dynamic->use_category)
                                    <th>Danh mục</th>
                                @endif
                                <th class="min-160 max-250">Mô tả</th>
                                <th class="text-center">Lượt xem</th>
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                                
                            <tr id="crazy-item-{{$item->id}}" data-name="{{$item->title}}">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                
                                <td class="id-col">{{$index}}</td>
                                <td>
                                    <a style="font-weight:500" href="{{$url = admin_dynamic_url('update', ['id'=>$item->id])}}">
                                        <img src="{{$item->getFeatureImage()}}" class="image-thumbnail" alt="{{$item->title}}">
                                    </a>
                                </td>
                                <td class="min-160 max-250"><a href="{{$url}}">{{$item->title}}</a></td>
                                @if ($dynamic->use_category)
                                    <th>{{$item->category?$item->category->name:"Không"}}</th>
                                @endif
                                <td class="min-160 max-250">{{ $item->getShortDesc(150) }}</td>
                                <td class="text-center">{{ $item->views??0 }}</td>
                                <td class="min-100 actions">

                                    
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="{{$url}}" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>
                                    
        
                                    @if ($list_type=='trash')
                                    
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                        
                                    @endif

                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="{{$btn_tooltip}}" class="{{$btn_class}} text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                    
                                </td>
                            </tr>

                            @php
                                $index++;
                            @endphp
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- nút phân trang --}}
        <div class="list-toolbar">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-check"></i>
                        </a>

                        @if ($list_type=='trash')
                        
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Khôi phục tất cả" class="crazy-btn-restore-all text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-undo"></i>
                        </a>
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        @else
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="crazy-btn-move-to-trash-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        
                        @endif

                        
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    {{$results->links($_pagination.'default')}}
                </div>
            </div>
        </div>
        <!--end::Section-->

        @else
            <div class="alert alert-default text-center">Danh sách trống</div>
        @endif
        
    </div>

    <!--end::Form-->
</div>
