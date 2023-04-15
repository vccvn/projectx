@php
    $contacts = $options->theme->contacts;
    $hotline = $data->hotline?$data->hotline:(
        $contacts->hotline?$contacts->hotline:(
            $contacts->phone_number?$contacts->phone_number:(
                $siteinfo->hotline?$siteinfo->hotline:(
                    $siteinfo->phone_number?$siteinfo->phone_number:(
                        '0945786960'
                    )
                )
            )
        )
    );
@endphp
	<div class="hotline-phone-ring-wrap">
		<div class="hotline-phone-ring">
			<div class="hotline-phone-ring-circle"></div>
			<div class="hotline-phone-ring-circle-fill"></div>
			<div class="hotline-phone-ring-img-circle">
                <a href="tel:{{$sp = str_replace(['.', ' '], '', $hotline)}}" class="pps-btn-img">
                    <img src="{{theme_asset('img/call.png')}}" alt="{{$data->call_text('Gọi điện thoại')}}" width="80"> 
                </a>
            </div>
		</div>
		<div class="hotline-bar"> <a href="tel:{{$sp}}"> <span class="text-hotline">{{$hotline}}</span> </a></div>
    </div>