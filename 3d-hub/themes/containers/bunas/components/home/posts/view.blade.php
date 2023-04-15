@php
    $args = [
        '@limit' => $data->post_number?$data->post_number:4,
        '@sort' => $data->sorttype?$data->sorttype:1,
        '@withTags' =>  true,
        '@withCountPublishComments' => 'comment_count'
    ];
    $title = null;
    if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
        $args['dynamic_id'] = $data->dynamic_id;
        $title = $dynamic->name;
    }
    if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
        $args['@category'] = $data->category_id;
        if($category->hasChild() && $data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
        if(!$title) $title = $category->name;
    }elseif($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
    
    if($data->title) $title = $data->title;
    
@endphp

@if (count($posts = $helper->getPosts($args)))
   
    <!-- Star Blog Area
    ============================================= -->
    <div class="blog-area default-padding bottom-lesss bg-fixed half-bg-light shadow dark" style="background-image: url({{$data->background(theme_asset('img/banner/1.jpg'))}});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-light text-center">
                        <h2>{{$title}}</h2>
                        <p>
                            {{$data->dewcription}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog-items">

                    @foreach ($posts as $post)
                        

                    <!-- Single Item -->
                    <div class="col-md-4 single-item">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{$url = $post->getViewUrl()}}"><img src="{{$post->getImage('social')}}" alt="{{$post->title}}"></a>
                                @if(count($post->tags))
                                <div class="tags">
                                    @foreach ($post->tags as $tag)
                                        @if ($loop->index < 2)
                                            <a href="{{route('client.search', ['s' => $tag->keyword])}}">{{$tag->name}}</a>{{$loop->last?'':','}}
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="info">
                                <div class="meta">
                                    <ul>
                                        <li>{{$post->dateFormat('d/m/Y')}}</li>
                                        {{-- @if ($post->comment_count) --}}
                                        <li><a href="{{$url}}#comments"><i class="fas fa-comments"></i> {{$post->comment_count}} Bình luận</a></li>    
                                        {{-- @endif --}}
                                        
                                    </ul>
                                </div>
                                <div class="title">
                                    <h4>
                                        <a href="{{$url}}">{{$post->title}} </a>
                                    </h4>
                                </div>
                                
                                <p>
                                    {{$post->getShortDesc(100)}}
                                </p>
                                <a class="btn btn-theme border btn-sm" href="{{$url}}">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area -->

    

@endif