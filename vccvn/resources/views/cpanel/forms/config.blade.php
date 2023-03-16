<?php
// su dung thu vien
use Crazy\Helpers\Arr;
use Crazy\Html\HTML;
use Crazy\Html\Form;
use Crazy\Html\Input;

// cac bien
// form config
$cfg = new Arr($form_config);
$args = [
	'inputs' => $form_inputs,
	'data' => [],
	'errors' => $errors
];
$input_options = ['className'=>'form-control m-input'];

$form = new Form($args, $input_options);

// dd($form);
?>

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $cfg->title?$cfg->title:$module_name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $module_name?$module_name:$cfg->title)

@section('content')

<form action="" method="post">
	<div class="form-group row">
		<div class="col-md-4">
			<div class="row">
				<label for="layot-type" class="col-sm-4 col-lg-3 col-form-label">Layout type</label>
				<div class="col-sm-8 col-lg-9">
					<select name="layout_type" id="layout-type" class="form-control m-input">
						@foreach (['single' => 'Danh sách', 'column' => 'Lưới'] as $value => $text)
							<option value="{{$value}}" @if ($value == $cfg->layout_type) selected @endif>{{$text}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row form-layout-grid">
		<div class="col-md-8 col-lg-10">
			<h4 class="mb-4 text-center">Layout</h4>
			<div class="row">
				@if ($cfg->layout_type == 'column' && count($cfg->form_groups))
					@foreach ($cfg->form_groups as $index => $fgroup)
						@php 
						$group = new Arr($fgroup); 
						@endphp
						
						@include($_base.'forms.config-section', [
							'list'=>$form->notInGroup($group->inputs),
							'group_title' => $group->title,
							'group_class' => $group->class,
							'index' => $index
						])
						
					@endforeach
				@else
					@include($_base.'forms.config-section', [
						'list'=>$form->notInGroup(),
						'group_title' => $group->title,
						'group_class' => '',
						'index' => 0
					])
				@endif
				<div class="col add-group-addon">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__body p-0">
							<a href="javascript:void(0);" class="btn-add-group">
								<i class="fa fa-plus"></i> Thêm group
							</a>
						</div>
					</div>
			
					<!--end::Portlet-->
				</div>
			
			</div>
			<div class="buttons text-center mb-4">
				<a href="javascript:void(0);" class="btn btn-info btn-save-form-setting">
					Lưu
				</a>
				<a href="javascript:void(0);" class="btn btn-default btn-cancel-form-setting">
					Hủy
				</a>
			</div>
		</div>
		<div class="col-md-4 col-lg-2">
			<h4 class="mb-4 text-center">Inputs</h4>
			<div class="dd" id="form-group-inputs" data-max-depth="1">
				<ol class="dd-list">
					<?php
						$names = get_js_data('field_list')??[];
						add_js_data('nestable_selectors', '#form-group-inputs');
					?>
					@if (count($list = $form->notInGroup()))
						@foreach ($list as $namespace => $item)
						@if (in_array($namespace, $names))
							@continue
						@endif
						<li class="dd-item" data-id="{{$namespace}}">
							<div class="dd-handle">{{$item->label}}</div>
						</li>
						@endforeach
					@endif
					
				</ol>
			</div>
		</div>
	</div>
	
	
</form>
<div class="group-template d-none">
	@include($_base.'forms.config-section', [
		'group_title' => '{$title}',
		'group_class' => '{$class}',
		'index' => '{$index}',
		'is_template' => true
	])
</div>

@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		var form_setting_submit_url = @json($submit_url);
		var delete_form_group_url = @json($delete_form_group_url);
	</script>
@endsection

{{-- Nhúng link css --}}
@section('css')
	<link rel="stylesheet" href="{{asset('static/plugins/nestable2/jquery.nestable.min.css')}}">
@endsection

{{-- Nhúng js --}}

@section('js')


<script src="{{asset('static/plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/form-setting.js')}}"></script>

@endsection
