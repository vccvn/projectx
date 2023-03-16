@php
$profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Chuyển bảng')
{{-- @section('header_title', 'Chuyển bảng') --}}
@section('content')

<?php
$numberLabels = ['even', 'odd'];
?>


    <div class="ms-panel">
        <div class="ms-panel-body clearfix  p-1 p-md-2 {{time() > setting('transfertime')?'betting-timeout':''}}">
                
            <div class="bramch-betting" id="transfer-screen">
                {{-- <h4>Chuyển bảng</h4> --}}
                <form action="" method="get" id="view-transfer" class="">
                    <div class="row">
                        <div class="col-4 col-md-2 mb-1">
                            {!! 
                                html_input([
                                    'type' => 'select',
                                    'name' => 'area_id',
                                    'id' => 'area-id-input',
                                    'class' => 'form-control',
                                    'data' => $areaOptions
                                ])
                            !!}
                            
                        </div>
                        <div class="col-4 col-md-2 mb-1">
                            {!! 
                                html_input([
                                    'type' => 'select',
                                    'name' => 'type_id',
                                    'id' => 'type-id-input',
                                    'class' => 'form-control',
                                    'data' => $typeOptions
                                ])
                            !!}
                            
                        </div>
                        <div class="col-4 col-md-2 col-lg-1 mb-1">
                            <button class="btn btn-primary mt-0 btn-view-transfer">
                                <i class="fa fa-eye"></i> <span class="d-none d-sm-inline-block text-white">Xem</span>
                            </button>
                            
                        </div>
                        <div class="col-4 col-md-2 col-lg-2 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label for="default-hold" class="input-group-text">Giữ</label>
                                </div>
                                <input type="number" name="hold_point" min="0" id="default-hold"class="form-control" value="{{my_setting('hold_point')}}" placeholder="Gữi lại">
                            </div>
                        </div>
                        <div class="col-8 col-md-3 col-sm-5 mb-1 pt-1">
                            <label class="ms-checkbox-wrap ms-checkbox-primary mr-sm-1 ">
                                <input type="checkbox" id="hidden-no-point" name="hide" value="1" class="checkbox-hidden"> <i class="ms-checkbox-check"></i>
                            </label>
                            <label for="hidden-no-point">Ẩn ô không có điểm</label>    
                        </div>
                    </div>
                    

                </form>


                <div class="no-mp mt-2 transfer-list" id="transfer-smart-table" style="display: none">
                    <div class="transfer-table smart-table st">
                        <div class="st-header d-none d-sm-block">
                            <div class="row">
                                <div class="col-2 col-sm-1 text-center">#</div>
                                <div class="col-10 col-sm-11">
                                    <div class="row">
                                    <?php
                                        for($i = 0; $i < 10; $i ++){
                                            ?>
                                        <div scope="col" class="col text-md-right st-col duoi-<?php echo $i;?>" data-col="<?php echo $i;?>">
                                                                                                                
                                            
                                            <!-- <span><?php echo $i;?></span> -->

                                            <label class="ms-checkbox-wrap ms-checkbox-primary mr-0 mr-sm-1">
                                                <input type="checkbox" name="duoi[]" value="<?php echo $i;?>" class="checkbox-number check-number number-duoi" data-number="<?php echo $i;?>" step="1" min="0"> <i class="ms-checkbox-check"></i>
                                            </label>
                                            <input type="number" name="duoi[]" id="" class="max-25 max-sm-30 max-md-40 max-lg-50 point-number point-duoi" data-number="<?php echo $i;?>" placeholder="Giữ">

                                            
                                        </div>
                                            <?php
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="st-body">
                        <?php
                            for($i = 0; $i < 10; $i ++){
                        ?>
                        <div class="row st-item st-row">
                            <div scope="row" class="col-sm-1 text-center text-sm-left check-col d-none d-sm-block dau-<?php echo $i;?>">
                                <div class="np">
                                    <div class="sp">
                                        <label class="ms-checkbox-wrap ms-checkbox-primary mr-0 mr-sm-1">
                                            <input type="checkbox" name="dau[]" value="<?php echo $i;?>" class="checkbox-number check-number number-dau" data-number="<?php echo $i;?>"> <i class="ms-checkbox-check"></i>
                                        </label>
                                        <!-- <span class="d-block d-sm-inline"><?php echo $i;?><span class="d-inline d-sm-none">0 - <?php echo $i;?>9</span> -->
                                        <input type="number" name="duoi[]" id="" class="max-40 max-lg-50 point-number point-duoi" data-number="<?php echo $i;?>" placeholder="Giữ">
                                    </div>
                                </div>
                            </span>
                            </div>
                            <div class="col-12 col-sm-11">
                                <div class="row">
                                    <?php
                                        for ($j=0; $j < 10; $j++) { 
                                        ?>
                                    <div class="col st-col dau-<?php echo $i;?> duoi-<?php echo $j;?> r-<?php echo $i;?> c-<?php echo $j;?>" data-col="<?php echo $j;?>" data-number="<?php echo $i.$j;?>">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="np">
                                                    <div class="sp">
                                                        <?php echo $i.$j;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 transfer-data">
                                                <div class="points" data-number="<?php echo $i.$j;?>">
                                                    0
                                                </div>
                                                <div class="hold">
                                                    <input type="number" name="hold[<?php echo $i;?>][<?php echo $j;?>]" data-number="<?php echo $i.$j;?>" id="hold-<?php echo $i;?><?php echo $j;?>" min="0" step="1" class="transfer-hold-inp" placeholder="">
                                                </div>
                                                <div class="transfer transfer-item-point" data-number="<?php echo $i.$j;?>">
                                                    0
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>    
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                        <?php
                            }
                        ?>
                        </div>
                    </div>

                </div>



                <div class="no-mp lo3 lo4 xien spsa transfer-list" id="transfer-smart-list" style="display: none">
                    <div class="mt-2 row dt-head">
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-sm-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-md-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-md-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-xl-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-xl-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-xl-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 col-md-2 col-xl-10 d-none d-xl-block">
                            <div class="row">
                                <div class="col-6">Số</div>
                                <div class="col-6">Điểm</div>
                            </div>
                        </div>
                    </div>
                    <div class="transfer-lotto-table" id="transfer-table-numbers">
                        <div class="st-body row">
                            
                        </div>
                    </div>
                </div>
                
                <div class="ps-border top primary pt-2 mt-2">
                    <div class="row">
                        <div class="col-sm-10 col-md-5 col-lg-4 mb-2">
                            <button class="btn btn-primary btn-add-all-jackpot btn-lg">Thêm tất cả</button>
                        </div>
                        <div class="col-sm-10 col-md-7 col-lg-8 ml-auto">
                            <div class="betting-balance">
                                <span>Balance <i class="balance-amount"></i></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            @include($_template.'betting-content')
            {{-- <div class="alert alert-danger text-center">
                Hiện đã quá thời gian Chuyển bảng. Bạn có thể quay lại vào sáng mai
            </div>     --}}
            
        </div>
    </div>
    @include($_template.'game.history',[
        'history' => get_betting_history()
    ])
@endsection


@section('css')
    <style>
        #betting-info tbody tr td[scope="row"]{
            width: 140px;
        }
        #betting-root .betting-detail, #betting-root.show-detail .betting-list{
            display: none;
        }#betting-root.show-detail .betting-detail{
            display: block;
        }
    </style>
@endsection


@section('js')
<script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    <script src="{{asset('assets/app/js/betting.history.js')}}"></script> 
    <script>
        window.bettingHistory = createBettingManager(
            {!! json_encode([
                'data'           => route('betting.history.data'),
                // 'lock'           => route('admin.bettings.lock'),
                // 'unlock'         => route('admin.bettings.unlock'),
                'numbers'        => route('betting.history.numbers.data'),
                'detail'         => route('betting.history.detail.data'),
                'detaildata'     => route('betting.history.detail.data'),
            ]) !!},
            {!! json_encode([
                'data'           => route('betting.history.numbers.data'),
            ]) !!}
        )
    </script>



    <script>
        window.transferInit = function(){
            App.transfer.init({
                config: {!! json_encode(my_setting()) !!},
                types: {!! json_encode(get_my_config()['types']) !!},
                rates: {!! json_encode(get_my_config()['rates']) !!},
                urls: {!! json_encode([
                    'data' => route('betting.transfer.data')
                ]) !!}
            })
        };
    </script>

<script src="{{asset('assets/app/js/betting.item.js')}}"></script> 
<script src="{{asset('assets/app/js/game.type.js')}}"></script> 
<script src="{{asset('assets/app/js/game.js')}}"></script> 
    <script src="{{asset('assets/app/js/betting.transfer.js')}}"></script> 
@endsection