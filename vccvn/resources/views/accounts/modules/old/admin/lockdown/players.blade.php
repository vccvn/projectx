@php
$profile = getUser();
$addArgs = [];
$date = request()->date;
@endphp
@extends($_layout.'admin')
@section('title', 'Danh sách Người chơi trong ngày')
@section('content')

    <div class="ms-panel" id="user-root">
        <div class="ms-panel-header user-list">
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
        <div class="ms-panel-body user-list ">
            
            <div class="final-step">
                <div class="table-responsive">
                    <table id="users" class="table table-bordered thead-primary type-table smart-table text-sm-center" >
    
                    </table>
                </div>    
            </div>

            <div class="alert alert-danger">
                <strong>Chú ý:</strong>  Mọi hành động ở đây có thể ảnh ảnh hưởng tới việc duyệt và trả điểm. Hãy cân nhắc mọi hành động và đối chiếu với chức năng trả điểm
            </div>


        </div>
        <div class="ms-panel-header user-detail">
            <h5>
                <a href="javascript:void90)" class="btn btn-primary btn-back py-1 px-2 mr-2"><i class="fa fa-arrow-left"></i> Quay lại</a>
                <strong id="user-name"></strong>
            </h5>
        </div>
        
        <div class="ms-panel-body user-detail ">
            

            <div class="">
                <p> Thông tin cược chi tiết</p>
                <div class="table-responsive">
                    <table id="user-detail" class="table table-bordered thead-primary type-table smart-table text-sm-center" >
    
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
        
    window.lockdownInit = function(){

        var currentID = 0;
        var currentUser = null;
        var currentDate = '';

        var today = App.date('Y-m-d');

        var $lockdown = App.setFinishStep({
            el: '#users',
            filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.data-all'),
                'lockdownAll'    => route('admin.lockdown.lockdown.all'),
                'lockdown'       => route('admin.lockdown.lockdown'),
                'unlockdown'     => route('admin.lockdown.unlockdown'),
                'detail'         => route('admin.lockdown.players.detail'),
            ]) !!},
            handle: {
                rendered: function(){
                    if (currentDate && currentDate != today){
                        $('.user-list .btn-lockdown-all').remove();
                        $('.user-list .btn-unlockdown-all').remove();
                    }
                    
                }
            }

            
        });
        var $detail = App.smarttable.setup({
            el: '#user-detail',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.players.detail.data')
            ]) !!},
            autoload:false,
            tools: [
                '<a href="javascript:void(0)" class="btn btn-success btn-lockdown px-2 py-1"><i class="fa fa-check-circle"></i> Khóa sổ </a> ',
                '<a href="javascript:void(0)" class="btn btn-warning btn-unlockdown px-2 py-1"><i class="fa fa-undo"></i> Hoàn tác </a> '
            ],
            columns: [
                {
                    title: 'Number ID',
                    className: "hide-sm",
                    // scope: "row",
                    content: '{$number_id}'
                },
                {
                    title: "Khu vực",
                    className: "hide-xs",
                    content: '{$area_name}'
                },
                {
                    title: "Loại cược",
                    className: "",
                    content: '{$type_name}'
                },

                {
                    title: "Nội dung cược",
                    className: "",
                    content: '{$number}'
                },
                {
                    title: "Điểm",
                    className: "",
                    content: '{$points}'
                },
                {
                    title: "Tỷ lệ",
                    className: "",
                    content: '{$rate}'
                },
                {
                    title: "Số lần trùng khớp",
                    className: "hide-xs",
                    content: '{$match_count}'
                },
                {
                    title: "Điểm nhận dược",
                    className: "hide-xs",
                    content: '{$recived_points}'
                },
                {
                    title: "Trạng thái",
                    className: "win-status",
                    content: '{$lockdown_status}'
                }
                
            ],
            numberFormat: ['points', 'recived_points', 'rate', 'user_count'],

            parseItem: function (betting) {
                betting.recived_points = ((betting.incremental ? betting.match_count : 1) * betting.points * betting.rate);
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
        var url = "{{route("admin.lockdown.players.detail.data")}}";
        $(document).on("click", ".btn-view-user", function(e){
            e.preventDefault();
            var id = $(this).data('id');
            if(id){
                $detail.urls.data = url+"?user_id="+id;
                
                var date = $('.user-list #date-input').val();
                if(date){
                    currentDate = date;
                    $detail.urls.data += url+"&date="+date
                }
                $detail.load({page:1});

            }
        });

        $(document).on("click", ".btn-back", function(e){
            e.preventDefault();
            $('#user-root').removeClass('show-detail');
        })

        $(document).on("click", '.user-detail .btn-lockdown', function(e){
            showLoading(1000000);
            App.api.post($lockdown.urls.lockdown, {ids:[currentID]})
                .then(res => {
                    if(res.status){
                        if(res.data && res.data.length){
                            res.data.map(function(user){
                                var uid = user.id;
                                $('.user-detail .btn-lockdown').remove();
                            });
                            App.Swal.success("Đã trả điểm user thành công");    
                        }
                        else{
                            App.Swal.warning("Lỗi không xác định");
                        }
                    }
                    else{
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    App.Swal.warning("Lỗi không xác định");
                });
        });
        $(document).on("click", '.user-detail .btn-unlockdown', function(e){
            showLoading(1000000);
            App.api.post($lockdown.urls.unlockdown, {ids:[currentID]})
                .then(res => {
                    if(res.status){
                        if(res.data && res.data.length){
                            res.data.map(function(user){
                                var uid = user.id;
                                $('.user-detail .btn-unlockdown').remove();
                            });
                            App.Swal.success("Đã hoàn tác trả điểm user thành công");    
                        }
                        else{
                            App.Swal.warning("Lỗi không xác định");
                        }
                    }
                    else{
                        App.Swal.warning(res.message);
                    }
                })
                .catch(err => {
                    App.Swal.warning("Lỗi không xác định");
                });
        });
    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    <script src="{{asset('assets/app/js/admin/lockdown.js')}}"></script>
    
@endsection