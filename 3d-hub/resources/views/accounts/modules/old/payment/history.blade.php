@php
$profile = getUser();
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];


@endphp
@extends($_layout.'master')
@section('title', 'Lịch sử thanh toán')
@section('header_title', 'Lịch sử Thanh toán')
@section('show_sidebar', 1)
@section('content')



                    <div class="ms-panel">
                        <div class="ms-panel-body">
                            <form action="" class="filter-form">
                                <div class="form-group row mb-0">
                                    <div class="col-6 col-sm-4 ">
                                        <div class="input-group">
                                            <input type="text" name="date" id="open-date-input" class="form-control daterange" placeholder="Khoảng thời gian" data-format="YYYY-MM-DD" value="" autocomplete="off">
                                            <div class="input-group-append">
                                                <label for="open-date-input" class="mt-0 input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 col-sm-3">
                                        <div class="input-group">
                                            <select name="per_page" id="per_page" class="form-control">
                                                @foreach($per_pages as $val => $text)
                                                <option value="{{$val}}" {{$val == $per_page ? 'selected':''}}>{{$text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-4 text-sm-center text-md-left">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary btn-checkout">
                                                <i class="fa fa-eye"></i> Xem
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="balance" class="table table-bordered thead-primary smarttable" >
                
                                </table>
                            </div>    
                        </div>
                    </div>
@endsection



@section('js')
<script>

    window.smarttableInit = function(){
        
        var currentID = 0;
        var currentReport = null;
        var currentDate = '';

        var today = App.date('Y-m-d');
        var $list = App.smarttable.setup({
            el: '#balance',
            filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'=> route('payment.history.data')
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Thời gian",
                    className: "",
                    sortby: 'created_at',
                    content: '{$created_time}'
                },
                {
                    title: "Phân loại",
                    className: "",
                    sortby: 'type',
                    content: '{$type_text}'
                },
                {
                    title: "Số điểm",
                    className: "",
                    sortby: 'amount',
                    content: '{$amount_text}'
                },
                {
                    title: "Ghi chú",
                    className: "hide-xs",
                    content: '{$note}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                item.amount_text = App.number.currency(item.amount_text);
                return item;
            }
        });
    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection