@php
$profile = getUser();
@endphp
@extends($_layout.'admin')
@section('title', 'Chốt sổ')
{{-- @section('header_title', 'Kết quả xổ số') --}}
{{-- @section('show_sidebar', 1) --}}
@section('content')
    <div class="ms-panel">
        <div class="ms-panel-body">
            <form class="ms-form-wizard ms-wizard-pill style2-wizard" id="lockdown-wizard">
                <h3>Date</h3>
                <div class="ms-wizard-step check-lotto-step">
                    <div class="mt-4 pt-5 max-500 mx-auto text-center">
                        <h5>Ngày tháng</h5>
                        <div class="input-group">
                            <input type="text" name="check_date" id="check-date-input" class="form-control date-picker2" placeholder="Ngày mở thưởng" data-format="yy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off">
                            <div class="input-group-append">
                                <label for="check-date-input" class="mt-0 input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </div>
                        </div>
                        <p>
                            Bạn có thể chọn ngày tháng cụ thể dể tiếm hành chốt sổ
                        </p>
                    </div>
                    
                    
                </div>
                <h3>Lotto</h3>
                <div class="ms-wizard-step check-lotto-step">
                    <h5>Kiểm tra Kết quả lotto</h5>
                    @include($_current.'tool', [
                        'file_input_name' => 'lotto_backup_file',
                        'date_input_name' => 'lotto_check_date',
                        'check_time' => $checkTime->lottos
                    ])

                    <div class="table-responsive">
                        <table id="checkout-lotto" class="table table-bordered thead-primary smarttable text-sm-center">
                            
                        </table>
                    </div>
                </div>
                <h3>Kiểm tra user</h3>
                <div class="ms-wizard-step check-user-step">
                    <h5>Kiểm tra user</h5>
                    @include($_current.'tool', [
                        'file_input_name' => 'user_backup_file',
                        'date_input_name' => 'user_check_date',
                        'check_time' => $checkTime->users
                    ])
                    <div class="table-responsive">
                        <table id="checkout-user" class="table table-bordered thead-primary smarttable text-sm-center">
                            
                        </table>
                    </div>
                </div>
                <h3>Kiểm tra Cược</h3>
                <div class="ms-wizard-step check-betting-step">
                    <h5>Kiểm tra Cược</h5>
                    @include($_current.'tool', [
                        'file_input_name' => 'betting_backup_file',
                        'date_input_name' => 'betting_check_date',
                        'check_time' => $checkTime->bettings
                    ])
                    <div class="table-responsive">
                        <table id="checkout-betting" class="table table-bordered thead-primary smarttable text-sm-center">
                            
                        </table>
                    </div>
                </div>
                <h3>Phân tích kết quả</h3>
                <div class="ms-wizard-step check-betting-result-step">
                    <h5>Phân tích kết quả</h5>
                    <div class="form-group row mb-0">
                        <div class="col-6 col-sm-12 col-md-9 text-sm-center text-md-left">
                            <div class="input-group">
                                <button type="button" class="btn btn-primary btn-checkout">
                                    <i class="fa fa-cogs"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline">Phân tích</span>
                                </button>
                                <button type="button" class="btn btn-info btn-get-data ">
                                    <i class="fa fa-eye"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline ">Xem</span>
                                </button>
                                <button type="button" class="btn btn-success btn-download-backup">
                                    <i class="fa fa-download"></i> <span class="text-white d-none d-sm-inline d-md-none d-lg-inline ">Tải về</span>
                                </button>
                                
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        Thời gian phân tích sau cùng <strong id="lastest-proccess-time">{{$lastestTime}}</strong>
                    </div>
                    <div id="process">
                        <div class="message text-center mt-4 pt-4">
                            
                        </div>
                        <div class="buttons text-center mt-4 mb-4">
                            <button type="button" class="btn btn-primary btn-show-detail ">
                                <i class="fa fa-eye"></i> Hiển thị chi thiết
                            </button>

                            <button type="button" class="btn btn-success btn-download-backup">
                                <i class="fa fa-download"></i> Tải về báo cáo
                            </button>
                            
                        </div>
                        <div class="table-responsive results">
                            <table id="betting-manager" class="table table-bordered thead-primary type-table smart-table text-sm-center" >
            
                            </table>
                        </div>
                        
                    </div>
                        
                </div>
                <h3>Khóa sổ  </h3>
                <div class="ms-wizard-step final-step text-center">
                    <h5>Khóa sổ  </h5>
                    <div id="final">
                        <div class="message text-center mt-5 pt-5 mb-5 pb-5">
                            Bản có thể kiểm có thề xem báo cáo trả điểm cho user trước khi khóa sổ
                        </div>
                        <div class="buttons mb-2">
                                
                            <button type="button" class="btn btn-info btn-view-report">
                                <i class="fa fa-eye"></i> Xem báo cáo
                            </button>

                                
                            <button type="button" class="btn btn-primary btn-commit">
                                <i class="fa fa-lock"></i> Khóa sổ
                            </button>

                            


                        </div>
                        <div class="results">
                            <div class="table-responsive">
                                <table id="user-report" class="table table-bordered thead-primary type-table smart-table text-sm-center" >
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </form>
            
        </div>
    </div>
