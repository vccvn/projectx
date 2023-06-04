@extends($_layout . 'master')
{{-- @section('title', $account->formConfig->title) --}}
@include($_lib . 'register-meta')

@section('body.class', 'payment-page')
@section('content')

    <!-- Log In Section Start -->
    <div class="login-section">
        @include($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ])

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
                        <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" placeholder="">
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
                        <input type="text" name="order_code" id="order_code" class="form-control" value="{{ old('order_code') }}" placeholder="">
                    </div>
                    @if ($error = $errors->first('order_code'))
                        <div class="alert alert-danger text-center">
                            {{ $error }}
                        </div>
                    @endif
                    <div class="buttons text-center">
                        <button type="submit" class="btn btn-primary btn-block">Tiếp tục</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Log In Section End -->




@endsection
