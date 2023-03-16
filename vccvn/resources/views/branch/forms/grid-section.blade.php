<?php
use Crazy\Helpers\Arr;
?>
    
    
    
    <div class="col-12 {{$group_class}}" data-class="{{$group_class}}">
<?php
$l_type = (isset($layout_type) && in_array($layout_type, ['single', 'column']))?$layout_type:'single';

// danh sach addon
$input_addons = ['checkbox'];


$class_list = [
    'single' => [
        'from_group' => 'row',
        'label' => 'col-lg-2 col-form-label',
        'wrapper' => 'col-lg-8'
    ],
    'column' => [
        'from_group' => '',
        'label' => '',
        'wrapper' => ''
    ],
];
$lbl_class = isset($label_class)?$label_class:$class_list[$l_type]['label'];
$wrp_class = isset($wrapper_class)?$wrapper_class:$class_list[$l_type]['wrapper'];
$group_class = isset($from_group_class)?$from_group_class:$class_list[$l_type]['from_group'];


// danh sach addon
$input_addons = ['checkbox'];

?>
        <!--begin::Portlet-->
        <div class="m-portlet grid-section">
            <div class="m-portlet__head form-grid-header">
                <div class="m-portlet__head-caption group-title">
                    <div class="m-portlet__head-title grid-group-title">
                        <h3 class="m-portlet__head-text">
                            <span class="title-text">
                                @if (isset($group_title))
                                    {{$group_title}}
                                @endif
                            </span>
                            
                        </h3>
                        
                    </div>
                    
                </div>
                

            </div>
            <div class="m-portlet__body">
                
                    @foreach ($list as $input)
                    <?php
                    $type = strtolower($input->type);
                    $g_class = $group_class;
                    $l_class = $lbl_class;
                    $w_class = $wrp_class;
                    if($input->data('group-type') == 'inline'){
                        $g_class = 'row';
                        $l_class = 'col-lg-2 col-form-label';
                        $w_class = 'col-lg-8';
                        
                    }
                    $options = $input->hiddenData('options');
                    if(is_array($options)){
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
                        <div class="form-group {{$g_class}} {{$input->error?'has-danger':''}}" id="{{$input->id}}-form-group">
                            <label class="{{$l_class}}" for="{{$input->id}}" >
                                {{$input->label}}
                                @if ($input->required && !in_array($input->required, ["0", "false", "no"]))
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
                                ?>
                                
                
                                <div class="{{$input_group_class}} {{$input->type}} input-{{$input->type}}-group {{$addon_class}}" id="input-{!! $input->id !!}-group">
                                    {{-- prepend addon group --}}
                                    @if ($input->prependGroup)
                                        @foreach ($input->prependGroup as $addon)
                                            <div class="input-group-prepend">
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
                                    @if ($input->prepend_text)
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{!!$input->prepend_text!!}</span>
                                        </div>
                                    @endif
                
                                    {{-- nếu có tempplate và (kieu input phai bang hoac nam trong danh sach cua tem plate do) --}}
                                    @if($is_template)
                                        @include($_current.'templates.'.$input->template)
                                    
                                    @elseif ($input->type == 'file')
                                        <div class="custom-file">
                                            <?php $input->addClass('custom-file-input'); ?>
                                            {!! $input !!}
                                            <label class="custom-file-label selected" for="{{$input->id}}">{{$input->val()?$input->val():'Chưa có file nào dc chọn'}}</label>
                                        </div>
                                    
                                    @elseif(in_array($type, ['checkbox', 'radio', 'checklist']))
                                        <div class="checkbox-radio {{$input->data('display') == 'list'?'display-list':"display-inline"}}">
                                            {!! $input !!}
                                        </div>
                                    @else
                                    
                                        {!! $input !!}    
                                    @endif
                
                                    {{-- prepend --}}
                                    @if ($input->append_text)
                                        <div class="input-group-append">
                                            <span class="input-group-text">{!!$input->append_text!!}</span>
                                        </div>
                                    @endif
                                    @if ($input->appendGroup)
                                        @foreach ($input->appendGroup as $addon)
                                            <div class="input-group-append">
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
                                <div class="form-control-feedback input-message-alert" id="input-{!! $input->id !!}-message-alert">{{$input->error}}</div>    
                                
                                
                            </div>
                            {{-- end input group --}}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!--end::Portlet-->
    </div>
