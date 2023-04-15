@php
$profile = getUser();
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

@endphp
@extends($_layout.'master')
@section('title', 'Lịch sử cược')
@section('header_title', 'Lịch sử cược')
@section('show_sidebar', 1)
@section('content')


<div class="ms-panel" id="betting-root">
    <div class="ms-panel-header betting-list pb-1">
        <form action="" class="filter-form">
            <div class="form-group row mb-0">
                <div class="col-6  col-sm-4 col-md-3 ">
                    <div class="input-group">
                        <input type="text" name="check_date" id="open-date-input" class="form-control date-picker" placeholder="Ngày tháng" data-format="yy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off">
                        <div class="input-group-append">
                            <label for="open-date-input" class="mt-0 input-group-text">
                                <i class="fa fa-calendar"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-6  col-sm-4 col-md-3 ">
                    <div class="input-group">
                        @include($_theme.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',    
                                'name' => 'view_mode',
                                'data' => [
                                    'date' => 'Thời gian',
                                    'yesterday' => 'Ngày hôm qua',
                                    'this-week' => 'Tuần này',
                                    'last-week' => 'Tuần trước',
                                    'this-month' => 'Tháng này',
                                    'last-month' => 'Tháng trước'
                                ],
                                'value' => 'date'
                            ])
                        ])
                    </div>
                </div>
                <div class="col-6  col-sm-4 col-md-2 ">
                    <div class="input-group">
                        @include($_theme.'forms.templates.crazyselect', [
                            'input' => html_input([
                                'type' => 'crazyselect',    
                                'name' => 'list_type',
                                'data' => [
                                    'all' => 'Tất cả',
                                    'win' => 'Thắng cược',
                                    'lose' => 'Thua cược'
                                ],
                                'value' => 'all'
                            ])
                        ])
                    </div>
                </div>
                <div class="col-6 col-md-2 hide-xs">
                    <div class="input-group">
                        <select name="per_page" id="per_page" class="form-control">
                            @foreach($per_pages as $val => $text)
                            <option value="{{$val}}" {{$val == $per_page ? 'selected':''}}>{{$text}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-12 col-md-2 text-sm-center text-md-left">
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary btn-checkout">
                            <i class="fa fa-eye"></i> Xem
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="ms-panel-body betting-list ">
        <div class="tool mb-2">
            Lịch sử cược: <span class="tool-btns"></span>
        </div>
        <div class="final-step">
            <div class="table-responsive">
                <table id="betting-list" class="table table-bordered thead-primary smarttable" >

                </table>
            </div>    
        </div>


    </div>

    <div class="ms-panel-header betting-detail">
        <h5>
            <a href="javascript:void(0);" class="btn btn-primary btn-back py-1 px-2 mr-2"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <strong id="betting-label"></strong>
        </h5>
    </div>
    
    <div class="ms-panel-body betting-detail ">
        <div class="row">
            <div class="col-md-5">
                <div class="table-responsive">
                    <table class="table table-bordered thead-primary type-table smart-table" data-title="Cược" id="betting-info">
                        <thead>
                            <tr>
                                <th scope="col">Nhãn</th>
                                <th scope="col">Giá trị</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">Người chơi</td>
                                <td class="user_name"></td>
                            </tr>
                            <tr>
                                <td scope="row">Khu vực</td>
                                <td class="area_name"></td>
                            </tr>
                            <tr>
                                <td scope="row">Loại cược</td>
                                <td class="type_name"></td>
                            </tr>
                            <tr>
                                <td scope="row">Số đặt cược</td>
                                <td class="number_text"></td>
                            </tr>
                            <tr>
                                <td scope="row">Điểm mỗi con</td>
                                <td class="points"></td>
                            </tr>
                            <tr>
                                <td scope="row">Số con</td>
                                <td class="number_count"></td>
                            </tr>
                            <tr>
                                <td scope="row">Tổng điểm</td>
                                <td class="total_point"></td>
                            </tr>
                            <tr>
                                <td scope="row">Thời gian</td>
                                <td class="created_time"></td>
                            </tr>
                            <tr>
                                <td scope="row">Trạng thái</td>
                                <td class="status_text"></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-7">
                <div class="table-responsive">
                    <table id="betting-detail" class="table table-bordered thead-primary smarttable text-sm-center" >
    
                    </table>
                </div>
            </div>
        </div>


    </div>

</div>
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
        createBettingManager(
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
@endsection