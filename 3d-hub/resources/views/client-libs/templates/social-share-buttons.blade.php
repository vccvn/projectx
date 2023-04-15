
<?php 
$d = crazy_arr(isset($data) && is_array($data) ? $data : []);
$u = $d->link?$d->link:route('home');
$url = urlencode($u);
$desc = urlencode($d->description?$d->description:'');
$img = urlencode($d->image?$d->image:'');
$tit = urlencode($d->title?$d->title:'');
$jssdk = $options->settings->jssdk;

?>

@if ($jssdk)
    

<div class="{{parse_classname('social-share')}}">
    <ul class="{{parse_classname('social-share__buttons')}}">
        @if (isset($title) && $title)
        <li class="{{parse_classname('social-share__item', 'social-share__item--title')}}">
                <h3 class="{{parse_classname('social-share__title')}}">{{$title}}</h3>
            </li>
        @endif
    
        @if ($jssdk->facebook)
            <li class="{{parse_classname('social-share__item', 'social-share__item--facebook')}}">
                <div class="fb-share-button" data-href="{{$u}}" data-layout="button_count" data-size="small">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                </div>
            </li>
        @endif
        @if ($jssdk->twitter)
            <li class="{{parse_classname('social-share__item', 'social-share__item--twitter')}}">
                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{$tit}}" data-size="small" rel="canonical">Tweet</a>
            </li>
        @endif
    </ul>
</div>

@endif