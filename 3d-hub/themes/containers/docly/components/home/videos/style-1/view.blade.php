@php

$args = [
    'content_type' => ['video', 'video_embed'],
    '@limit' => $data->post_number?$data->post_number:15,
    '@sort' => $data->sorttype?$data->sorttype:1
    
];
$link = null;
$title = null;
if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
    $args['dynamic_id'] = $data->dynamic_id;
    $title = $dynamic->name;
    $link = $dynamic->getViewUrl();
}
if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
    $args['@category'] = $data->category_id;
    if($category->hasChild() && $data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
    $title = $category->name;
    $link = $category->getViewUrl();
}else{
    if($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
    $args['@withCategory'] = true;
}
$args['@withCategory'] = true;
if($data->title) $title = $data->title;
$sliders = []; // chứa các slider con
if($t = count($posts = $helper->getPosts($args))){
    $s = 0;
    foreach ($posts as $i => $post) {
        if(!array_key_exists($s, $sliders)) $sliders[$s] = [];
        $sliders[$s][] = $post; // mỗi slider con lại chứa 5 post
        if($i % 5 == 4) $s++;
    }
}

@endphp


<div class="blog-section blog-food__section -video">
    <div class="container">
        <div class="news-block">
            <div class="news-block__header">
                <div class="header__controller__title">
                    <div class="center-line-title -large -mb-0">
                        <h5>{{$title?$title:"videos"}}</h5>
                    </div>
                </div>
                <div class="header__controller">
                    <div class="header__controller__tab">
                    </div>
                    <div class="header__controller__slider-control"></div>
                </div>
            </div>
            <div class="news-block__tab">
                <div class="active news-block__tab__item" data-tab-name="all">
                    <div class="news-block__content -default">

                        @if (count($sliders))
                            @foreach ($sliders as $slider)
                                @php
                                    $first = $slider[0]??null;
                                    $l = count($slider);
                                @endphp
                                
                                @if ($t)
                                    <div class="news-block__content__slide">
                                        <div class="row no-gutters">
                                            <div class="col-12 col-lg-6">
                                                <div class="video-container -big">
                                                    <a href="{{$first->getViewUrl()}}">{{$first->title}}</a>
                                                    <div class="video plyr__video-embed">
                                                        @if ($video = $first->getVideo())
                                                            <iframe src="{{$video->embed_url}}" allowfullscreen=""></iframe>
                                                        @else 
                                                            <img src="{{$first->getImage('720x360')}}" alt="{{$first->title}}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="row no-gutters">
                                                    @for ($i = 1; $i < $l; $i++)
                                                        @php
                                                            $post = $slider[$i];
                                                        @endphp
                                                        <div class="col-12 col-sm-6">
                                                            <div class="video-container -small">
                                                                <a href="{{$post->getViewUrl()}}">{{$post->title}}</a>
                                                                <div class="video -small plyr__video-embed">
                                                                    @if ($video = $post->getVideo())
                                                                        <iframe src="{{$video->embed_url}}" allowfullscreen=""></iframe>
                                                                    @else 
                                                                        <img src="{{$post->getImage('720x360')}}" alt="{{$post->title}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
