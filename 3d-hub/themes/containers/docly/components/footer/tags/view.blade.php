@php
$socials = $options->theme->socials;
$list = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];

$className = '';

foreach(['xs', 'sm', 'md', 'lg', 'xl'] as $size){
    if($col = $data->get('col_' . $size)){
        $className .= (' col-' . ($size == 'xs' ? $col : $size . '-' . $col));
    }
}
@endphp
<div class="{{$className}}">
    <div class="footer-col -util">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="center-line-title">
                    <h5>{{$data->title}}</h5>
                </div>
                <div class="tags-group">
                    @if (count($tags = $helper->getTags(['@sort'=> $data->sorttype, '@limit' => $data->tag_number])))
                        @foreach ($tags as $tag)
                        <a class="tag-btn" href="{{route('client.posts.tag', ['tag' => $tag->slug])}}">{{$tag->name}}</a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-12">
                <div class="center-line-title">
                    <h5>{{$data->social_title("Liên kết")}}</h5>
                </div>
                <div class="social-block">
                    @foreach ($list as $item)
                        @if ($link = $socials->get($item))
                        <a href="{{$link}}"><i class="fab fa-{{$item.($item=="facebook"?'-f':'')}}"></i></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
