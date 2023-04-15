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

@endphp

@if ($t = count($posts = $helper->getPosts($args)))
    @php
        $first = $posts[0];
    @endphp
<div class="container">
    <div class="blog-ocean__content">
        <div class="video-block">
            <div class="row no-gutters">
                <div class="col-12 col-md-8">
                    <div class="video-view">
                        <h2 id="video-list__title">{{$first->title}}</h2>
                        @if ($video = $first->getVideo())
                            
                            <div class="plyr__video-embed -theme--blue" id="video-list-player">
                                <iframe src="{{$video->embed_url}}" allowfullscreen=""></iframe>
                            </div>
                            
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="video-list">
                        <div class="video-list__header">
                            <h5>{{$title}}</h5>
                            <p>1/{{$t}} video</p>
                        </div>
                        <div class="video-list__content">
                            @foreach ($posts as $post)
                                @if (!($video = $post->getVideo()))
                                    @continue
                                @endif
                                <a class="video-list__content__item {{$loop->index?'':'active'}}" href="#" data-src="{{$video->id}}" data-source="{{$video->server}}">
                                <div class="item__image">
                                    <img src="{{$post->getImage('thumb')}}" alt="{{$post->title}}" />
                                </div>
                                <div class="item__detail">
                                    <h5>{{$post->title}}</h5>
                                    {{-- <p>3:15</p> --}}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endif


