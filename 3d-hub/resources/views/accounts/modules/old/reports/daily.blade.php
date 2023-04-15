<?php 
$profile = getUser();
$addArgs = [];
$date = request()->date;
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];


?>
@extends($_layout.'master')
@section('title', 'Báo cáo Hàng ngày')
@section('header_title', 'Báo cáo Hàng ngày')

@section('show_sidebar', 1)
@section('content')


    <div class="ms-panel" id="report-root">
        <div class="ms-panel-header report-list pb-1">
            <form action="" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-6 col-sm-4 col-md-2 ">
                        <div class="input-group">
                            <input type="text" name="date" id="open-date-input" class="form-control date-picker" placeholder="Ngày mở thưởng" data-format="yy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off">
                            <div class="input-group-append">
                                <label for="open-date-input" class="mt-0 input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
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
                    

                    <div class="col-4 col-sm-4 col-md-2 ">
                        <div class="input-group">
                            @include($_theme.'forms.templates.crazyselect', [
                                'input' => html_input([
                                    'type' => 'crazyselect',    
                                    'name' => 'list_type',
                                    'data' => [
                                        'all' => 'Tất cả',
                                        'match' => 'Trùng khớp',
                                        'win' => 'Thắng'
                                    ],
                                    'value' => 'win'
                                ])
                            ])
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="input-group">
                            <select name="per_page" id="per_page" class="form-control">
                                @foreach($per_pages as $val => $text)
                                <option value="{{$val}}" {{$val == $per_page ? 'selected':''}}>{{$text}}</option>
                                @endforeach
                            </select>
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
    <script src="{{asset('assets/app/js/reports/daily.js')}}"></script>
    <script>

        daily({!! json_encode([
                'data'           => route('reports.daily.data'),
                'download'       => route('reports.daily.download')
            ]) !!});
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    
@endsection