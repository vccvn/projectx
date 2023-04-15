@php
    
$request = request();
$per_page = $request->per_page; 
$per_pages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

    // $profile = getUser();
    
    $activeClass = function($tab){
        static $t = null;
        if(!$t){
            $t = request()->tab;
        if(!$t) $t = session('tab');
        if(!$t) $t = "user-balance";
        }
        
        return $t == $tab ? 'active show' : '';
    };
@endphp
@extends($_layout.'admin')
@section('title', 'Trang cá nhân')
@section('show_sidebar', 1)

@section('content')

@if ($user)
    <div class="row">
        <div class="col-xl-9 col-lg-8 col-md-7 ">
            <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body clearfix">
                    <ul class="nav nav-tabs tabs-bordered" role="tablist" aria-orientation="vertical">
                        <li role="presentation"><a href="#user-balance" aria-controls="user-balance" class="{{$activeClass('user-balance')}}" role="tab" data-toggle="tab">Lịch sử thanh toán </a></li>
                        <li role="presentation"><a href="#user-debit" aria-controls="user-debit" class="{{$activeClass('user-debit')}}" role="tab" data-toggle="tab"> Debit </a></li>
                        <li role="presentation"><a href="#user-credit" aria-controls="user-credit" class="{{$activeClass('user-credit')}}" role="tab" data-toggle="tab"> Credit </a></li>
                        <li role="presentation"><a href="#bank-accounts" aria-controls="bank-accounts" class="{{$activeClass('bank-accounts')}}" role="tab" data-toggle="tab"> Ngân hàng </a></li>
                        <li role="presentation"><a href="#send-notifi" aria-controls="send-notifi" class="{{$activeClass('send-notifi')}}" role="tab" data-toggle="tab"> Gửi mail Thông báo </a></li>
                        <li role="presentation"><a href="#advance" aria-controls="advance" class="{{$activeClass('advance')}}" role="tab" data-toggle="tab"> Nâng cao </a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in pt-4 {{$activeClass('user-balance')}}" id="user-balance">
                            <form action="" class="filter-form">
                                <div class="form-group row mb-0">
                                    <div class="col-6  col-sm-6 ">
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
                        <div role="tabpanel" class="tab-pane fade in pt-4 {{$activeClass('user-debit')}}" id="user-debit">
                            <form action="" class="debit-form">
                                <div class="form-group row mb-0">
                                    <div class="col-6  col-sm-6 ">
                                        <div class="input-group">
                                            <input type="text" name="date_range" id="open-date-input2" class="form-control daterange" placeholder="Khoảng thời gian" data-format="YYYY-MM-DD" value="" autocomplete="off">
                                            <div class="input-group-append">
                                                <label for="open-date-input2" class="mt-0 input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-4 text-sm-center text-md-left">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Xem
                                            </button>

                                            <button type="button" class="btn btn-success btn-check-debit">
                                                <i class="fa fa-check"></i> Kiểm tra
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="debits" class="table table-bordered thead-primary smarttable" >
                
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in pt-4 {{$activeClass('user-credit')}}" id="user-credit">
                            <form action="" class="credit-form">
                                <div class="form-group row mb-0">
                                    <div class="col-6  col-sm-6 ">
                                        <div class="input-group">
                                            <input type="text" name="date_range" id="open-date-input2" class="form-control daterange" placeholder="Khoảng thời gian" data-format="YYYY-MM-DD" value="" autocomplete="off">
                                            <div class="input-group-append">
                                                <label for="open-date-input2" class="mt-0 input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-md-4 text-sm-center text-md-left">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Xem
                                            </button>

                                            <button type="button" class="btn btn-success btn-check-credit">
                                                <i class="fa fa-check"></i> Kiểm tra
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="credits" class="table table-bordered thead-primary smarttable" >
                
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in pt-4 {{$activeClass('bank-accounts')}}" id="bank-accounts">
                            <div class="table-responsive">
                                <table id="banks" class="table table-bordered thead-primary smarttable" >
                
                                </table>
                            </div>    
                        </div>
                        <div role="tabpanel" class="tab-pane pt-4 fade {{$activeClass('send-notifi')}}" id="send-notifi">
                            <form id="send-mail" method="POST" action="{{route('api.send-mail')}}" class="auto-validation {{$errors->first()?'was-validated':''}}" novalidate>
                                {{-- @csrf --}}
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="field">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <input type="text" name="email" id="email" value="{{old('email', $user->email)}}" placeholder="Nhập email" class="form-control {{($email = $errors->first('email'))?'is-invalid':''}}" required>
                                        <div class="invalid-feedback">
                                            {{$email?$email:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="subject">Subject</label>
                                    <div class="input-group">
                                        <input type="text" name="subject" id="subject" value="{{old('subject', $user->subject)}}" placeholder="Nhập Subject" class="form-control {{($subject = $errors->first('subject'))?'is-invalid':''}}" required>
                                        <div class="invalid-feedback">
                                            {{$subject?$subject:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <label for="message">Nội dung</label>
                                    <div class="input-group">
                                        <textarea name="message" id="message" cols="30" rows="8" class="form-control {{($message = $errors->first('message'))?'is-invalid':''}}">{{old('message', $user->message)}}</textarea>
                                        <div class="invalid-feedback">
                                            {{$message?$message:"Không được bỏ trống"}}
                                        </div>
                                    </div>
                                </div>
                
                                <button class="btn btn-primary mt-4 d-block w-100" type="submit">Gử</button>
                                
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade pt-5 {{$activeClass('advance')}}" id="advance">
                            <div class="text-center mt-5">
                                <a href="#" class="btn btn-success btn-reset-2fa"><i class="fa fa-undo"></i> Reset 2-FA</a>
                                @if ($user->status < 0)
                                    <a href="#" class="btn btn-success btn-unlock"><i class="fa fa-unlock"></i> Mở khóa</a>
                                @else
                                    <a href="#" class="btn btn-primary btn-lock"><i class="fa fa-lock"></i> Khóa</a>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-5 ">
            @include($_template.'profile-card', [
                'profile' => $user
            ])
        </div>
    </div>
@else
    <div class="alert alert-danger text-center">
        Người dùng không tồn tại
    </div>
@endif
    
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
                'data'=> route('admin.users.payments', ['user_id' => $user?$user->id:0])
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Thời gian",
                    className: "",
                    sortBy: 'created_at',
                    content: '{$created_time}'
                },
                {
                    title: "Phân loại",
                    className: "",
                    sortBy: 'type',
                    content: '{$type_text}'
                },
                {
                    title: "Số điểm",
                    className: "",
                    sortBy: 'amount',
                    content: '{$amount_text}'
                },
                // {
                //     title: "Số dư trước",
                //     className: "hide-xs",
                //     content: '{$before_change}'
                // },
                // {
                //     title: "Số dư sau",
                //     className: "hide-xs",
                //     content: '{$after_change}'
                // },
                {
                    title: "Ghi chú",
                    className: "hide-xs",
                    content: '{$note}'
                }
            ],
            numberFormat: ['amount_text', 'point_out', 'point_in', 'user_count'],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                return item;
            }
        });

        var $banks = App.smarttable.setup({
            el: '#banks',
            // filterForm: '.filter-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'=> route('admin.users.banks', ['user_id' => $user?$user->id:0])
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Ngân hàng",
                    className: "hide-xd",
                    sortBy: 'bank_id',
                    content: '{$bank.name}'
                },
                {
                    title: "Chi nhánh",
                    className: "hide-xs",
                    // sortBy: 'type',
                    content: '{$bank.branch}'
                },
                {
                    title: "Ngưới thụ hưởng",
                    className: "",
                    sortBy: 'account_name',
                    content: '<div class="d-sm-none">' +
                        '<strong>Ngân hàng</strong>: {$bank.name} <br>' +
                        '<strong>Chi nhánh</strong>: {$>bank->branch} <br>' +
                        '<strong>Người thụ hưởng</strong>: {$account_name} <br>' +
                        '<strong>Số tài khoản</strong>: {$account_number}' +
                    '</div>' +
                    '<div class="d-none d-sm-block">' +
                        '{$account_name}' +
                    '</div>'
                },
                // {
                //     title: "Số dư trước",
                //     className: "hide-xs",
                //     content: '{$before_change}'
                // },
                // {
                //     title: "Số dư sau",
                //     className: "hide-xs",
                //     content: '{$after_change}'
                // },
                {
                    title: "Số tài khoản",
                    className: "hide-xs",
                    content: '{$account_number}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                return item;
            }
        });

        var $debit = App.smarttable.setup({
            el: '#debits',
            filterForm: '.debit-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'=> route('admin.users.debits.data', ['user_id' => $user?$user->id:0]),
                'check'=> route('admin.users.debits.check', ['user_id' => $user?$user->id:0])
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Thời gian",
                    className: "",
                    sortby: 'date',
                    content: '{$date}'
                },
                {
                    title: "Số dư đầu kỳ",
                    className: "",
                    sortby: 'sta_of_cycle',
                    content: '{$sta_of_cycle}'
                },
                {
                    title: "Usage",
                    className: "",
                    sortby: 'usage_debit',
                    content: '{$usage_debit}'
                },
                {
                    title: "Payment",
                    className: "",
                    sortBy: 'payment',
                    content: '{$payment}'
                },
                {
                    title: "Số dư cuối kỳ",
                    className: "",
                    sortBy: 'end_of_cycle',
                    content: '{$end_of_cycle}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                
                item.sta_of_cycle = App.number.currency(item.sta_of_cycle);
                
                item.usage_debit = App.number.currency(item.usage_debit);
                
                item.payment = App.number.currency(item.payment);
                
                item.end_of_cycle = App.number.currency(item.end_of_cycle);
                
                return item;
            }
        });

        $(document).on("click", ".btn-check-debit", function(e){
            e.preventDefault();
            showLoading(100000);
            App.api.post($debit.urls.check, {s:1})
            .then(res => {
                hideLoading();
                if(res.status){
                    App.Swal.success("Mọi thứ đều ổn! Không có gì bất thường")
                }else if(res.errors){
                    App.Swal.warning(res.errors.join("<br>"));
                }else{
                    App.Swal.warning(res.message);
                }
            }).catch(err => {
                hideLoading();
                App.Swal.warning("Lỗi không xác định");
            })
        });



        var $credit = App.smarttable.setup({
            el: '#credits',
            filterForm: '.credit-form',
            // filterForm: '.filter-form',
            urls: {!! json_encode([
                'data'=> route('admin.users.credits.data', ['user_id' => $user?$user->id:0]),
                'check'=> route('admin.users.credits.check', ['user_id' => $user?$user->id:0])
            ]) !!},
            pagination: {
                per_page: 10,
                size: 5
            },
            columns: [
                {
                    title: "Thời gian",
                    className: "",
                    sortby: 'date',
                    content: '{$date}'
                },
                {
                    title: "Số dư đầu kỳ",
                    className: "",
                    sortby: 'sta_of_cycle',
                    content: '{$sta_of_cycle}'
                },
                {
                    title: "Usage",
                    className: "",
                    sortby: 'usage_credit',
                    content: '{$usage_credit}'
                },
                {
                    title: "Payment",
                    className: "",
                    sortBy: 'payment',
                    content: '{$payment}'
                },
                {
                    title: "Số dư cuối kỳ",
                    className: "",
                    sortBy: 'end_of_cycle',
                    content: '{$end_of_cycle}'
                }
            ],
            handle:{
                prepare: function(){
                    this.renderTableData("Đang xử lý...")
                }
            },
            parseItem: function(item){
                item.sta_of_cycle = App.number.currency(item.sta_of_cycle);
                
                item.usage_credit = App.number.currency(item.usage_credit);
                
                item.payment = App.number.currency(item.payment);
                
                item.end_of_cycle = App.number.currency(item.end_of_cycle);
                return item;
            }
        });

        $(document).on("click", ".btn-check-credit", function(e){
            e.preventDefault();
            showLoading(100000);
            App.api.post($credit.urls.check, {s:1})
            .then(res => {
                hideLoading();
                if(res.status){
                    App.Swal.success("Mọi thứ đều ổn! Không có gì bất thường")
                }else if(res.errors){
                    App.Swal.warning(res.errors.join("<br>"));
                }else{
                    App.Swal.warning(res.message);
                }
            }).catch(err => {
                hideLoading();
                App.Swal.warning("Lỗi không xác định");
            })
        })


        function reset(){
            $('#subject,#message').val("");
        }
        $(document).on("submit", "#send-mail", function(e){
            e.preventDefault();
            var indexed_array = {};
        
            var unindexed_array = $(this).serializeArray();
            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });
            showLoading(100000);
            App.api.post($(this).attr('action'), indexed_array)
            .then(res => {
                hideLoading();
                if(res.status){
                    App.Swal.success("Đã gửi mail thông báo thành công!");
                }else if(res.errors){
                    var errors = [];
                    if(App.isArray(res.errors) || App.isObject(res.errors)){
                        for (const key in res.errors) {
                            if (res.errors.hasOwnProperty(key)) {
                                const err = res.errors[key];
                                errors.push(err);
                            }
                        }
                    }
                    if(errors.length){
                        App.Swal.error(errors.join("<br>"));
                    }else{
                        App.Swal.error(res.message);
                    }
                }else{
                    App.Swal.error(res.message);
                }
            })
            .catch(err => {
                hideLoading();
                App.Swal.error("Lỗi không xác định");
                console.log(err);
            })
        });


        
        $(document).on("click", ".btn-reset-2fa", function(e){
            e.preventDefault();
            App.Swal.confirm("Hành động này có thể gây mất an toàn bảo mật với tài khoản này. <br>Bạn vẫn muốn tiếp tục?", function(){
                showLoading(100000);
                App.api.post("{{route('admin.users.reset2fa')}}", {id: {{$user?$user->id:0}}})
                .then(res => {
                    hideLoading();
                    if(res.status){
                        App.Swal.success(res.message);
                    }else{
                        App.Swal.error(res.message);
                    }
                })
                .catch(err => {
                    hideLoading();
                    App.Swal.error("Lỗi không xác định");
                    console.log(err);
                })
            })
            
        });

        var lockUrl = "{{route('admin.users.deactive')}}",
            unlockUrl = "{{route('admin.users.active')}}";
        
        $unlock = $('.btn-unlock');

        function lockUsers(ids) {
            var $lock = $('.btn-lock');
            showLoading();
            App.api.post(lockUrl, { ids: ids, status: -1 })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        $('.lock-message').html("Nếu muốn khóa người dùng này hạy nhấn nút bên dưới.");
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                if ($lock.length) {
                                    $lock.after(
                                        '<a href="#" class="btn btn-success btn-unlock"><i class="fa fa-unlock"></i> Mở khóa</a>'
                                    );
                                    $lock.remove();
                                }

                            }
                            App.Swal.success("Đã khóa " + res.data.length + " user");
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

        function unlockUsers(ids) {
            var $lock = $('.btn-unlock');
            showLoading();
            App.api.post(unlockUrl, { ids: ids, status: -1 })
                .then(res => {
                    hideLoading();
                    if (res.status) {
                        $('.lock-message').html("Người dùng này hiện đã bị khóa.");
                        if (res.data && res.data.length) {
                            for (let i = 0; i < res.data.length; i++) {
                                const id = res.data[i];
                                if ($lock.length) {
                                    $lock.after(
                                        '<a href="#" class="btn btn-primary btn-lock"><i class="fa fa-lock"></i> Khóa</a>'
                                    );
                                    $lock.remove();
                                }

                            }
                            App.Swal.success("Đã mở khóa " + res.data.length + " user");
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

        $(document).on("click", '.btn-lock', function(e){
            e.preventDefault();
            lockUsers([{{$user?$user->id:0}}]);
        })
        $(document).on("click", '.btn-unlock', function(e){
            e.preventDefault();
            unlockUsers([{{$user?$user->id:0}}]);
        })

    }
    </script>
    {{-- <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script> --}}
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    
@endsection