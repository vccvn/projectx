@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Phương thức thanh toán')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Thanh Toán')


@section('content')


    @if (!$packagePayment)
    @include($_current.'check-payment-form')
    @else

    
    <div class="row">
        <div class="col-lg-6">

            <!--begin::Portlet-->

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Thông tin gói tài khoản
                            </h3>
                        </div>
                    </div>
                </div>


                <div class="m-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-borfered">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="w-200">Mã đơn hàng</td>
                                    <td>{{session('package_payment_id')}}</td>
                                </tr>
                                <tr>
                                    <td class="w-200">Gói</td>
                                    <td>{{$package->name}}</td>
                                </tr>
                                <tr>
                                    <td class="w-200">Giá dịch vụ</td>
                                    <td>{{number_format($package->price, 0, ',', '.')}}</td>
                                </tr>


                                <tr>
                                    <td class="w-200">Tổng thanh toán</td>
                                    <td>{{number_format($package->price, 0, ',', '.')}}</td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--end::Portlet-->

        </div>

        <div class="col-lg-6">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Phương thức thanh toán
                            </h3>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="m-form" method="POST" action="{{ route($route_name_prefix . 'payments.payment') }}">
                    @csrf
                    <input type="hidden" name="transaction_type" value="{{ $transaction_type }}">
                    <input type="hidden" name="package_payment_id" value="{{ session('package_payment_id') }}">
                            
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label>Chọn phương thức thanh toán</label>

                            <div class="payments pl-3">
                                @include($_base.'payments.methods')
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>

    </div>





    @endif












@endsection
