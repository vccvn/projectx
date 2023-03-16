@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Dashboard')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Dashboard')


@section('content')



    <div class="row">
        <div class="col-md-8">

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Hosting Manager
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--begin::Section-->
                    <div class="m-section m-section--last">
                        <p>Secret Key: <span>{{$user->secret_key}}</span></p>
                        <p>Client Key: <span>{{$user->client_key}}</span></p>
                    </div>

                    <!--end::Section-->
                </div>
            </div>

            <!--end::Portlet-->
        </div>
		
        <div class="col-md-4">

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
                                                {{$settings->account_limited}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account Usage</td>
                                            <td>
                                                {{$settings->account_usage}}
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
                                            <td class="text-right storrage-usage">
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
