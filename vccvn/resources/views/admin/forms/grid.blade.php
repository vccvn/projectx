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
	manager_action_menu([
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
@section('module.name', $cfg->title)

@section('content')

<?php $form->addClass('m-form m-form--fit m-form--label-align-right crazy-form');?>
<form {!! $form->attrsToStr() !!}>
    @csrf
	{!! $form->hidden_id !!}
	@if (($successSession = session('success')) || ($errorSession = session('error')) || ($validateError = $errors->first()))
    {{-- lam gi nhu --}}
    @else
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <span class="m-badge m-badge--danger m-badge--dot"></span> Thông tin này bắt buộc phải nhập<br>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    @endif
    

	<div class="row">

		@if ($t = count($cfg->form_groups))
			<?php 
			$lt = $t > 1 ? $cfg->layout_type : 'single';
			?>
			@foreach ($cfg->form_groups as $index => $fgroup)
				@php 
				$group = new Arr($fgroup); 
				$list = $form->notInGroup($group->inputs);
				if(!count($list)) continue;
				@endphp
				
				@include($_base.'forms.grid-section', [
					'list' => $list,
					'group' => $group,
					'group_title' => $group->title,
					'layout_type' => ($group->class=='col-12')?'single':$lt,
					'group_class' => $t > 1 ? $group->class : 'col-12',
					'index' => $index
				])
				
			@endforeach
		@else
			@include($_base.'forms.grid-section', [
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
                <button type="submit" class="btn btn-info btn-submit-form">
                    {{$cfg->save_button_text}}
                </button>
                <a href="{{$cfg->cancel_button_url}}" class="btn btn-secondary">
                    {{$cfg->cancel_button_text}}
                </a>
			</div>
		</div>
	</div>
	
</form>


@if (get_js_data('crazy_form_data', 'include_modal'))
	@include($_base.'forms.modal-tabs')
@endif

	

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

				@include($_template.$template)

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

@endsection

{{-- thiết lập biến cho js để sử dụng --}}
@section('jsinit')
	@if ($cfg->js_vars && is_array($cfg->js_vars))
		<script>
			@foreach($cfg->js_vars as $name => $value)
				@if(!is_numeric($name) && strlen($name))

				var {[$name]} = {!! is_numeric($value)?$value:json_encode($value) !!};

				@endif
			@endforeach
		</script>
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

	@if (isset($errorSession) && $errorSession)
		<script>
			App.Swal.error(@json($errorSession));
		</script>
	@elseif (isset($validateError) && $validateError)
		<script>
			App.Swal.error("Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin");
		</script>
	@endif

@endsection