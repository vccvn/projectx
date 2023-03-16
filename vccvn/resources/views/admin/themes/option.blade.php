@extends($_layout.'main')
{{-- khai báo title --}}
@section('title', 'Tùy biến Giao diện | '.$theme->name)
{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $theme->name)

{{-- Nội dung --}}
@section('content')
@if ($optionGroups)
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3>Cài đặt</h3>
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
                                    'action' => route($route_name_prefix.'themes.options.group.save', ['group' => $group['slug']]),
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
						'get_category_url' => route('admin.posts.category-options')
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

	@if ($theme->package && is_array($theme->package) && $package = $theme->package)
		@php
			if(array_key_exists('icons', $package) && is_array($package['icons'])){
				$icons = [];
				foreach ($package['icons'] as $slug => $iconData) {
					$icon = crazy_arr($iconData);
					if(is_array($icon->style)){
						foreach ($icon->style as $link) {
							$l = str_replace('@assets/', '', $link);
							if($l != $link){
								add_css_link(theme_asset($l));
							}else{
								add_css_link($link);
							}
						}
					}

					if(is_array($icon->list)){
						$listIcons = [];
						foreach ($icon->list as $list) {
							if(is_array($list)){
								if(array_key_exists('items', $list) && is_array($list['items'])){
									$prefix = array_key_exists('prefix', $list) ? $list['prefix'] : '';
									foreach ($list['items'] as $item) {
										$listIcons[] = $prefix.$item;
									}
								}elseif(array_val_type($list, 'string')){
									foreach ($list as $item) {
										$listIcons[] = $item;
									}
								}
							}
						}
						if(count($listIcons)){
							$icons[$icon->key] = [
								'title' => $icon->title,
								'list' => $listIcons
							];
						}
					}
				}
				if($icons){
					add_js_data('icon_picker_data', $icons);
				}
				
			}
			
		@endphp
	@endif
	@section('js')
		<?php
		add_js_src('static/plugins/ckeditor/ckeditor.js');
        add_js_src('static/manager/js/ckeditor.js');
		set_admin_template_data('modals', 'icon-picker-modal');
		add_js_src('static/manager/js/iconpicker.js');
		set_web_data('set_icon_picker_model', true);
		add_js_src('static/crazy/js/select.js');
		set_admin_template_data('modals', 'colorpicker-modal');
        set_admin_template_data('modals', 'modal-library');
		?>
		<script src="{{asset('static/plugins/nestable2/jquery.nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/nestable.js')}}"></script>
		<script src="{{asset('static/manager/js/components.js')}}"></script>
	@endsection

@endif