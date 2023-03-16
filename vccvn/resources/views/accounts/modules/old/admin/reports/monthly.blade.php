<?php 
$profile = getUser();
$addArgs = [];
$date = request()->date;
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];


?>
@extends($_layout.'admin')
@section('title', 'Báo cáo hằng tháng')
@section('header_title', 'Báo cáo hằng tháng')

@section('show_sidebar', 1)
@section('content')


    <div class="ms-panel" id="report-root">
        <div class="ms-panel-header report-list pb-1">
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
                    <div class="col-3 col-sm-4 col-md-2 ">
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
                    <div class="col-3 col-sm-4 col-md-2 ">
                        <div class="input-group">
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
                    </div>
                    <div class="col-3 col-sm-4 col-md-2 ">
                        <div class="input-group">
                            {!! 
                                html_input([
                                    'type' => 'select',
                                    'name' => 'betting_type_id',
                                    'id' => 'type-id-input',
                                    'class' => 'form-control',
                                    'data' => $typeOptions
                                ])
                            !!}
                        </div>
                    </div>
                    

                    <div class="col-4 col-sm-4 col-md-2 text-sm-center text-md-left">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-checkout">
                                <i class="fa fa-eye"></i> Xem
                            </button>
                            
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="ms-panel-body report-list ">
            <div class="tool row mb-2">
                <div class="col-sm-9">
                    Chi tiết báo cáo: <span class="tool-btns"></span>
                </div>
                <div class="col-sm-3 text-right">
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
    
@endsection


@section('css')
    <style>
        
        #report-root .report-detail, #report-root.show-detail .report-list{
            display: none;
        }#report-root.show-detail .report-detail{
            display: block;
        }
    </style>
@endsection

@section('js')


    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    <script src="{{asset('assets/app/js/reports/monthly.js')}}"></script>
    <script>

        daily({!! json_encode([
                'data'           => route('admin.reports.monthly.data'),
                'download'       => route('admin.reports.monthly.download')
            ]) !!});
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    
@endsection