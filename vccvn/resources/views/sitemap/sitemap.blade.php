{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc>{{url('/')}}</loc>
        <lastmod>{{str_replace(' ', 'T', date("Y-m-d H:i:s"))}}+07:00</lastmod>
    </url>
            

@if(isset($dynamics))
    @foreach($dynamics as $item)
    @if ($u = $item->getViewUrl())
        
    <url>
        <loc>{{$u}}</loc>
        <lastmod>{{str_replace(' ', 'T', $item->updated_at)}}+07:00</lastmod>
    </url>
    
    
    @endif
    @endforeach
@endif
@if(isset($categories))
    @foreach($categories as $item)
    @if ($u = $item->getViewUrl())
        
    <url>
        <loc>{{$u}}</loc>
        <lastmod>{{str_replace(' ', 'T', $item->updated_at)}}+07:00</lastmod>
    </url>
    
    
    @endif
    @endforeach
@endif
@if(isset($posts))
    @foreach($posts as $item)
    @if ($u = $item->getViewUrl())
        
    <url>
        <loc>{{$u}}</loc>
        <lastmod>{{str_replace(' ', 'T', str_replace(' ', 'T', $item->updated_at))}}+07:00</lastmod>
    </url>
    
    
    @endif
    @endforeach
@endif
@if(get_web_type() == 'ecommerce' && isset($products))
    @foreach($products as $item)
    @if ($u = $item->getViewUrl())
        
    <url>
        <loc>{{$u}}</loc>
        <lastmod>{{str_replace(' ', 'T', str_replace(' ', 'T', $item->updated_at))}}+07:00</lastmod>
    </url>
    
    
    @endif
    
    @endforeach
@endif

</urlset>