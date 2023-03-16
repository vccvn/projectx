@php
$profile = getUser();
$addArgs = [];
$date = request()->date;
@endphp
@extends($_layout.'master')
@section('title', 'Báo cáo user')
@section('header_title', 'Báo cáo user')

@section('show_sidebar', 1)
@section('content')


    <div class="ms-panel" id="user-root">
        <div class="ms-panel-header user-list">
            @include($_template.'filter.date',[
                'searchable' => [
                    'name' => 'Tên',
                    'email' => 'Email',
                    'branch_name' => 'Nhánh'
                ],
                'sortable' => [
                    'name' => 'Tên',
                    'email' => 'Email',
                    // 'number_count' => 'Số con cược',
                    // 'win_count' => 'Số con thắng',
                    // 'betting_total_point' => 'Tổng điểm cược',
                    // 'win_points' => 'Tổng điểm thắng'
                ]
            ])
        </div>
        <div class="ms-panel-body user-list ">
            
            <div class="final-step">
                <div class="table-responsive">
                    <table id="users" class="table table-bordered thead-primary smarttable" >
    
                    </table>
                </div>    
            </div>


        </div>
        <div class="ms-panel-header user-detail">
            <h5>
                <a href="javascript:void90)" class="btn btn-primary btn-back py-1 px-2 mr-2"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <strong id="user-name"></strong>
            </h5>
        </div>
        
        <div class="ms-panel-body user-detail ">
            
            <p> Thông tin cược chi tiết</p>
            <div class="">
                
                <div class="table-responsive">
                    <table id="user-detail" class="table table-bordered thead-primary smarttable" >
    
                    </table>
                </div>
            </div>
            

        </div>
    </div>
    
@endsection


@section('css')
    <style>
        
        #user-root .user-detail, #user-root.show-detail .user-list{
            display: none;
        }#user-root.show-detail .user-detail{
            display: block;
        }
    </style>
@endsection

