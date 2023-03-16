@extends($_layout.'master')
@section('title', "Trang chủ")
    
@section('content')
@if (!$area)
    <div class="alert alert-danger text-center">
        Web Đang Bảo Trì. Vui lòng quay lại sau ít phút!
    </div>
@else

<?php
$numberLabels = ['even', 'odd'];
?>
                    <div class="row">
                        
                        <div class="col-lg-8 order-1">
                            
                            <div class="ms-panel">

                                <input type="hidden" name="area_id" id="area-id" value="{{$area->id}}">
                                <div class="ms-panel-body clearfix {{setting('locktime')<time()?'betting-timeout':''}}">
                                        
                                    @include($_template.'game.play')

                                    @include($_template.'betting-content')
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-12 order-2 order-lg-3">
                            @include($_template.'game.history',[
                                'history' => get_betting_history()
                            ])
                        </div>
                        <div class="col-lg-4 order-3 order-lg-2">
                            @include($_template.'home-sidebar')
                        </div>

                    </div>

@endif  
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


<script src="{{asset('assets/app/js/betting.item.js')}}"></script> 
<script src="{{asset('assets/app/js/game.type.js')}}"></script> 
<script src="{{asset('assets/app/js/game.js')}}"></script> 
@endsection