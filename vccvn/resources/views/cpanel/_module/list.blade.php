<?php
use Crazy\Html\ColumnItem;
use Crazy\Helpers\Arr;
$list_group = isset($list_group) ? strtolower($list_group) : 'default';
extract(get_result_blade_vars($config->name, $list_group));
$btn_m_class = 'btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air';
$columns = $config->get('table.columns');
$resources = new Arr($config->resources??($config->assets??[]));
// $routeParams = is_array()
if($resources->js_data){
    add_js_data('list_data', $resources->js_data);
}
if($resources->js && is_array($resources->js)){
    foreach($resources->js as $js){
        add_js_src($js);
    }
}
if($resources->css && is_array($resources->css)){
    foreach($resources->css as $css){
        add_css_link($css);
    }
}

$mod_title = $list_group == 'trash' ? ($config->titles['trash']??'Danh sach '.$module_name . ' dã xóa') : ($config->titles[$list_group]??($config->titles['default']??'DAnh sach '.$module_name)); 

if ($config->use_trash && $list_group != 'trash'){
	admin_action_menu([
		[
			'url' => route($route_name_prefix.$config->package.'.trash'),
			'text' => ($config->name??$module_name).' đã xóa',
			'icon' => 'fa fa-trash'
		]
	]);
}
if(!$config->use_trash){
    $btn_class = 'btn-delete';
    $btn_tooltip = "Xóa";
}
$can_edit = $config->has('can_edit')?$config->can_edit:true;
	
$filterForm = $config->filter['form']??null;

$general_columns = $config->filter['general_columns']??[];
$search_columns = array_merge($general_columns, $config->filter['search_columns']??[]);
$sort_columns = array_merge($general_columns, $config->filter['sort_columns']??[]);

?>

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $title = $mod_title)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $config->name??$module_name)


@section('content')


<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{$title}}
                </h3>
            </div>
        </div>
        @if ($list_group!='trash')
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="{{route($route_name_prefix.$config->package.'.create')}}" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm {{$config->name??$module_name}}" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        @endif

    </div>
    
    <div class="m-portlet__body">

        <div class="m-section filter-section">
            <div class="m-section__sub">
                @include($_template.'list-filter'.($filterForm?'-'.$filterForm:''),[
                    'sortable'=> $sort_columns,
                    'searchable' => $search_columns
                ])
            </div>
        </div>
        @if (isset($results) && count($results))
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list {{str_slug($config->package, '-')}}">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped {{$config->get('table.class')}}">
                        <thead>
                            <tr>
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                @if ($columns)
                                    @foreach ($columns as $column)
                                    <th class="{{$column['header_class']??$column['class']??''}}">{{$column['title']??'Column'}}</th>        
                                    @endforeach    
                                
                                @endif
                                
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                ColumnItem::setParams($config, $route_name_prefix.$config->package, $_base, 'td');
                            @endphp
                            @foreach ($results as $item)
                                
                            <tr id="crazy-item-{{$item->id}}" data-name="{{$item->name??$item->title}}">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                @if ($columns)
                                    @foreach ($columns as $column)
                                    
                                        {!! ColumnItem::show($item, $column) !!}
                                    
                                    @endforeach    
                                
                                @endif
                                
                                <td class="min-100 actions">
                                    @if ($config->can_edit!==false)
                                    <a href="{{route($route_name_prefix.$config->package.'.update', ['id'=>$item->id])}}" data-original-title="Sửa"  data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent {{$btn_m_class}}">
                                        <i class="flaticon-edit-1"></i>
                                    </a>
                                    @endif
                                    @if ($list_group=='trash')
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info {{$btn_m_class}}">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                    @endif
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="{{$btn_tooltip}}" class="{{$btn_class}} text-danger btn btn-outline-danger {{$btn_m_class}}">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                </td>
                            </tr>
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
                        
                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success {{$btn_m_class}}">
                        <i class="fa fa-check"></i>
                    </a>
                
                    @if ($config->use_trash)
                        @if ($list_group=='trash')
                        
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Khôi phục tất cả" class="crazy-btn-restore-all text-info btn btn-outline-info {{$btn_m_class}}">
                            <i class="fa fa-undo"></i>
                        </a>
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger {{$btn_m_class}}">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        @else
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="crazy-btn-move-to-trash-all text-danger btn btn-outline-danger {{$btn_m_class}}">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        
                        @endif    
                    @else
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger {{$btn_m_class}}">
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
<?php
$extra = ['components' => $_component, 'templates' => $_template, 'modals' => $_base.'_modals.', 'views' => $_base];
?>
@foreach ($extra as $item => $path)
    @if ($tpl = $config->get('includes.'.$item))
        @if (!is_array($tpl))
            @include($path.$tpl)
        @else
            @foreach ($tpl as $blade)
                @include($path.$blade)
            @endforeach
        @endif
    @endif

@endforeach

@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	@if ($list_group != 'trash')
		
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"{{$config->package}}",
				title:"{{$config->name}}",
				urls:{
					{{$config->use_trash?'move_to_trash':'delete'}}_url: @json(route($route_name_prefix.$config->package.'.'.($config->use_trash?'move-to-trash':'delete')))
				}
			})
		};
		// khai báo ở dây
	</script>
	@else
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"{{$config->package}}",
				title:"{{$config->name}}",
				
				urls:{
					delete_url: @json(route($route_name_prefix.$config->package.'.delete')),
					restore_url: @json(route($route_name_prefix.$config->package.'.restore'))
				}
			})
		};
		// khai báo ở dây
	</script>	
	@endif
	
@endsection

{{-- Nhúng js --}}

@section('js')
	<script src="{{asset('static/crazy/js/items.js')}}"></script>
@endsection
