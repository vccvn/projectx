@php
$profile = getUser();
$addArgs = [];
$date = request()->date;
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách yêu cầu trả điểm')
@section('content')

    <div class="ms-panel">
        <div class="ms-panel-header">
            @include($_template.'filter.date',[
                'searchable' => [
                    'name' => 'Tên',
                    'email' => 'Email',
                    
                ],
                'sortable' => [
                    'name' => 'Tên',
                    'id' => 'ID',
                    'balance' => 'Số dư',
                    'updated_at' => 'Thời gian Cập nhật'
                ],
                
            ])
        
        </div>
        <div class="ms-panel-body ">
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
                    <table id="requests" class="table table-bordered thead-primary smarttable text-sm-center" >
    
                    </table>
                </div>    
            </div>


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

        var $detail = App.smarttable.setup({
            el: '#requests',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.points.data'),
                'approveall'     => route('admin.lockdown.points.approve-all'),
                'rollbackall'    => route('admin.lockdown.points.rollback-all')
            ]) !!},
            // autoload:false,
            item: {
                id: 'id',
                className: 'smart-item',
                name: 'name',
                amount: 'amount'
            },
            checklist: "id",
            tools: [
                '<a href="javascript:void(0)" class="btn btn-success btn-approve-all-checked px-2 py-1"><i class="fa fa-check-circle"></i> Trả điểm</a> ',
                '<a href="javascript:void(0)" class="btn btn-warning btn-rollback-all-checked px-2 py-1"><i class="fa fa-undo"></i> Hoàn tác  </a> '
            ],
            columns: [
                {
                    title: "Thời gian",
                    className: "hide-xs",
                    content: '<div><strong>Chốt cho ngày:</strong> <br />{$lockdown_date}</div>' + 
                    '<div class="hide-sm"><strong>Thời gian kiểm tra:</strong> <br />{$check_time}</div>' + 
                    '<div class="hide-sm"><strong>Thời gian Chốt sổ:</strong> <br />{$lockdown_time}</div>' 
                },
                {
                    title: "Họ tên",
                    sortby: 'name',
                    content: '{$name}<br>({$email})'
                },
                // {
                //     title: "Email",
                //     className: "max-150 hide-xs",
                //     sortby: 'email',
                //     content: '{$email}'
                // },
                {
                    title: "Nhánh",
                    className: "hide-xs",
                    content: '{$branch}'
                },
                {
                    title: "Điểm",
                    className: "",
                    sortby: 'amount',
                    content: '{$amount}'
                },
                {
                    title: "Trạng thái",
                    className: "status",
                    sortby: 'status',
                    content: '{$status_text}'
                },
                {
                    title: "#",
                    className: "action",
                    content: '{$actions}'
                }
                
            ],
            parseItem: function (item) {
                
                item.amount = App.number.currency(item.amount);
                var actions = '';
                if(item.is_pending){
                    actions +='<a class="btn-action approve" href="#" data-id="'+item.id+'"><i class="fa fa-check-circle ms-text-success"></i></a>' +
                              '<a class="btn-action decline" href="#" data-id="'+item.id+'"><i class="fa fa-ban ms-text-warnibg"></i></a>';
                }else if(item.can_undo){
                    actions +='<a class="btn-action undo" href="#" data-id="'+item.id+'"><i class="fa fa-undo ms-text-success"></i></a>';
                }
                item.actions = actions;
                if(item.approved_at){
                    item.status_text += "<br>" + item.approved_at
                }
                return item;
            }
            
        });
        var idlist = [];
        function approveAll(){
            var list = $detail.getCheckedValues();
            if(list.length == 0){
                App.Swal.warning("Chưa có mục nào được chọn");
            }else{
                showLoading(100000);
            
                App.api.post($detail.urls.approveall, {ids:list}).then(res => {
                    hideLoading();
                    if(res.status){
                        if(App.isArray(res.data) || App.isObject(res.data)){
                            for (const x in res.data) {
                                if (res.data.hasOwnProperty(x)) {
                                    const req = res.data[x];
                                    var $item = $detail.row(req.id);
                                    if($item.length){
                                        var $this = $item.find('.btn-action.approve');
                                        $this.removeClass('approve').addClass("undo").find('i').removeClass('fa-check-circle').addClass('fa-undo');
                                        $item.find('.status').html("Đã duyệt <br>" + req.approved_at);
                                        $item.find('.btn-action.decline').remove();
                                    }
                                    
                                }
                            }
                        }
                    }else{
                        App.Swal.warning(res.message);
                    }
                }).catch(err => {
                    hideLoading();
                    console.log(err);
                })
            }
        }

        function rollbackAll(){
            var list = $detail.getCheckedValues();
            if(list.length == 0){
                App.Swal.warning("Chưa có mục nào được chọn");
            }else{
                showLoading(100000);
            
                App.api.post($detail.urls.rollbackall, {ids:list}).then(res => {
                    hideLoading();
                    if(res.status){
                        if(App.isArray(res.data) || App.isObject(res.data)){
                            for (const x in res.data) {
                                if (res.data.hasOwnProperty(x)) {
                                    const req = res.data[x];
                                    var $item = $detail.row(req.id);
                                    if($item.length){
                                        var $this = $item.find('.btn-action.undo');
                                        $this.removeClass('undo').addClass("approve").find('i').removeClass('fa-undo').addClass('fa-check-circle');
                                        $item.find('.status').html("Chờ duyệt");
                                        $this.parent().append(App.str.eval('<a class="btn-action decline" href="#" data-id="{$id}"><i class="fa fa-ban ms-text-warnibg"></i></a>', req));
                                    }
                                    
                                }
                            }
                        }
                    }else{
                        App.Swal.warning(res.message);
                    }
                }).catch(err => {
                    hideLoading();
                    console.log(err);
                })
            }
        }

        $(document).on("click", ".btn-approve-all-checked", function(){
            approveAll();
        });
        $(document).on("click", ".btn-rollback-all-checked", function(){
            rollbackAll();
        });
        $(document).on("click", ".btn-download-report", function(e){
            e.preventDefault();
            var url = "{{route('admin.lockdown.points.download')}}?date=" + $detail.getParams().date;
            location.href = url;
        });
    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    {{-- <script src="{{asset('assets/app/js/lockdown.js')}}"></script> --}}
    <script>
        paymentOptions = {
            urls: {!! json_encode([
                'approve' => route('admin.lockdown.points.approve'),
                'decline' => route('admin.lockdown.points.decline'),
                'undo'    => route('admin.lockdown.points.undo')
                
            ]) !!}
        }
    </script>
    <script src="{{asset('assets/app/js/app.payment.js')}}"></script>
        
@endsection