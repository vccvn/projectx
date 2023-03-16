    
    <div class="modal fade menu-item-modal" id="menu-item-modal-{{$group_type}}{{$group_ext}}" tabindex="-1" role="dialog" aria-labelledby="{{$group_type}}{{$group_ext}}-item-modal-title">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="{{route($route_name_prefix.'menus.items.save', ['menu_id' => $menu->id])}}" method="POST" class="update-menu-item-form" data-prefix="{{$group_type}}{{$group_ext}}">
                    @csrf
                    <input type="hidden" name="id" id="{{$group_type}}{{$group_ext}}-id" value="">
    
                    <div class="modal-header custom-style bg-info">
                        <h5 class="modal-title" id="{{$group_type}}{{$group_ext}}-item-modal-title">
                            <i class="fa fa-info-circle"></i>
                            <span>Cập nhật item</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($inputList as $input)
                        @if ($input->hidden)
                            @continue
                        @endif
                        <?php
                            $g_class = 'form-group row';
                            $l_class = 'col-md-4 col-lg-3 col-form-label';
                            $w_class = 'col-md-8 col-lg-9';
                            $intype = strtolower($input->type);
                            $input->id = $group_type.$group_ext . '-'.$input->id;
                            if($input->name == 'icon'){
                                $input->attr('data-modal-id', 'menu-item-modal-'.$group_type.$group_ext);
                            }
                        ?>
                        @if ($input->type=='hidden')
                            {!! $input !!}
                        @else
                            <div class="mt-1 mb-4 crazy-form-group item-{{$input->name}}-group {{$g_class}} {{$input->error?'has-danger':''}}" id="{{$input->id}}-form-group" data-modal-id="menu-item-modal-{{$group_type}}{{$group_ext}}">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Lưu</button>
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        