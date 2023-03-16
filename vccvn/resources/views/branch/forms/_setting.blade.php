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



?>

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $cfg->title?$cfg->title:$module_name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $module_name?$module_name:$cfg->title)

{{-- Nhúng link css --}}
@section('css')

	<link rel="stylesheet" href="{{asset('plugins/nestable2/dist/jquery.nestable.min.css')}}">

@endsection

@section('content')

<form action="" method="post">
	<div class="row">
		@if ($cfg->layout_type == 'column' && count($cfg->form_groups))

			@foreach ($cfg->form_groups as $index => $fgroup)
				@php $group = new Arr($fgroup); @endphp
				
					@include($_current.'_setting-section', [
						'list'=>$form->notInGroup($group->inputs),
						'group' => $group,
						'group_title' => $group->title,
						'layout_type' => $cfg->layout_type,
						'group_class' => $group->class,
						'index' => $index
					])
				
			@endforeach
		@else
				@include($_current.'_setting-section', [
					'list'=>$form->notInGroup(),
					'group' => new Arr(),
					'layout_type' => $cfg->layout_type,
					'group_class' => '',
					'index' => 0
				])
		@endif
	</div>
	<div class="row">
		<div class="col-12">
			<div class="buttons text-center">
				<a href="javascript:void(0);" class="btn btn-info btn-save-form-setting">
					Lưu
				</a>
				<a href="javascript:void(0);" class="btn btn-default btn-cancel-form-setting">
					Hủy
				</a>
			</div>
		</div>
	</div>
	
</form>


@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	<script>
		var form_setting_submit_url = @json($submit_url);
	</script>
@endsection

{{-- Nhúng js --}}

@section('js')


<script src="{{asset('plugins/nestable2/dist/jquery.nestable.min.js')}}"></script>
<script src="{{asset('static/manager/js/nestable.js')}}"></script>
<script src="{{asset('static/manager/js/form-setting.js')}}"></script>

@endsection
