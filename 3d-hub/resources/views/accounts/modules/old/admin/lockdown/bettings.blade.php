<?php 
$profile = getUser();
$addArgs = [];
$date = request()->date;
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];


?>
@extends($_layout.'admin')
@section('title', 'Nội dung cược')
@section('header_title', 'Nội dung cược')

@section('show_sidebar', 1)
@section('content')


    <div class="ms-panel" id="report-root">
        <div class="ms-panel-header report-list pb-1">
            <form action="" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-6  col-sm-4 col-md-3 ">
                        <div class="input-group">
                            <input type="text" name="check_date" id="open-date-input" class="form-control date-picker" placeholder="Ngày mở thưởng" data-format="yy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off">
                            <div class="input-group-append">
                                <label for="open-date-input" class="mt-0 input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
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
                                        'match' => 'Trùng khớp'
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
                    <div class="col-12 col-sm-12 col-md-5 text-sm-center text-md-left">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-checkout">
                                <i class="fa fa-eye"></i> Xem
                            </button>
                            <button type="button" class="btn btn-success btn-download-backup">
                                <i class="fa fa-download"></i> Tải về Dữ liệu offile
                            </button>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="ms-panel-body report-list ">
            <div class="tool mb-2">
                Danh sách cược: <span class="tool-btns"></span>
            </div>
            <div class="final-step">
                <div class="table-responsive">
                    <table id="betting-list" class="table table-bordered thead-primary smarttable" >
    
                    </table>
                </div>    
            </div>


        </div>

        <div class="ms-panel-header report-detail">
            <h5>
                <a href="javascript:void(0);" class="btn btn-primary btn-back py-1 px-2 mr-2"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <strong id="betting-label"></strong>
            </h5>
        </div>
        
        <div class="ms-panel-body report-detail ">
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
        #report-root .report-detail, #report-root.show-detail .report-list{
            display: none;
        }#report-root.show-detail .report-detail{
            display: block;
        }
    </style>
@endsection

