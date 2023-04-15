
<div class="col-lg-{{$data->col_lg(3)}} col-sm-{{$data->col_sm(6)}}">
    <div class="f_widget link_widget pl_30">
        <h3 class="f_title">{{$data->title('Liên kết')}}</h3>
        {!! 
            $helper->getCustomMenu($data->menu_id, 1, ['class' => 'list-unstyled link_list'])
        !!}
    </div>
</div>