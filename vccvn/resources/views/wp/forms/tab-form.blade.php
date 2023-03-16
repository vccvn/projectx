<?php
// su dung thu vien
use Crazy\Helpers\Arr;
use Crazy\Html\Html;
use Crazy\Html\Form;
use Crazy\Html\Input;

// cac bien
// form config
$cfg = new Arr($config??[]);

$layout_column = ($cfg->layout_type == 'column');
$xform = new Html('form', null, isset($attrs)?$attrs:[]);
if($form->has(['type' => 'file'])){
    $xform->attr('enctype', 'multipart/form-data');
}
?>

<?php $xform->addClass('m-form m-form--fit m-form--label-align-left crazy-form');?>
<!--begin::Form-->
<form {!! $xform->attrsToStr() !!}>
    @csrf
    <!-- {{$errors->first()}} -->
            
    <div class="form-inputs mb-4">
        <div class="row {{$cfg->form_group_style ==  'custom' ? '': ' group form-group m-form__group pl-0 pr-0'}}">
            @if ($layout_column && count($cfg->form_groups))
                @foreach ($cfg->form_groups as $column)
                    @php $group = new Arr($column); @endphp
                    <div class="col-12 {{$group->class}}">
                        @include($_base.'forms.master-inputs', [
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
                    @include($_base.'forms.master-inputs', [
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