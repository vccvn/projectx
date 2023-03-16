
{{-- nếu có tempplate và (kieu input phai bang hoac nam trong danh sach cua template do) --}}
@if($is_template)
    @include($_base.'forms.templates.'.$input->template)
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