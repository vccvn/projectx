<?php 
$profile = getUser();
$addArgs = [];
$date = request()->date;
?>
@extends($_layout.'master')
@section('title', 'Báo cáo Doanh thu Nhánh')
@section('header_title', 'Báo cáo Doanh thu Nhánh')

@section('show_sidebar', 1)
@section('content')

<div class="row">
    <div class="col-12 col-md-8">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <form action="" class="filter-form">
                    <div class="form-group row mb-0">
                        <div class="col-3 col-sm-4 col-md-2 ">
                            <div class="input-group">
                                {!! 
                                    html_input([
                                        'type' => 'select',
                                        'name' => 'year',
                                        'id' => 'year-input',
                                        'class' => 'form-control',
                                        'data' => get_year_options('vi', 'current', 2020),
                                        'default' => date('Y')
                                    ])
                                !!}
                                
                            </div>
                        </div>
                        <div class="col-3 col-sm-4 col-md-3 ">
                            <div class="input-group">
                                {!! 
                                    html_input([
                                        'type' => 'select',
                                        'name' => 'month',
                                        'id' => 'year-input',
                                        'class' => 'form-control',
                                        'data' => get_month_options('vi'),
                                        'value' => date('m')
                                    ])
                                !!}
                            </div>
                        </div>
                        
                        <div class="col-4 col-sm-4 col-md-2 text-sm-center text-md-left">
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-eye"></i> Xem
                                </button>
                                
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ms-panel-body">
                <div class="tool row mb-2">
                    <div class="col-7 col-sm-9">
                        Chi tiết báo cáo: <span class="tool-btns"></span>
                    </div>
                    <div class="col-5 col-sm-3 text-right">
                        <button type="button" class="btn btn-success btn-download-report">
                            <i class="fa fa-download"></i> Tải về
                        </button>
                    </div>
                </div>
                <div class="final-step">
                    <div class="table-responsive">
                        <table id="reports" class="table table-bordered thead-primary smarttable" >
        
                        </table>
                    </div>    
                </div>
    
    
            </div>
    
        </div>
    
    </div>
    <div class="col-12 col-md-4">
        @include($_template.'branch-card')
    </div>
</div>
    
@endsection



@section('js')
    <script>

    window.smarttableInit = function(){
        
        var currentID = 0;
        var currentUser = null;
        var currentDate = '';

        var today = App.date('Y-m-d');
        var $list = App.smarttable.setup({
            el: '#reports',
            filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('reports.balance.data'),
                'download'       => route('reports.balance.download'),
                
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                
                {
                    title: "Date",
                    className: "hide-xs",
                    // sortby: 'betting_date',
                    content: '{$betting_date}'
                },
                {
                    title: "Thu",
                    className: "",
                    sortby: '',
                    content: '{$point_in}'
                },
                {
                    title: "Chi",
                    className: "",
                    sortby: '',
                    content: '{$point_out}'
                },
                {
                    title: "Lãi",
                    className: "",
                    sortby: '',
                    content: '{$total}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                item.total = item.point_in - item.point_out
                var s = item.betting_year;
                if(item.betting_month){
                    s = (item.betting_month < 10 ? "0" + String(item.betting_month) : item.betting_month) + "/" + s;
                    if(item.betting_day){
                        s = (item.betting_day < 10 ? "0" + String(item.betting_day) : item.betting_day) + "/" + s;
                    }
                }
                item.betting_date = s;
                item.total = App.number.currency(item.total);
                item.point_in = App.number.currency(item.point_in);
                item.point_in = App.number.currency(item.point_in);
                return item;
            }
        });

        
        
        
        $('.btn-download-report').click(function (e) {
            e.preventDefault();
            showLoading(3000);
            var url = $list.urls.download;

            var params = $list.getParams();
            var s = [];
            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const val = params[key];
                    s.push(
                        encodeURIComponent(key) + '=' + encodeURIComponent(val)
                    );
                }
            }
            location.href = url + '?' + s.join("&");
        });
        

    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection
