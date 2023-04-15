@php
    $profile = getUser();
@endphp
@extends($_layout.'master')
@section('title', 'Thông tin tài khoản ngân hàng')
@section('show_sidebar', 1)

@section('content')



<div class="ms-panel ms-panel-fh">
    <div class="ms-panel-body clearfix">

        <ul class="nav nav-tabs tabs-bordered left-tabs nav-justified" role="tablist" aria-orientation="vertical">
            <li role="presentation"><a href="#bank-list" aria-controls="bank-list" class="active show"
                    role="tab" data-toggle="tab">Tài khoản ngân hàng </a></li>
            <li role="presentation"><a href="#bank-account" aria-controls="bank-account" role="tab"
                    data-toggle="tab"> Thêm tài khoản </a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active show fade in" id="bank-list">
                <div class="table-responsive">
                    <table class="table table-bordered thead-primary" id="user-bank-account-table">
                        <thead>
                            <tr>
                                <th scope="col" class="hide-xs">#</th>
                                <th scope="col" class="hide-xs">Ngân hàng</th>
                                <th scope="col" class="hide-xs">Chi nhánh</th>
                                <th scope="col">Người thụ hưởng</th>
                                <th scope="col" class="hide-xs">Số tài khoản</th>
                                <th scope="col" class="w-90px">Del</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if (count($userBankList))
                                @foreach ($userBankList as $item)
                                <tr id="user-bank-item-{{$item->id}}" data-name="{{$item->bank->name . ' (' . $item->bank->area . ') - chi nhánh: ' . $item->bank->branch . ' - số tài khoản: '. $item->account_number}}" data-bank-id="{{$item->bank_id}}" data-account-name="{{$item->account_name}}" data-account-number="{{$item->account_number}}">
                                    <th scope="row" class="hide-xs">{{$item->id}}</th>
                                    <td class="hide-xs">{{$item->bank->name}}</td>
                                    <td class="hide-xs">{{$item->bank->branch}}</td>
                                    <td>
                                        <div class="d-sm-none">
                                            <strong>Ngân hàng</strong>: {{$item->bank->name}} <br>
                                            <strong>Chi nhánh</strong>: {{$item->bank->branch}} <br>
                                            <strong>Người thụ hưởng</strong>: {{$item->account_name}} <br>
                                            <strong>Số tài khoản</strong>: {{$item->account_number}}
                                        </div>
                                        <div class="d-none d-sm-block">
                                            {{$item->account_name}}
                                        </div>
                                    </td>
                                    <td class="hide-xs">{{$item->account_number}}</td>
                                    <td class="w-90px text-center">
                                        <a href="#" class="btn-edit-user-bank" data-id="{{$item->id}}"><i class="fas fa-pencil-alt text-secondary"></i></a>
                                        <a href="#" class="btn-delete-user-bank" data-id="{{$item->id}}"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                    </td>
                                </tr>
                                
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>
                @if (count($userBankList))
                    {{$userBankList->links($_template.'pagination')}}
                @endif
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bank-account">
                <form method="POST" action="{{route('payment.banks.userbank.add')}}" id="user-bank-form" class="needs-validation" novalidate>
                    <div class="form-row">
                        <div class="col-sm-6 col-md-4 mb-3">
                            <label for="bank-name">Tên ngân hàng</label>
                            <div class="input-group">
                                {!! html_input([
                                    'type' => 'select',
                                    'name' => 'bank_name',
                                    'id'   => 'bank-name',
                                    'className' => 'form-control',
                                    'data' => ['' => 'Chọn ngân hàng'] + get_bank_options([], null, 'name', 'name'),
                                    'required' => 'true'
                                ]) !!}
                                <div class="invalid-feedback">
                                    Vui lòng chọn ngân hàng.
                                </div>
                                <div class="valid-feedback">
                                    <i class="fa fa-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <label for="bank-name">Khu vực</label>
                            <div class="input-group">
                                {!! 
                                html_input([
                                    'type' => 'select',
                                    'name' => 'bank_area',
                                    'id'   => 'bank-area',
                                    'className' => 'form-control'
                                ]) 
                                !!}
                                <div class="invalid-feedback">
                                    Vui lòng Khu vực.
                                </div>
                                <div class="valid-feedback">
                                    <i class="fa fa-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <label for="bank-name">Chi nhánh</label>
                            <div class="input-group">
                                {!! 
                                html_input([
                                    'type' => 'select',
                                    'name' => 'bank_id',
                                    'id'   => 'bank-id',
                                    'className' => 'form-control',
                                    'required' => 'true'
                                ]) 
                                !!}
                                <div class="invalid-feedback">
                                    Vui lòng chọn Chi nhánh.
                                </div>
                                <div class="valid-feedback">
                                    <i class="fa fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="account_name">Người thụ hưởng</label>
                            <div class="input-group">
                                <input type="text" name="account_name" class="form-control" id="account_name"
                                    placeholder="Account Name" required>
                                <div class="invalid-feedback">
                                    Vui lòng Nhập tên người thụ hưởng.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="account_number">Số tài khoản</label>
                            <div class="input-group">
                                <input type="text" name="account_number" class="form-control" id="account_number"
                                    placeholder="Account Number" required>
                                <div class="invalid-feedback">
                                    Vui lòng Nhập số tài khoản.
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Thêm</button>
                    <button type="button" class="btn btn-default btn-cancel">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        window.bankInit = function(){
            App.bank.init({
                urls: {!! json_encode([
                    'options' => route('payment.banks.options'),
                    'current_options' => route('payment.banks.current-options'),
                ]) !!}
            })
        }
    </script>
    <script src="{{asset('assets/app/js/bank.js')}}"></script>
@endsection