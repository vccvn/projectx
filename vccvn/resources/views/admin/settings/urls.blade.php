@extends($_layout.'main')
{{-- khai báo title --}}
@section('title', 'Thiet61 lap65 URL ')
{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', "Settings")

{{-- Nội dung --}}
@section('content')
@if ($urlGroups)
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3>Cài đặt</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					@foreach ($urlGroups as $key => $group)
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link {{($tab == $key || (!$tab && !$loop->index))?'active':''}}" data-ref="{{$key}}" data-toggle="tab" href="#{{$key}}_tab_content" role="tab">
								{{$group['label']}}
							</a>
						</li>
					@endforeach
					
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="tab-content">
				@foreach ($urlGroups as $key => $group)
					<div class="tab-pane {{($tab == $key || (!$tab && !$loop->index))?'active':''}}" id="{{$key}}_tab_content" role="tabpanel">
						<div class="{{$key}}-form ">
							<?php
								if(isset($group['config'])){
									if(!is_array($group['config'])){
										$group['config'] = json_decode($group['config'], true);
									}
								}else{
									$group['config'] = [];
								}
								$group['config'] = array_merge($group['config'], [
									'save_button_text' => 'Lưu',
									'cancel_button_text' => 'Hủy'
								]);
								$formConfig = array_merge($group, [
                                'attrs' => [
                                    'method' => 'POST',
                                    'action' => route($route_name_prefix.'settings.urls.group.save', ['group' => $group['slug']]),
                                    'id' => 'theme-'.$group['slug'].'-url-form',
                                    'class' => 'crazy-form'
                                ]
							]);
							?>
							@include($_base.'forms.form', $formConfig)
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	
	@if (get_web_data('has_component_area'))
		@include($_base.'html.components.modal-template', ['componentOptions' => get_component_options()])
	@endif
@endif



@endsection

@if (get_web_data('has_component_area'))
	
	{{-- Nhúng link css --}}
	@section('css')
	<link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
	@endsection

	{{-- Nhúng js --}}

	@section('jsinit')
		<script>
			var component_data = {
				urls: {!! 
					json_encode([
						'sort' => route('admin.components.sort'),
						'save' => route('admin.components.ajax-save'),
						'delete' => route('admin.components.delete'),
						'detail' => route('admin.components.detail'),
						'inputs' => route('admin.components.inputs'),
					]) 
				!!},
				list: {!! 
					json_encode([
						'theme' => get_component_options()
					]) 
				!!}
			}
			posts_data = {
				urls: {
					get_category_url: '{{route('admin.posts.category-options')}}'
				}
			};
		</script>
	@endsection

	@section('js')
		<?php
		set_admin_template_data('modals', 'icon-picker-modal');
		add_js_src('static/manager/js/iconpicker.js');
		set_web_data('set_icon_picker_model', true);
		add_js_src('static/crazy/js/select.js');
		
        set_admin_template_data('modals', 'modal-library');
		?>
		<script src="{{asset('static/plugins/nestable2/jquery.nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/components.js')}}"></script>
	@endsection
@endif