@section('js')
    <script>

    window.smarttableInit = function(){
        
        var currentID = 0;
        var currentUser = null;
        var currentDate = '';

        var today = App.date('Y-m-d');
        var $list = App.smarttable.setup({
            el: '#users',
            filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('reports.users.list')
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                
                {
                    title: "ID",
                    className: "id-col max-70 text-center hide-xs",
                    sortby: 'id',
                    content: '{$id}'
                },
                
                {
                    title: "Tên",
                    className: "max-120",
                    sortby: 'name',
                    content: '<a href="javascript:void(0);" class="btn-view-user" data-id="{$id}">{$name}</a>'
                },
                {
                    title: "Email",
                    className: "max-150 hide-xs",
                    sortby: 'email',
                    content: '{$email}'
                },
                // {
                //     title: "Nhánh",
                //     className: "max-120 hide-xs",
                //     sortby: 'branch_name',
                //     content: '{$branch_name}'
                // },
                {
                    title: "Số con cược",
                    className: " hide-xs",
                    sortby: 'number_count',
                    content: '{$number_count}'
                },
                {
                    title: "Tổng cược",
                    className: "",
                    sortby: 'total_point',
                    content: '{$total_point}'
                },
                {
                    title: "Số con thắng",
                    className: " hide-xs",
                    // sortby: 'win_count',
                    content: '{$win_count}'
                },
                {
                    title: "Tổng thắng",
                    className: "",
                    // sortby: 'win_points',
                    content: '{$win_points}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                var win_points = 0;
                var number_count = 0;
                var win_count = 0;
                var total_point = 0;
                if(item.bettings && item.bettings.length){
                    // 
                    for (let i = 0; i < item.bettings.length; i++) {
                        const betting = item.bettings[i];
                        number_count+=betting.number_count;
                        var type = betting.type;
                        for (let j = 0; j < betting.numbers.length; j++) {

                            const nb = betting.numbers[j];
                            total_point += Number(betting.points);
                            // win_text.push(nb.number + (nb.match_count > 1 ? " (x"+nb.match_count+")": ""));
                            if(nb.is_win){
                                win_points += ((type.incremental ? nb.match_count : 1) * Number(betting.points) * Number(betting.rate));
                                
                                win_count++;
                            }
                            
                        }
                    }
                // item.total_point = total_point;
                item.win_count = win_count;
                item.win_points = win_points;
                // item.number_count = number_count;    
                }
                
                return item;
            }
        });

        
        var $detail = App.smarttable.setup({
            el: '#user-detail',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('reports.users.detail')
            ]) !!},
            autoload:false,
            columns: [
                {
                    title: 'Number ID',
                    className: "hide-sm",
                    scope: "row",
                    sortby: 'number_id',
                    content: '{$number_id}'
                },
                {
                    title: "Khu vực",
                    className: "hide-xs text-center",
                    content: '{$area_name}'
                },
                {
                    title: "Loại cược",
                    className: " text-center",
                    sortby: 'type_name', 
                    content: '{$type_name}'
                },

                {
                    title: "Nội dung cược",
                    className: " text-center",
                    sortby: 'number', 
                    content: '{$number}'
                },
                {
                    title: "Điểm",
                    className: "text-center",
                    sortby: 'points', 
                    content: '{$points}'
                },
                {
                    title: "Tỷ lệ",
                    className: " text-center",
                    sortby: 'rate', 
                    content: '{$rate}'
                },
                {
                    title: "Số lần trùng khớp",
                    className: "hide-xs text-center",
                    sortby: '$match_count', 
                    content: '{$match_count}'
                },
                {
                    title: "Điểm nhận dược",
                    className: "hide-xs",
                    content: '{$recived_points}'
                },
                {
                    title: "Trạng thái",
                    className: "win-status text-center",
                    sortby: 'is_win', 
                    content: '{$lockdown_status}'
                }
                
            ],
            numberFormat: ['points', 'match_count', 'recived_points', 'user_count'],
            parseItem: function (betting) {
                betting.recived_points = ((betting.incremental ? betting.match_count : 1) * betting.points * betting.rate * betting.is_win);
                if(betting.is_win){
                    betting.lockdown_status = '<a  href="#" data-id="' + betting.id + '"><i class="fa fa-check-circle ms-text-success mr-0"></i></a>';
                }
                
                // betting.recived_points = App.number.currency(betting.recived_points);
             
                return betting;
            },
            transform: function(res){
                if(res.status) return res.data.details;
                else return {};
            },
            handle:{
                prepare: function(data){
                    currentUser = null;
                },
                load: function(res){
                    if(res.status){
                        var data = res.data;
                        var user = data.user;
                        var details = data.details;
                        // $detail.setPagination(data.details);
                        // $detail.renderTableData(details.data);
                        currentUser = user;
                        $('#user-name').html(user.name);
                        $('#user-root').addClass('show-detail');
                        
                    }else{
                        App.Swal.warning(res.message);
                    }
                },
                error : function(err){
                    console.log(err)
                    App.Swal.warning("Lỗi không xác định");
                },
                rendered: function(){
                    var user = currentUser;
                    if(!user) return;
                    if (currentDate && currentDate != today){
                        $('.user-detail .btn-lockdown').remove();
                        $('.user-detail .btn-unlockdown').remove();
                    }
                    else if(user.lockdown && user.lockdown.lockdown_status){
                        $('.user-detail .btn-lockdown').remove();
                    }else{
                        $('.user-detail .btn-unlockdown').remove();
                    }
                    
                }
                
            }
        });
        var url = "{{route("reports.users.detail")}}";
        $(document).on("click", ".btn-view-user", function(e){
            e.preventDefault();
            var id = $(this).data('id');
            if(id){
                $detail.urls.data = url+"?user_id="+id;
                
                var date = $('.user-list #date-input').val();
                if(date){
                    currentDate = date;
                    $detail.urls.data +="&date="+date
                }
                $detail.load({page:1});

            }
        });

        $(document).on("click", ".btn-back", function(e){
            e.preventDefault();
            $('#user-root').removeClass('show-detail');
        })

        

    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection