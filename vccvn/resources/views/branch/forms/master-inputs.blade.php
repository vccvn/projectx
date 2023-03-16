<?php
// su dung thu vien
use Crazy\Helpers\Arr;

// layout type chuẩn
$l_type = (isset($layout_type) && in_array($layout_type, ['single', 'column']))?$layout_type:'single';
// class theo layout type
$class_list = [
    'single' => [
        'from_group' => 'row',
        'label' => 'col-lg-3 col-xl-2 col-form-label',
        'wrapper' => 'col-lg-9 col-xl-10'
    ],
    'column' => [
        'from_group' => '',
        'label' => '',
        'wrapper' => ''
    ],
];
// class mặc định
$lbl_class = isset($label_class)?$label_class:$class_list[$l_type]['label'];
$wrp_class = isset($wrapper_class)?$wrapper_class:$class_list[$l_type]['wrapper'];
$group_class = isset($from_group_class)?$from_group_class:$class_list[$l_type]['from_group'];


// danh sach addon
$input_addons = ['checkbox'];
?>

@if((isset($group_title) && $group_title) || $l_type != 'single')

    {{-- gtoup title --}}
    <div class="m-form__heading mt-2 pl-0 pr-0">
        <h3 class="m-form__heading-title">
            @if (isset($group_title))
                {{$group_title}}
            @else
                <span class="text-white">
                    <i class="fa fa-info"></i>
                </span>
            @endif
        </h3>
    </div>

@endif

@foreach ($list as $input)
    @if ($input->hidden)
        @continue
    @endif
    <?php
    $type = strtolower($input->type);
    $g_class = $group_class; // group class
    $l_class = $lbl_class; // label class
    $w_class = $wrp_class; // input wrapper class


    if($group->type == 'inline'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
        
    }

    if($cfg->lock_style){
        // cha lam gi ca
    }
    elseif($input->data('group-type') == 'metronic'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
        
    }
    elseif($input->data('group-type') == 'inline'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-8';
        
    }

    // ghi de
    if($cfg->lock_style){
        // cha lam gi ca
    }
    elseif(is_array($options = $input->hiddenData('options'))){
        $opts = new Arr($options);
        if($opts->form_group_class){
            $g_class = $opts->form_group_class;
        }
        if($opts->label_class){
            $l_class = $opts->label_class;
        }
        if($opts->wrapper_class){
            $w_class = $opts->wrapper_class;
        }
    }
    elseif($input->hiddenData('group-type') == 'metronic'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
    }
    elseif ($input->type=='switch' || $input->template=='switch') {
        $g_class = 'row';
        $l_class = 'col-6 col-sm-4 col-md-3 col-lg-2 col-form-label';
        $w_class = 'col-6 col-sm-2 col-md-3 col-lg-4';
        if($l_type = 'column'){
            $l_class = 'col-6 col-form-label';
            $w_class = 'col-6';
        
        }
    }
    ?>
    @if ($input->type=='hidden')
        {!! $input !!}
    @else
        <div class="mt-1 mb-4 crazy-form-group {{$g_class}} {{$input->error?'has-danger':''}}" id="{{$input->id}}-form-group">
            <label class="{{$l_class}}" for="{{$input->id}}" >
                {{$input->label}}
                @if ($input->required && !in_array($input->required, ["0", "false"]))
                <span class="m-badge m-badge--danger m-badge--dot"></span>
                @endif
                
            </label>
            <div class="{{$w_class}}">

                <?php
                    $is_template = is_support_template($input->template, $type);
                    $addon_class = '';
                    if($is_template){
                        if($input->template == 'touchspin') $addon_class.= 'bootstrap-touchspin ';
                    }

                    $dig = $input->data('input-group');
                    $input_group_class = ($input->prependGroup || $input->prepend_text || $input->append_text || $input->prepend_button || $input->append_button || $input->appendGroup || ($dig && $dig!='false'))?'input-group':'';
                    $is_input_columns = ($input->prependColumns || $input->appendColumns)?true:false;
                ?>
                
                @if ($is_input_columns)
                    <div class="row">
                        @if ($input->prependColumns)
                            @foreach ($input->prependColumns as $addon)
                            <?php 
                            if($addon->error){
                                set_web_data($input->id. '-error', $addon->error);
                            }
                            ?>
                                <div class="col-md">
                                    @if (in_array($addon->type, $input_addons))
                                        @include($_current.'addons.'.$addon->type, ['input'=>$addon])
                                    @elseif(is_support_template($addon->template, $addon->type))
                                        @include($_current.'templates.'.$addon->template, ['input'=>$addon])
                                    @else
                                        {!! $addon !!}
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        <div class="col-md">
                @endif



                @if ($input_group_class)
                    @include($_current.'group-addon')
                @else
                    @include($_current.'form-input')
                @endif
                
                @if ($is_input_columns)
                        </div>
                    @if ($input->appendColumns)
                        @foreach ($input->appendColumns as $addon)
                            <?php 
                            if($addon->error){
                                set_web_data($input->id. '-error', $addon->error);
                            }
                            ?>
                            <div class="col-md">
                                @if (in_array($addon->type, $input_addons))
                                    @include($_current.'addons.'.$addon->type, ['input'=>$addon])
                                @elseif(is_support_template($addon->template, $addon->type))
                                    @include($_current.'templates.'.$addon->template, ['input'=>$addon])
                                @else
                                    {!! $addon !!}
                                @endif
                            </div>
                        @endforeach
                    @endif
                    </div>
                @endif
                <div class="form-control-feedback input-message-alert" id="input-{!! $input->id !!}-message-alert">{{$input->error??(get_web_data($input->id.'-error')??$input->hiddenData('note'))}}</div>

            </div>
            {{-- end input group --}}
        </div>
    @endif
@endforeach

