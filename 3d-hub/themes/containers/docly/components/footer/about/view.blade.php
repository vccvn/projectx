
@php
    
$contacts = $options->theme->contacts;
$className = '';

foreach(['xs', 'sm', 'md', 'lg', 'xl'] as $size){
    if($col = $data->get('col_' . $size)){
        $className .= (' col-' . ($size == 'xs' ? $col : $size . '-' . $col));
    }
}

@endphp
<div class="{{$className}}">
    <div class="footer-col -about">
        <div class="center-line-title">
            <h5>{{$data->title}}</h5>
        </div>
        <p>
            {!! nl2br($data->description) !!}
        </p>
        <div class="contact-method">
            <p> 
                <i class="fas fa-map-marker-alt"></i>
                {{$data->address?$data->address:($contacts->address?$contacts->address:$siteinfo->address('Hà Nội, Việt Nam'))}} 
            </p>
            <p> <i class="far fa-mobile-android"></i> {{$data->phone_number?$data->phone_number:($contacts->phone_number?$contacts->phone_number:$siteinfo->phone_number('0987654321'))}} </p>
            <p> <i class="fas fa-headphones-alt"></i>{{$data->email?$data->email:($contacts->email?$contacts->email:$siteinfo->email('example@domain.com'))}}</p>
        </div>
    </div>
</div>