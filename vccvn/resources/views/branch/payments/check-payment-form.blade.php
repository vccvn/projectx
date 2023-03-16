
<div class="row">

    <div class="col-lg-8 col-xl-8 ml-auto mr-auto">

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
            <form class="m-form" method="POST" action="{{ route($route_name_prefix . 'payments.check') }}">
                @csrf
                <div class="m-portlet__body">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group">
                            <label class="form__label" for="package_payment_id">
                                MÃ thanh toán <span>*</span>
                            </label>
                            <input type="text" name="package_payment_id" class="form-control m-input" value="{{ old('package_payment_id') }}" placeholder="Mã thanh toán">

                            @if ($errors->has('package_payment_id'))
                                <div class="crazy-error">
                                    {{ $errors->first('package_payment_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <button type="submit" class="btn btn-primary">Tiếp tục</button>
                        <button type="reset" class="btn btn-secondary">Hủy</button>
                    </div>
                </div>
            </form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->
    </div>

</div>
