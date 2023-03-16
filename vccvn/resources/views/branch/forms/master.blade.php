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
			<div class="m-portlet m-portlet--head-sm" m-portlet="true">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								{{$cfg->title}}
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
									<i class="la la-expand"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<?php $form->addClass('m-form m-form--fit m-form--label-align-left crazy-form');?>
				<!--begin::Form-->
				<form {!! $form->attrsToStr() !!}>
					@csrf
					{{-- <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $data->id)}}"> --}}
					{!! $form->hidden_id !!}
					<div class="m-portlet__body">
						@if (($successSession = session('success')) || ($errorSession = session('error')) || ($validateError = $errors->first()))
						<div class="form-group m-form__group m--margin-top-10">
							
								<!-- {{$errors->first()}} -->
							{{-- @else
							<div class="alert m-alert m-alert--default" role="alert">
								<span class="m-badge m-badge--danger m-badge--dot"></span> Thông tin này bắt buộc phải nhập<br>
							</div> --}}
							
						</div>
						@endif
						<div class="form-inputs">
							<div class="row form-group m-form__group">
								@if ($layout_column && count($cfg->form_groups))
									@foreach ($cfg->form_groups as $column)
										@php $group = new Arr($column); @endphp
										<div class="col-12 {{$group->class}}">
											@include($_current.'master-inputs', [
												'list'=>$form->notInGroup($group->inputs),
												'group' => $group,
												'group_title' => $group->title,
												'layout_type' => $cfg->layout_type
											])
										</div>
									@endforeach
								@else
									<div class="col-12">
										@include($_current.'master-inputs', [
											'list'=>$form->notInGroup(),
											'group' => new Arr(),
											'layout_type' => $cfg->layout_type
										])
									</div>
								@endif
							</div>
							

						</div>
					</div>
					<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
								<div class="col-lg-12 text-center">
									<button type="submit" class="btn btn-info btn-submit-form">
										{{$cfg->save_button_text}}
									</button>
									<a href="{{$cfg->cancel_button_url}}" class="btn btn-secondary">
										{{$cfg->cancel_button_text}}
									</a>
								</div>
								
								
                            </div>
                        </div>
                    </div>
				</form>

				<!--end::Form-->
			</div>
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
		@include($_current.'modal-tabs')
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
	@if (isset($errorSession) && $errorSession)
		<script>
			App.modal.error(@json($errorSession));
		</script>
	@elseif (isset($validateError) && $validateError)
		<script>
			App.modal.error("Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin");
		</script>
	@endif
@endsection