@section('js')
    <script>

    window.smarttableInit = function(){
        
        var currentID = 0;
        var currentReport = null;
        var currentDate = '';

        var today = App.date('Y-m-d');
        var $root = $('#report-root');

        var $bettings = App.smarttable.setup({
            el: '#betting-list',
            filterForm: '.filter-form',
            item: {
                id: 'id'
            },
            // checklist: "id",
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.bettings.data'),
                'lock'           => route('admin.bettings.lock'),
                'unlock'         => route('admin.bettings.unlock'),
                'detail'         => route('admin.bettings.detail.data'),
                
            ]) !!},
            pagination: {
                per_page: 25,
                size: 5
            },
            // tools: [
            //     '<a href="javascript:void(0)" class="btn btn-primary btn-lock-all px-2 py-1"><i class="fa fa-lock"></i> Khóa </a> ',
            //     '<a href="javascript:void(0)" class="btn btn-success btn-unlock-all px-2 py-1"><i class="fa fa-unlock"></i> Mở khóa </a> '
            // ],
            columns: [
                {
                    title: "Người chơi",
                    className: "maz-120",
                    sortby: 'user_name',
                    content: '<a href="#" class="btn-view-param" data-param="user_id" data-name="{$user_name}" data-id="{$user_id}">{$user_name}</a>'
                },
                {
                    title: "Khu vực",
                    className: "hide-xs",
                    sortby: 'area_id',
                    content: '<a href="#" class="btn-view-param" data-param="area_id" data-name="{$area_name}" data-id="{$area_id}">{$area_name}</a>'
                },
                {
                    title: "Loại cược",
                    className: "hide-xs",
                    sortby: 'type_name',
                    content: '<a href="#" class="btn-view-param" data-param="betting_type_id" data-name="{$type_name}" data-id="{$betting_type_id}">{$type_name}</a>'
                },
                {
                    title: "Nội dung cược",
                    className: "max-200",
                    // sortby: 'a',
                    content: '<div>{$number}</div>' + 
                            '<div class="d-sm-none">' + 
                                '<strong>Điểm</strong>: {$total_point}<br>' + 
                                '<strong>Thắng</strong>: {$win_points}<br>' + 
                                '<strong>Trạng thái</strong>: {$status_text}' + 
                                '</div>'
                },
                {
                    title: "Số con",
                    className: "hide-sm",
                    sortby: 'number_count',
                    content: '{$number_count}'
                },
                {
                    title: "Tổng Điểm",
                    className: "hide-xs",
                    sortby: 'total_point',
                    content: '{$total_point}'
                },
                {
                    title: "Tổng Thắng",
                    className: "hide-xs",
                    sortby: 'win_points',
                    content: '{$win_points}'
                },
                {
                    title: "Trạng thái",
                    className: "hide-xs",
                    sortby: 'status',
                    content: '{$status_text}'
                },
                {
                    title: "#",
                    className: "",
                    content: '<a href="#" class="btn-view-detail" data-id="{$id}"><i class="fa fa-eye ms-text-success"></i></a>{$actions}'
                }
            ],
            numberFormat: ['number_count', 'total_point', 'win_points', 'user_count'],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                },
                rendered: function(){
                    if(today != $('#open-date-input').val()){
                        $('.btn-lock-all,.btn-unlock-all').remove();
                    }
                }
            },
            parseItem: function(item){
                var str = item.str_numbers;
                if(item.number_count > 1){

                    if(item.number_count > 5){
                        var nbs = str.split(";");
                        if(nbs.length > 1){
                            str = '';
                            var c = [];
                            
                            for (let i = 0; i < 6; i++) {
                                var nb = nbs[i];
                                c.push(String(nb).trim());
                            }
                            str = c.join("; ") + "; ...";
                        }
                    }
                }
                item.number = str;
                // console.log(item.betting_date , today)
                if(item.betting_date == today){
                    if(item.status == 0){
                        item.actions = '<a href="javascript:void(0)" class="btn-lock-item" data-id="'+item.id+'"><i class="fa fa-lock ms-text-primary"></i></a>';
                    }
                    else if(item.status == -1){
                        item.actions = '<a href="javascript:void(0)" class="btn-unlock-item" data-id="'+item.id+'"><i class="fa fa-unlock ms-text-success"></i></a>';
                    }
                }
                return item;
            }
        });
        var bettingDetail = null;
        var $bettingNumbers = App.smarttable.setup({
            el: '#betting-detail',
            // filterForm: '.filter-form',
            item: {
                id: 'id'
            },
            urls: {!! json_encode([
                'data'           => route('admin.bettings.numbers.data'),
                'report'           => route('admin.bettings.report'),
                'unreport'         => route('admin.bettings.unreport'),
                // 'detail'         => route('admin.bettings.detail.data'),
                
            ]) !!},
            autoload: false,
            pagination: {
                per_page: 10,
                size: 5
            },
            // checklist: "id",
            // tools: [
            //     '<a href="javascript:void(0)" class="btn btn-primary btn-report-all px-2 py-1"><i class="fa fa-lock"></i> </a> '
            //     // '<a href="javascript:void(0)" class="btn btn-success btn-unlock-all px-2 py-1"><i class="fa fa-unlock"></i> Mở khóa </a> '
            // ],
            columns: [
                {
                    title: "Nội dung",
                    className: "",
                    sortby: 'number',
                    content: '{$number}'
                },
                {
                    title: "Điểm thắng",
                    className: "",
                    sortby: 'win_points',
                    content: '{$win_points}'
                },
                {
                    title: "Trạng thái",
                    className: "",
                    content: '{$actions}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                },
                rendered: function(){
                    if(today != $('#open-date-input').val()){
                        // $('.btn-report-item,.btn-unlock-all').remove();
                    }
                }
            },
            parseItem: function(item){
                if(item.created_at.substr(0, 10) == today){
                    if(item.is_win){
                        item.actions = '<i class="fa fa-check-circle ms-text-success"></i>';
                    }
                    else if(bettingDetail && bettingDetail.status != 0){
                        
                    }
                    else if(item.is_error == 0){
                        item.actions = '<a href="javascript:void(0)" class="btn-report-item" data-id="'+item.id+'"><i class="fa fa-unlock ms-text-success mr-0"></i></a>';
                    }
                    else{
                        item.actions = '<a href="javascript:void(0)" class="btn-unreport-item" data-id="'+item.id+'"><i class="fa fa-lock ms-text-primary mr-0"></i></a>';
                    }
                }else{
                    if(item.is_win){
                        item.actions = '<i class="fa fa-check-circle ms-text-success"></i>';
                    }
                    else if(bettingDetail && bettingDetail.status != 0){
                        
                    }
                    else if(item.is_error == 0){
                        item.actions = '<i class="fa fa-unlock ms-text-success"></i>';
                    }
                    else{
                        item.actions = '<i class="fa fa-lock ms-text-primary"></i>';
                    }
                }
                
                return item;
            }
        });


        $(document).on("click", ".btn-back", function(e){
            e.preventDefault();
            $root.removeClass('show-detail');
        })
        
        $('.btn-download-backup').click(function (e) {
            e.preventDefault();
            showLoading(3000);
            var url = "{{route('admin.bettings.download')}}";

            location.href = url + '/' + $('#open-date-input').val();
        });
        var $btns = $('.tool-btns');
        $(document).on("click", ".btn-view-param", function(e){
            e.preventDefault();
            var name = $(this).data("name");
            var id = $(this).data("id");
            var param = $(this).data("param");
            if(id){
                $btns.find(".view-"+param+"-span").remove();
                $btns.append(
                    '<span class="view-'+param+'-span ps-border all py-1 px-2">' + name + 
                        ' <a href="#" class="btn-remove-param" data-param="'+param+'">X</a>'+
                    '</span>'
                );
                $bettings.setParam(param, id);
                $bettings.reload();
            }
        });

        $(document).on("click", ".btn-remove-param", function(e){
            e.preventDefault();
            var param = $(this).data("param");
            // var id = $(this).data("area-id");
            $bettings.removeParam(param);
            $(this).parent().remove();
            $bettings.reload();
        });

        
        
        function lockBettings(ids) {
            showLoading();
            App.api.post($bettings.urls.lock, { ids: ids, lock_level: 2 })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                $lock = $bettings.row(id).find('.btn-lock-item');
                                if ($lock.length) {
                                    $lock.after(
                                        '<a class="btn-unlock-item" href="#" data-id="' + id + '"><i class="fa fa-unlock ms-text-success mr-0"></i></a>'
                                    );
                                    $lock.remove();
                                }

                            }
                            App.Swal.success("Đã khóa " + res.data.length + " con ");
                        }
                    } else {
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    hideLoading();
                    App.Swal.error("Lỗi không xác định! Vui lòng thử lại sau giay lát");
                    console.log(err);
                })
        }

        $(document).on("click", ".btn-lock-item", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            App.Swal.confirm("Bạn có chắc chắn muốn khóa con này?", function () {
                lockBettings([id]);
            });
        });



        function unlockBettings(ids) {
            showLoading();
            App.api.post($bettings.urls.unlock, { ids: ids })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                $lock = $bettings.row(id).find('.btn-unlock-item');
                                if ($lock.length) {
                                    $lock.after(
                                        '<a class="btn-lock-item" href="#" data-id="' + id + '"><i class="fa fa-unlock ms-text-primary mr-0"></i> </a>'
                                    );
                                    $lock.remove();
                                }

                            }
                            App.Swal.success("Đã mở khóa " + res.data.length + " con ");
                        }
                    } else {
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    hideLoading();
                    App.Swal.error("Lỗi không xác định! Vui lòng thử lại sau giay lát");
                    console.log(err);
                })
        }

        $(document).on("click", ".btn-unlock-item", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            App.Swal.confirm("Bạn có chắc chắn muốn mở khóa con này?", function () {
                unlockBettings([id]);
            });
        });


        $(document).on("click", ".btn-lock-all", function (e) {
            e.preventDefault();
            var ids = $bettings.getCheckedValues();
            if (!ids.length) return App.Swal.warning("Bạn chưa chọn mục nào!");
            App.Swal.confirm("Bạn có chắc chắn muốn khóa " + ids.length + " con này?", function () {
                lockBettings(ids);
            });
        });

        $(document).on("click", ".btn-unlock-all", function (e) {
            e.preventDefault();
            var ids = $bettings.getCheckedValues();
            if (!ids.length) return App.Swal.warning("Bạn chưa chọn mục nào!");
            App.Swal.confirm("Bạn có chắc chắn muốn mở khóa " + ids.length + " con này?", function () {
                unlockBettings(ids);
            });
        });

        var $bettingInfo = $('#betting-info');
        function viewDetail(id){
            if(id){
                bettingDetail = null;
                App.api.get($bettings.urls.detail, {id: id})
                .then(res => {
                    if(res.status){
                        $bettingNumbers.setParam("betting_id", id);
                        $bettingNumbers.load({page:1});
                        var betting = res.data;
                        bettingDetail = betting;
                        for (const key in betting) {
                            if (betting.hasOwnProperty(key)) {
                                const value = betting[key];
                                $bettingInfo.find('.'+key).html(value);
                                
                            }
                        }
                        var tm = betting.created_at.split("T");
                        $bettingInfo.find('.created_time').html(tm[0] + " " + tm[1].substr(0,8));
                        $root.removeClass('show-list').addClass('show-detail')
                        $('#betting-label').html(betting.type_name + " - " + betting.area_name + " : " + betting.number_text);
                    }else{
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    App.Swal.error("Lỗi không xác định");
                    console.log(err);
                })
            }
        }
        $(document).on("click", ".btn-view-detail", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            viewDetail(id);
        });

        var betting_id = App.request.queryString('bettingID') || "{{$request->id}}";
        if(betting_id){
            viewDetail(betting_id);
        }


        
        function reportBettings(ids) {
            showLoading();
            App.api.post($bettingNumbers.urls.report, { ids: ids, report_level: 2 })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                $report = $bettingNumbers.row(id).find('.btn-report-item');
                                if ($report.length) {
                                    $report.after(
                                        '<a class="btn-unreport-item" href="#" data-id="' + id + '"><i class="fa fa-lock ms-text-primary mr-0"></i> </a>'
                                    );
                                    $report.remove();
                                }

                            }
                            App.Swal.success("Đã khóa " + res.data.length + " con ");
                        }
                    } else {
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    hideLoading();
                    App.Swal.error("Lỗi không xác định! Vui lòng thử lại sau giay lát");
                    console.log(err);
                })
        }

        $(document).on("click", ".btn-report-item", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            App.Swal.confirm("Bạn có chắc chắn muốn khóa con này?", function () {
                reportBettings([id]);
            });
        });



        function unreportBettings(ids) {
            showLoading();
            App.api.post($bettingNumbers.urls.unreport, { ids: ids })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                $report = $bettingNumbers.row(id).find('.btn-unreport-item');
                                if ($report.length) {
                                    $report.after(
                                        '<a class="btn-report-item" href="#" data-id="' + id + '"><i class="fa fa-unlock ms-text-success mr-0"></i></a>'
                                    );
                                    $report.remove();
                                }

                            }
                            App.Swal.success("Đã mở khóa " + res.data.length + " con ");
                        }
                    } else {
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    hideLoading();
                    App.Swal.error("Lỗi không xác định! Vui lòng thử lại sau giay lát");
                    console.log(err);
                })
        }

        $(document).on("click", ".btn-unreport-item", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            App.Swal.confirm("Bạn có chắc chắn muốn mở khóa con này?", function () {
                unreportBettings([id]);
            });
        });


        $(document).on("click", ".btn-report-all", function (e) {
            e.preventDefault();
            var ids = $bettingNumbers.getCheckedValues();
            if (!ids.length) return App.Swal.warning("Bạn chưa chọn mục nào!");
            App.Swal.confirm("Bạn có chắc chắn muốn khóa " + ids.length + " con này?", function () {
                reportBettings(ids);
            });
        });

        $(document).on("click", ".btn-unreport-all", function (e) {
            e.preventDefault();
            var ids = $bettingNumbers.getCheckedValues();
            if (!ids.length) return App.Swal.warning("Bạn chưa chọn mục nào!");
            App.Swal.confirm("Bạn có chắc chắn muốn mở khóa " + ids.length + " con này?", function () {
                unreportBettings(ids);
            });
        });


    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection