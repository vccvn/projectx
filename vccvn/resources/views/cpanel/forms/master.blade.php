<?php
// su dung thu vien
use Crazy\Helpers\Arr;
use Crazy\Html\HTML;
use Crazy\Html\Form;
use Crazy\Html\Input;

// cac bien
// form config
$cfg = new Arr($form_config);

$data = new Arr($form_data);
array_unshift($form_inputs,[
	'namespace' => 'hidden_id',
	'name' => 'id',
	'id' => 'input-hidden-id',
	'type' => 'hidden',
	'value' => $data->id
]);
$args = [
	'inputs' => $form_inputs,
	'data' => $form_data,
	'errors' => $errors
];
$input_options = ['className'=>'form-control m-input'];
$form = new Form($args, $input_options, $form_attrs);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');

// dd($form);

if($cfg->can_edit_form_config){
	admin_action_menu([
		[
			'url' => $cfg->edit_form_config_url,
			'text' => 'Chỉnh sửa form',
			'icon' => 'fa fa-cog'
		]
	]);
}

$layout_column = $cfg->layout_type == 'column';
?>

@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $cfg->title?$cfg->title:$module_name)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', $module_name?$module_name:$cfg->title)

@section('content')
	<div class="row">
		<div class="col-lg-12">
			@if ($cfg->layout_type != 'tab')
				@include($_base.'forms.master-single')
			@elseif($cfg->form_type == 'multiform')
				@include($_base.'forms.master-tab-multiform')
			@endif
		</div>
	</div>
	@if ($cfg->components)
		@if (!is_array($cfg->components))
			@include($_component.$cfg->components)
		@else
			@foreach ($cfg->components as $blade)
				@include($_component.$blade)
			@endforeach
		@endif
	@endif
	@if ($cfg->templates)
		@if (!is_array($cfg->templates))
			@include($_template.$cfg->templates)
		@else
			@foreach ($cfg->templates as $template)
				@include($_template.$blade)
			@endforeach
		@endif
	@endif
	@if ($cfg->includes)
		@if (!is_array($cfg->includes))
			@include($_base.$cfg->includes)
		@else
			@foreach ($cfg->includes as $include)
				@include($_base.$include)
			@endforeach
		@endif
	@endif
	@if (get_js_data('crazy_form_data', 'include_modal'))
		@include($_base.'forms.modal-tabs')
	@endif

@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	@if ($cfg->js_vars && is_array($cfg->js_vars))
		{!!'<script>'!!}
			@foreach($cfg->js_vars as $name => $value)
				@if(!is_numeric($name) && strlen($name))
				var {[$name]} = {!! is_numeric($value)?$value:json_encode($value) !!};
				@endif
			@endforeach
		{!!'</script>'!!}
	@endif
@endsection

{{-- Nhúng link css --}}
@section('css')
	@if (is_array($cfg->css) && count($cfg->css))
		@foreach ($cfg->css as $css_link)
		<link rel="stylesheet" href="{{is_url($css_link)?$css_link:asset($css_link)}}">
		@endforeach
	@endif
	{{-- <link rel="stylesheet" href="{{asset('css/users.css')}}"> --}}
@endsection

{{-- Nhúng js --}}

@section('js')
	@if ($cfg->js && is_array($cfg->js))
		@foreach ($cfg->js as $ja_src)
			<script src="{{is_url($ja_src)?$ja_src:asset($ja_src)}}"></script>
		@endforeach
	@endif
	@if ($errorSession = session('error'))
		<script>
			App.modal.error(@json($errorSession));
		</script>
	@elseif ($validateError = $errors->first())
		<script>
			App.modal.error("Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin");
		</script>
	@endif
@endsection
