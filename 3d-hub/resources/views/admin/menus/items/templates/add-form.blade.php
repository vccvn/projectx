

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Thêm Item
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body p-0">

            <!--begin::Section-->
            <div class="m-accordion m-accordion--bordered" id="crazy-menu-detail" role="tablist">

                @foreach ($itemGroups as $type => $group)
                    <?php
                    $group_ext = null;
                    $group_type = $type;
                    $form_inputs = $group['inputs'];
                    $hidden = [
                        'name' => 'type',
                        'type' => 'hidden',
                        'value' => $type
                    ];
                    if(is_numeric($type)){
                        $group_type = 'post_category';
                        $group_ext = '-'.$type;

                        $hidden['value'] = 'post_category';
                        $form_inputs['ref'] = [
                            'name' => 'ref',
                            'type' => 'hidden',
                            'value' => 'post_category'
                        ];
                        $form_inputs['ref_id'] = [
                            'name' => 'ref_id',
                            'type' => 'hidden',
                            'value' => $type
                        ];
                    }elseif (substr($type,0, 4) == 'post') {
                        $group_type = 'post';
                        $group_ext = '-'.$group['dynamic_id'];

                        $hidden['value'] = 'post';
                        $form_inputs['ref'] = [
                            'name' => 'ref',
                            'type' => 'hidden',
                            'value' => 'post'
                        ];
                        $form_inputs['ref_id'] = [
                            'name' => 'ref_id',
                            'type' => 'hidden',
                            'value' => $group['dynamic_id']
                        ];
                    }
                    $form_inputs['type'] = $hidden;
                    $args = [
                        'inputs' => $form_inputs,
                        'data' => [],
                        'errors' => $errors
                    ];
                    $input_options = ['className'=>'form-control m-input'];
                    $form = html_form($args, $input_options, [
                        'method' => 'POST',
                        'action' => route($route_name_prefix . 'menus.items.save', ['menu_id' => $menu->id]),
                        'class' => 'add-menu-item-form'
                    ]);
                    $form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file', 'hidden']])->map('removeClass', ['form-control', 'm-input']);
                    $form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
                    $form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
                    $form->data('prefix', 'add-'.$group_type.$group_ext);
                    // dd($form);
                    $inputs = $form->notInGroup(array_keys($form_inputs))
                    ?>
                <!--begin::Item-->
                <div class="m-accordion__item">
                    <div class="m-accordion__item-head collapsed" role="tab" id="crazy-menu-detail_item_{{$type}}_head" data-toggle="collapse" href="#crazy-menu-detail_item_{{$type}}_body" aria-expanded="false">
                        <span class="m-accordion__item-icon">
                            <i class="fa {{$group['icon']}}"></i>
                        </span>
                        <span class="m-accordion__item-title">{{$group['text']}}</span>
                        <span class="m-accordion__item-mode"></span>
                    </div>
                    <div class="m-accordion__item-body collapse" id="crazy-menu-detail_item_{{$type}}_body" class=" " role="tabpanel" aria-labelledby="crazy-menu-detail_item_{{$type}}_head" data-parent="#crazy-menu-detail">
                        <div class="m-accordion__item-content">
                            <form {!! $form->attrsToStr() !!}>
                                @csrf
                            
                                @foreach ($inputs as $input)
                                    @if ($input->hidden)
                                        @continue
                                    @endif
                                    <?php
                                    $g_class = '';
                                    $l_class = '';
                                    $w_class = '';
                                    
                                    $input->id = 'add-'.$group_type.$group_ext . '-'.$input->id;
                                    
                                    ?>
                                    @if ($input->type=='hidden')
                                        {!! $input !!}
                                    @else
                                        <div class="mt-1 mb-4 crazy-form-group item-{{$input->name}}-group {{$g_class}} {{$input->error?'has-danger':''}}" id="{{$input->id}}-form-group">
                                            <label class="{{$l_class}}" for="{{$input->id}}" >
                                                {{$input->label}}
                                                @if ($input->required && !in_array($input->required, ["0", "false"]))
                                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                                @endif
                                                
                                            </label>
                                            <div class="{{$w_class}}">

                                                <?php
                                                    $is_template = is_support_template($input->template, $input->type);
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
                                                                        @include('admin.forms.addons.'.$addon->type, ['input'=>$addon])
                                                                    @elseif(is_support_template($addon->template, $addon->type))
                                                                        @include('admin.forms.templates.'.$addon->template, ['input'=>$addon])
                                                                    @else
                                                                        {!! $addon !!}
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="col-md">
                                                @endif



                                                @if ($input_group_class)
                                                    @include('admin.forms.group-addon')
                                                @else
                                                    @include('admin.forms.form-input')
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
                                                                    @include('admin.forms.addons.'.$addon->type, ['input'=>$addon])
                                                                @elseif(is_support_template($addon->template, $addon->type))
                                                                    @include('admin.forms.templates.'.$addon->template, ['input'=>$addon])
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
                                <div class="buttons">
                                    <button type="submit" class="btn btn-info">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!--end::Item-->

            </div>


            <!--end::Section-->
        </div>


        
    </div>
