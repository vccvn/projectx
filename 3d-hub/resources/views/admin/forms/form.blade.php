<?php
// su dung thu vien
use Crazy\Helpers\Arr;
use Crazy\Html\HTML;
use Crazy\Html\Form;
use Crazy\Html\Input;

// cac bien
// form config
$cfg = new Arr($config??[]);
$args = [
	'inputs' => $inputs??[],
	'data' => $data??[],
	'errors' => $errors
];
$input_options = ['className'=>'form-control m-input'];
$form = new Form($args, $input_options, $attrs??[]);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
// dd($form);

$layout_column = ($cfg->layout_type == 'column');
?>

<?php $form->addClass('m-form m-form--fit m-form--label-align-left crazy-form');?>
<!--begin::Form-->
<form {!! $form->attrsToStr() !!}>
    @csrf
    <!-- {{$errors->first()}} -->
            
    <div class="form-inputs">
        <div class="row {{$cfg->form_group_style ==  'custom' ? '': ' group form-group m-form__group pl-0 pr-0'}}">
            @if (is_array($cfg->form_groups) && count($cfg->form_groups))
                @foreach ($cfg->form_groups as $column)
                    @php $group = new Arr($column); @endphp
                    <div class="col-12 {{$group->class}}">
                        @include('admin.forms.master-inputs', [
                            'list'=>$form->notInGroup($group->inputs),
                            'group' => $group,
                            'group_title' => $group->title,
                            'layout_type' => $cfg->layout_type,
                            'cfg' => $cfg
                        ])
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    @include('admin.forms.master-inputs', [
                        'list'=>$form->notInGroup(),
                        'group' => new Arr(),
                        'layout_type' => $cfg->layout_type,
                        'cfg' => $cfg
                    ])
                </div>
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-info btn-submit-form">
                <i class="fa fa-save"></i>
                {{$cfg->save_button_text}}
            </button>
            <a href="{{$cfg->cancel_button_url??'#'}}" class="btn btn-secondary">
                <i class="fa fa-ban"></i>
                {{$cfg->cancel_button_text}}
            </a>
        </div>
        
        
    </div>
</form>