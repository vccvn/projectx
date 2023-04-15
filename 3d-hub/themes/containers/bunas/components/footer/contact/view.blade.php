
@php
    $contacts = $options->theme->contacts;
@endphp

                <div class="equal-height col-md-3 col-sm-6 item">
                    <div class="f-item contact">
                        <h4 class="widget-title">{{$data->title('Liên hệ')}}</h4>
                        <ul>
                            <li>
                                <h5>Địa chỉ</h5>
                                <span>{{$data->address($contacts->address($siteinfo->address))}}</span>
                            </li>
                            <li>
                                <h5>Điện thoại</h5>
                                <span>{{$data->phone_number($contacts->phone_number($siteinfo->phone_number))}}</span>
                            </li>
                            <li>
                                <h5>Email</h5>
                                <span>{{$data->email($contacts->email($siteinfo->email))}}</span>
                            </li>
                        </ul>
                    </div>
                </div>