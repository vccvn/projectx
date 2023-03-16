@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Danh sách task')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $title = 'Task')

{{-- Nhúng link css --}}
@section('css')
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

@section('content')


<?php
$columns = [
    'task_url'=>'Đường dẫn',
    'frame_name'=>'Frame'
];

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
                    <a data-original-title="Thêm task" href="{{route($route_name_prefix.'crawlers.tasks.create')}}" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="m-portlet__body">

        <div class="m-section">
            <div class="m-section__sub">
                @include($_template.'list-filter',[
                    'sortable'=> array_merge($columns, [
						'crawl_datetime' => 'Lần crawl sau cùng'
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
                                <th class="min-100 max-250">URL</th>
                                <th>Nguồn</th>
                                <th>Kênh</th>
                                <th>Danh mục</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                            
                            <tr class="tr_user" id="crazy-item-{{$item->id}}" data-name="{{$item->task_url}}">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="{{$item->id}}" data-id="{{$item->id}}" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <td class="min-100 max-250">
									<a href="{{$edit = route($route_name_prefix.'crawlers.tasks.update', ['id'=>$item->id])}}">
										{{$item->task_url}}
									</a>
								</td>
                                <td>{{ $item->frame_name }}</td>
                                <td>{{ $item->dynamic_name }}</td>
                                <td>{{ $item->category_name??'Không' }}</td>
                                <td>
                                    {{ $item->calculator_time($item->crawl_datetime?'crawl_datetime':'created_at') }}
                                </td>
                                <td>
									@include($_base.'forms.templates.switch', [
										'input' => html_input([
											'type' => 'checkbox',
											'name' => 'tasks['.$item->id.'][status]',
                                            'id' => 'tasks-'.$item->id.'-status',
                                            'data-task-id' => $item->id,
                                            'value' => $item->status,
                                            '@change' => 'App.crawler.changeTaskStatus'
											
										])
									])
                                </td>
                                <td class="text-center min-100 actions">
                                    
                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Crawl" class="btn-run-task text-warning btn btn-outline-warning btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-bolt"></i>
                                    </a>

                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="{{$edit}}" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>

                                    <a href="javascript:void(0);" data-id="{{$item->id}}" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-check"></i>
                        </a>

                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Crawl tất cả" class="crazy-btn-run-all-task text-warning btn btn-outline-warning btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-bolt"></i>
                        </a>

                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
           
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    {{$results->links($_pagination.'default')}}
                </div>
            </div>
        </div>
        <!--end::Section-->

        @else
            <div class="alert alert-warning">Danh sách trống</div>
        @endif
        
    </div>

    <!--end::Form-->
</div>


@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"crawlers.tasks",
				title:@json($title),
				urls:{
					delete_url: @json(route($route_name_prefix.'crawlers.tasks.delete'))
				}
			})
		};
		window.crawlerInit = function () {
			App.crawler.init({
				urls:{
					run_url: @json(route($route_name_prefix.'crawlers.tasks.run')),
                    change_status_url: @json(route($route_name_prefix.'crawlers.tasks.status'))
                    
				}
			})
		};
		// khai báo ở dây
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')
    <script src="{{asset('static/crazy/js/items.js')}}"></script>
    <script src="{{asset('static/manager/js/crawler.js')}}"></script>
@endsection
