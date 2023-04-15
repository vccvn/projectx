<div class="{{$input_group_class}} {{$input->type}} input-{{$input->type}}-group {{$addon_class}}" id="input-{!! $input->id !!}-group">
    {{-- prepend addon group --}}
    @if ($input->prependGroup)
        @foreach ($input->prependGroup as $addon)
        <?php 
        if($addon->error){
            set_web_data($input->id. '-error', $addon->error);
        }
        ?>
            <div class="input-group-prepend">
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
    
    @if ($input->prepend_text)
        <div class="input-group-prepend">
            <span class="input-group-text">{!!$input->prepend_text!!}</span>
        </div>
    @endif

    @if ($input->prepend_button && is_array($input->prepend_button))
        <div class="input-group-prepend">
            <?php
                $btn_params = $input->prepend_button;
                $btn_content = isset($btn_params['content'])?$btn_params['content']:null;
                unset($btn_params['content']);
                $button = html('button', $btn_content, $btn_params);
                echo $button;
            ?>
        </div>
    @endif

    @include('admin.forms.form-input')

    {{-- prepend --}}
    
    @if ($input->append_button && is_array($input->append_button))
        <div class="input-group-prepend">
            <?php
                $btn_params = $input->append_button;
                $btn_content = isset($btn_params['content'])?$btn_params['content']:null;
                unset($btn_params['content']);
                $button = html('button', $btn_content, $btn_params);
                echo $button;
            ?>
        </div>
    @endif

    @if ($input->append_text)
        <div class="input-group-append">
            <span class="input-group-text">{!!$input->append_text!!}</span>
        </div>
    @endif
    @if ($input->appendGroup)
        @foreach ($input->appendGroup as $addon)
        <?php 
        if($addon->error){
            set_web_data($input->id. '-error', $addon->error);
        }
        ?>
            <div class="input-group-append">
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