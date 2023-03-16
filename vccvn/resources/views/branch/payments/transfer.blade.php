@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', $page_title)

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Thanh Toán')


@section('content')


    @if (!$packagePayment)

        @include($_current.'check-payment-form')

    @else


        <div class="row">
            <div class="col-lg-7">

                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Thanh toán
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form" method="POST" action="{{ route($route_name_prefix . 'payments.verify') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="transaction_type" value="{{ $transaction_type }}">
                        <input type="hidden" name="package_payment_id" value="{{ session('package_payment_id') }}">

                        <div class="m-portlet__body">
                            <div class="form-group m-form__group {{$e = $errors->has('package_payment_id') ?'has-danger':''}}">
                                <label>Mã thanh toán</label>
                                <input type="text" class="form-control m-input" disabled="disabled" placeholder="Nhập mã thanh toán" value="{{ $packagePayment->id }}">
                                @if ($e)
                                    <span class="error has-error m-form__help">{{ $errors->first('package_payment_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group m-form__group {{$e = $errors->has('image') ?'has-danger':''}}">
                                <label for="image">Biên lai</label>
                                <div></div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="image">
                                    <label class="custom-file-label" for="image">Chọn file</label>
                                </div>
                                @if ($e)
                                    <span class="error has-error m-form__help">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label for="noteTextarea">Ghi chú</label>
                                <textarea class="form-control m-input" id="noteTextarea" rows="3" name="note" placeholder="Ghi chú (Tùy chọn)">{{ old('note') }}</textarea>
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

            <div class="col-lg-5">

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
                                    Thông tin chuyển khoản
                                </h3>
                            </div>
                        </div>
                    </div>


                    <div class="m-portlet__body">
                        <div class="banh-info  pb-3">
                            @if (($methods = $helper->getPaymentMethodOptions()) && $methods->transfer && ($transfer = $methods->transfer) && ($cfg = crazy_arr($transfer->config)))

                                <p>Số tài khoản: <strong>{{ $cfg->account_number }}</strong></p>
                                <p>Chủ tài khoản: <strong>{{ $cfg->account_name }}</strong></p>
                                <p>Ngân hàng: <strong>{{ $cfg->bank_name }}</strong></p>
                                @if ($cfg->bank_branch)
                                    <p>Chi nhánh: <strong>{{ $cfg->bank_branch }}</strong></p>
                                @endif
                                @if ($cfg->sort_code)
                                    <p>Sort Code: <strong>{{ $cfg->sort_code }}</strong></p>
                                @endif
                                @if ($cfg->iban)
                                    <p>IBAN: <strong>{{ $cfg->iban }}</strong></p>
                                @endif
                                @if ($cfg->bic)
                                    <p>BIC / Swift: <strong>{{ $cfg->bic }}</strong></p>
                                @endif
                            @else

                                <P>Thông tin thanh toán chưa được cấu hình</P>
                            @endif


                            @if (isset($packagePayment) && $packagePayment)

                                <p>Số tiền: <strong>{{ number_format($packagePayment->amount, 0, ',', '.') }}</strong>
                                </p>

                            @endif

                            @if ($transfer->guide)
                                <p>{!! nl2br($transfer->guide) !!}</p>
                            @endif
                            <p><strong>* Lưu ý:</strong> khách hàng tự chịu phí chuyển khoản</p>
                        </div>
                        <div class="guide">
                            <h4>Hướng dẫn</h4>
                            <div class="guide-step">
                                <h4>Bước 1:</h4>
                                <p>Chuyển khoản với nội dung:
                                    {{ isset($user) ? $user->phone_number : 'Số điện thoại' }} +
                                    {{ isset($packagePayment) ? $packagePayment->id : 'Mã thanh toán' }}</p>
                            </div>
                            <div class="guide-step">
                                <h4>Bước 2:</h4>
                                <p>Scan hoặc chụp hình rõ nét biên lai</p>
                            </div>
                            <div class="guide-step">
                                <h4>Bước 3:</h4>
                                <p>Điền vào form bên trên thông tin đơn hàng kèm ảnh biên lai</p>
                            </div>
                            <div class="guide-step">
                                <h4>Bước 4:</h4>
                                <p>Nhấn "Xong" để hoàn tất quá trình thanh toán</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!--end::Portlet-->

            </div>
        </div>





    @endif












@endsection
