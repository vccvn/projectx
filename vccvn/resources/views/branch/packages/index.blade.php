@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Thông tin dịch vụ')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Gói dịch vụ')


@section('content')



    <div class="row">
        <div class="col-lg-8 col-xl-8">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Nâng cấp dịch vụ
                            </h3>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="m-form" method="POST" action="{{route($route_name_prefix.'packages.upgrade')}}">
                    @csrf
                    <div class="m-portlet__body">
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group">
                                <label for="example_input_full_name">Chọn gói dịch vụ</label>
                                <div class="row">
                                    @if ($packages && count($packages))
                                        @foreach ($packages as $package)

                                            <div class="col-lg-6">
                                                <label class="m-option">
                                                    <span class="m-option__control">
                                                        <span class="m-radio m-radio--brand m-radio--check-bold">
                                                            <input type="radio" name="package_id"
                                                                value="{{ $package->id }}">
                                                            <span></span>
                                                        </span>
                                                    </span>
                                                    <span class="m-option__label">
                                                        <span class="m-option__head">
                                                            <span class="m-option__title">
                                                                {{ $package->name }}
                                                            </span>
                                                            <span class="m-option__focus">
                                                                @if ($package->price > 0)
                                                                    {{ number_format($package->price, 0, ',', '.') }} VNĐ
                                                                @else
                                                                    Miễn phí
                                                                @endif
                                                            </span>
                                                        </span>
                                                        <span class="m-option__body">
                                                            {!! nl2br($package->description) !!}
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @if ($errors->has('package_id'))
                                <div class="crazy-error">
                                    {{$errors->first('package_id')}}
                                </div>
                                @endif
                            </div>

                            <div class="form-group m-form__group">
                                <label>Chọn phương thức thanh toán</label>

                                <div class="payments pl-3">
                                    @include($_base.'payments.methods')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>

        <div class="col-lg-4">

            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--head-sm">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Package
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line  m-tabs-line--right" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_7_1" role="tab">
                                    Thông tin
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_3" role="tab">
                                    Storage
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_7_1" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>IP</td>
                                            <td> {{ env('APP_IP_ADDRESS', $_SERVER['SERVER_ADDR']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sub-Domain</td>
                                            <td>

                                                <a href="http://{{ $settings->subdomain . '.' . $settings->domain }}">
                                                    {{ $settings->subdomain . '.' . $settings->domain }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alias-Domain</td>
                                            <td>
                                                @if ($settings->alias_domain)
                                                    <a
                                                        href="http://{{ $settings->alias_domain }}">{{ $settings->alias_domain }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Limited</td>
                                            <td>
                                                {{ $settings->account_limited }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Usage</td>
                                            <td>
                                                {{ $settings->account_usage }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="m_tabs_7_3" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Dung lượng</td>
                                            <td class="text-right">100 GB</td>
                                        </tr>
                                        <tr>
                                            <td>Đã sử dụng</td>
                                            <td class="text-right storage-usage">
                                                NA

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Portlet-->

        </div>
    </div>

@endsection
