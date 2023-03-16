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
                                Domain
                            </h3>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('domain.save') }}" class="m-form m-form--fit m-form--label-align-right">
                    @csrf
                    <div class="m-portlet__body">

                        <div class="form-group m-form__group row {{ $errors->has('subdomain') ? 'has-danger' : '' }}">
                            <label class="col-form-label col-lg-3" for="subdomain">Sub-Domain</label>
                            <div class="col-lg-9">

                                <div class="input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="subdomain_label">
                                            <i class="fa fa-globe"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="subdomain" value="{{ $webSetting->subdomain }}" id="subdomain" class="form-control m-input" placeholder="Tên miền" aria-describedby="subdomain_label">
                                    <div class="input-group-prepend">
                                        @include('cpanel.forms.templates.crazyselect', [
                                        'input' => html_input([
                                        'type' => 'crazyselect',
                                        'name' => 'domain',
                                        'data' => 'get_cfg_domain_options',
                                        'default' => old('domain', $webSetting->domain)
                                        ])
                                        ])
                                    </div>


                                </div>

                                @if ($dbnErr = $errors->first('subdomain'))
                                    <div class="form-control-feedback">{{ $dbnErr }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row {{ $errors->has('domain') ? 'has-danger' : '' }}">
                            <label class="col-form-label col-lg-3" for="domain">Domain</label>
                            <div class="col-lg-9">

                                <div class="input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="domain_label">
                                            <i class="fa fa-globe"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="domain" value="{{ $webSetting->domain }}" id="domain" class="form-control m-input" placeholder="Tên miền chính" aria-describedby="alias_domain_label">


                                </div>

                                @if ($dbUnErr = $errors->first('alias_domain'))
                                    <div class="form-control-feedback">{{ $dbUnErr }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row {{ $errors->has('alias_domain') ? 'has-danger' : '' }}">
                            <label class="col-form-label col-lg-3" for="alias_domain">Alias Domain</label>
                            <div class="col-lg-9">

                                <div class="input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="alias_domain_label">
                                            <i class="fa fa-globe"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="alias_domain" value="{{ $webSetting->alias_domain }}" id="alias_domain" class="form-control m-input" placeholder="Tên miền alias" aria-describedby="alias_domain_label">


                                </div>

                                @if ($dbUnErr = $errors->first('alias_domain'))
                                    <div class="form-control-feedback">{{ $dbUnErr }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-1 mb-4 crazy-form-group row " id="ssl-form-group">
                            <label class="col-6 col-sm-4 col-md-3 col-lg-2 col-form-label" for="ssl">
                                SSL
                            </label>
                            <div class="col-6 col-sm-2 col-md-3 col-lg-4">
                                <span class="m-switch m-switch--outline m-switch--icon m-switch--primary">
                                    <label>
                                        <input type="checkbox" name="ssl" id="ssl" placeholder="Viết gì đó" value_type="ssl" @if ($webSetting->domain) checked="checked" @endif>
                                        <span></span>
                                        <i class="ml-2 pt-2 d-inline-block">Cài đặt và sử dụng SSL</i>
                                    </label>
                                </span>


                                @if ($dbUnErr = $errors->first('ssl'))
                                    <div class="form-control-feedback">{{ $dbUnErr }}</div>
                                @endif

                            </div>

                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <button type="submit" class="btn btn-success">Cập nhật</button>

                        </div>
                    </div>
                </form>


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
                                Hosting
                            </h3>
                        </div>
                    </div>

                </div>
                <div class="m-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td>IP</td>
                                    <td>{{ $_SERVER['SERVER_ADDR'] }}</td>
                                </tr>
                                <tr>
                                    <td>Sub-Domain</td>
                                    <td>

                                        <a href="http://{{ $webSetting->subdomain . '.' . $webSetting->domain }}">
                                            {{ $webSetting->subdomain . '.' . $webSetting->domain }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alias-Domain</td>
                                    <td>
                                        @if ($webSetting->alias_domain)
                                            <a href="http://{{ $webSetting->alias_domain }}">{{ $webSetting->alias_domain }}</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>DOCUNENT_ROOT</td>
                                    <td>
                                        /public
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--end::Portlet-->

        </div>

    </div>

@endsection
