@extends($_layout . 'master')
@include($_lib . 'register-meta')

@section('body.class', 'payment-page')
@section('content')

    @include($_template . 'page-header', [
        'title' => $page_title,
        // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
    ])
    @if (!session('order_code'))
        <!-- Log In Section Start -->
        <div class="order-section">
            <div class="box">
                <form class="form" action="{{ route('client.payments.check-order') }}" method="POST">
                    @csrf
                    @if ($error = session('error'))
                        <div class="alert alert-danger text-center">
                            {{ $error }}
                        </div>
                    @endif

                    <div class="input">
                        <label class="form__label" for="contact">
                            Email hoặc Số điện thoại <span>*</span>
                        </label>
                        <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}">
                    </div>
                    @if ($error = $errors->first('contact'))
                        <div class="alert alert-danger text-center">
                            {{ $error }}
                        </div>
                    @endif
                    <div class="input">
                        <label class="form__label" for="order_code">
                            Mã đơn hàng <span>*</span>
                        </label>
                        <input type="text" name="order_code" id="order_code" class="form-control" value="{{ old('order_code') }}">
                    </div>
                    @if ($error = $errors->first('order_code'))
                        <div class="alert alert-danger text-center">
                            {{ $error }}
                        </div>
                    @endif
                    <div class="input submit">
                        <button type="submit" class="btn brt-primary btn-block">Tiếp tục</button>
                    </div>
                </form>

            </div>

        </div>
        <!-- Log In Section End -->
    @else
        <section class="transfer-section">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6  mb-40 mb-lg-0">
                        <h3 class="heading-secondary mb-3">Thanh toán</h3>
                        <div class="login-reg-box bg-white">
                            <form action="{{ route('client.payments.verify-transfer') }}" method="post" enctype="multipart/form-data">
                                <div class="ps-form__content">
                                    @csrf
                                    <input type="hidden" name="order_code" value="{{ session('order_code') }}">
                                    <div class="form-group">
                                        <label class="form__label" for="order_code">
                                            Mã đơn hàng <span>*</span>
                                        </label>
                                        <input type="text" name="code" id="order_code" class="form-control" value="{{ session('order_code') }}" placeholder="Mã đơn hàng" readonly>
                                    </div>
                                    @if ($error = $errors->first('order_code'))
                                        <div class="alert alert-danger text-center">
                                            {{ $error }}
                                        </div>
                                    @endif

                                    <div class="form-group mt-3">
                                        <label for="billing_transaction_image" class="form__label mb-2">Biên lai <span>*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="billing_transaction_image" class="custom-file-input" accept="image/*">
                                            {{-- <label class="custom-file-label" for="billing_transaction_image">Chưa có file nào dc chọn</label> --}}
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="error has-error">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="orderNotes" class="form__label mb-2">Ghi chú </label>
                                        <textarea class="form-control" id="orderNotes" name="note" placeholder="Ghi chú (Tùy chọn)">{{ old('note') }}</textarea>
                                    </div>
                                    <div class="form-group submit mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">Xong</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <h3 class="heading-secondary mb-3">Hướng dẫn</h3>
                        <div class=" bg-white" style="font-size: large">
                            @include($_lib . 'payments.transfer')
                        </div>
                    </div>
                </div>



            </div>
        </section>


    @endif






@endsection