@endsection


@section('css')
    <style>
        .progress-list{
            overflow-y: auto;
            max-height: 240px;
        }
        .dch div.data-numbers{
            height: 0;
            overflow: hidden;
            visibility: hidden;
            opacity: 0;
            transition: all ease-in-out 0.3s;
        }
        .dch.click div.data-numbers{
            height: auto;
            overflow: auto;
            visibility: visible;
            opacity: 1;
        }

        #process .results, #process .message, #process .buttons,
        #final .results, #final .message, #final .buttons{
            display: none;
        }
        #process.show-results .results, 
        #process.show-message .message, 
        #process.show-buttons .buttons,
        #final.show-results .results, 
        #final.show-message .message, 
        #final.show-buttons .buttons
        {
            display: block;
        } 
        
        h5{
            margin-bottom: 2rem;
        }
    </style>
@endsection


@section('js')
    <script>
        
    window.lockdownInit = function(){
        
        App.setCheckoutLotto({
            el: '#checkout-lotto',
            // filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.checkout.lottos.change-logs'),
                'compare'        => route('admin.lockdown.checkout.lottos.compare'),
                'lotto'          => route('admin.lottos.update')
                // 'restore' => route('admin.lottos.restore'),
                // 'lock'           => route('admin.lottos.deactive'),
                // 'unlock'         => route('admin.lottos.active')
            ]) !!}
            
        });

        App.setCheckoutUser({
            el: '#checkout-user',
            filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.checkout.users.change-logs'),
                'compare'        => route('admin.lockdown.checkout.users.compare'),
                // 'restore' => route('admin.users.restore'),
                'lock'           => route('admin.users.deactive'),
                'unlock'         => route('admin.users.active'),
                'detail'         => route('admin.users.detail'),
                
            ]) !!}
            
        });

        App.setCheckoutBetting({
            el: '#checkout-betting',
            filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.checkout.bettings.change-logs'),
                'compare'        => route('admin.lockdown.checkout.bettings.compare'),
                'lock'           => route('admin.bettings.lock'),
                'unlock'         => route('admin.bettings.unlock'),
                'userdetail'     => route('admin.users.detail'),
                'bettings'       => route('admin.lockdown.bettings'),
                // 'deactive' => route('admin.users.deactive')
            ]) !!}
            
        }, {!! 
            json_encode($areaOptions) 
        !!}, {!! 
            json_encode($types) 
        !!});

        App.setCompareBetting({
            el: '#betting-manager',
            filterForm: '.tool1-form',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.results.data'),
                'checkout'       => route('admin.lockdown.results.process'),
                'download'       => route('admin.lockdown.report.download'),
                // 'approve'        => route('admin.lockdown.results.approve'),
                // 'unapprove'      => route('admin.lockdown.results.unapprove'),
            ]) !!}
            
        });

        
        
        App.setFinishStep({
            el: '#user-report',
            urls: {!! json_encode([
                'data'           => route('admin.lockdown.data', ['lockdown_status' => 0]),
                'lockdownAll'    => route('admin.lockdown.lockdown.all'),
                'lockdown'       => route('admin.lockdown.lockdown'),
                'unlockdown'     => route('admin.lockdown.unlockdown'),
                'done'           => route('admin.lockdown.points'),
                
            ]) !!}
            
        });

    }
    </script>
    <script src="{{asset('static/accountsjs/jquery.steps.min.js')}}"></script>
    

    <script src="{{asset('assets/app/js/app.smarttable.js')}}"></script>
    <script src="{{asset('assets/app/js/admin/lockdown.js')}}"></script>
    
@endsection