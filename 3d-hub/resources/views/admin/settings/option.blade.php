@extends($_layout.'main')
{{-- khai báo title --}}
@section('title', $option->title)
{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $option->title)

{{-- Nội dung --}}
@section('content')
@if ($optionGroups)
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3>Thiết lập</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					@foreach ($optionGroups as $key => $group)
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
				@foreach ($optionGroups as $key => $group)
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
                                    'action' => route($route_name_prefix.'settings.'.$option->slug.'.group.save', ['group' => $group['slug']]),
                                    'id' => 'theme-'.$group['slug'].'-option-form',
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
		add_js_src('static/crazy/js/select.js');
		?>
		<script src="{{asset('static/plugins/nestable2/jquery.nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/components.js')}}"></script>
	@endsection
@endif