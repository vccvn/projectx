
<div class="col-xl-{{$data->col_xl(2)}} col-lg-{{$data->col_lg(3)}} col-md-{{$data->col_md(4)}} col-sm-{{$data->col_sm(6)}} col-sm-{{$data->col_xs(12)}}  {{$data->class}} ">
    <div class="footer-links">
        {!!
            $helper->getCustomMenu(['id' => $data->menu_id], 1, [
                'class' => 'footer-menu '.$data->menu_class
            ])->addAction(function($item, $link){
              $link->rel='nofollow';
            })
        !!}
    </div>
</div>