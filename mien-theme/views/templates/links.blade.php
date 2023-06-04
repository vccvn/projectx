    
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "{{route('home')}}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{route('home')}}/collections?keyword={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    <script type='application/ld+json'>
        {
            "@context":"https://schema.org",
            "@type":"Organization",
            "@id":"{{route('home')}}#organization",
            "url":"{{route('home')}}",
            "name":"{{$siteinfo->site_name}}",
            "description" : "{{$siteinfo->meta_description("Miên")}}",
            "image":"{{$siteinfo->logo}}",
            "sameAs":[
                "https://www.facebook.com/mienhcmc"
            ],
            "logo":"{{$siteinfo->logo}}",
            "telephone" : "{{$siteinfo->phone_number}}",
            "email" : "{{$siteinfo->email}}",
            "address" : {
                "@type" : "PostalAddress",
                "streetAddress" : "Ho Chi Minh City, Vietnam",
                "addressLocality" : "Ho Chi Minh",
                "postalCode" : "700000",
                "addressCountry" : "VN"
            }, 
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer support",
                "telephone": "{{$siteinfo->phone_number}}",
                "email": "{{$siteinfo->email}}"
            }
                
        }
    </script>

    <script type="application/ld+json">
        {!! json_schema_encode([
            "@context" => "https://schema.org",
            "@type" => "Store",
            "name" => $siteinfo->site_name,
            "description" => $siteinfo->meta_description("Miên"),
            "image" => $siteinfo->logo,
            "@id" => route('home'),
            "url" => route('home'),
            "telephone" => $siteinfo->phone_number,
            "email" => $siteinfo->email,
            "priceRange" => "VND",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "Nguyễn Thái Bình",
                "addressLocality" => "Ho Chi Minh",
                "postalCode" => "700000",
                "addressCountry" => "VN"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => 10.795597,
                "longitude" => 106.6486478
            ],
            "openingHoursSpecification" => [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ],
                "opens" => "09:00",
                "closes" => "18:00"
            ],
            "sameAs" => [
                "https://www.facebook.com/mienhcmc"
            ]
        ]) !!}
    </script>

    @if (count($schemas = get_schema_data()))
        @foreach ($schemas as $schema)
        <script type="application/ld+json">{!! json_schema_encode($schema) !!}</script>
        @endforeach
    @endif

    
    <link rel="shortcut icon" type="image/x-icon" href="{{$siteinfo->favicon?$siteinfo->favicon:theme_asset('images/favicon.png')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{theme_asset('css/style.min.css')}}">
    <link rel="stylesheet" href="{{theme_asset('css/fa5/all.min.css')}}">
    <link rel="stylesheet" href="{{theme_asset('css/pe/pe-icon-7-stroke.css')}}">