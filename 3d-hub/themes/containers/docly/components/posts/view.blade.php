@php
    $args = [
        '@limit' => $data->post_number?$data->post_number:4,
        '@sort' => $data->sorttype?$data->sorttype:1,
        '@withTags' =>  true,
        // '@withCountPublishComments' => 'comment_count'
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
        if(!$title) $title = $category->name;
        $link = $category->getViewUrl();
    }elseif($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
    $args['@withCategory'] = true;
    if($data->title) $title = $data->title;
    if($data->link) $link = $data->link;
    $attr = docly_section_attrs($data, [
        'class' => 'doc_blog_grid_area_two'
    ]);
@endphp


@if (count($posts = $helper->getPosts($args)))
    <section {!!$attr!!}>
        <div class="container">
            <div class="mb-5 text-center section-title">
                <h2 class="mb-2">{{$title}}</h2>
                <p>{{$data->description}}</p>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                <div class="col-lg-4 col-sm-6">
                    <div class="blog_grid_post wow fadeInUp">
                        <a href="{{$url = $post->getViewUrl()}}"><img src="{{$post->getImage('thumbnail')}}" alt="{{$post->title}}"></a>
                            
                        <div class="grid_post_content">
                            <div class="post_tag">
                                <a href="{{$url}}">{{$post->timeAgo()}}</a>
                                @if ($post->category)
                                <a class="c_blue" href="{{$post->category->getViewUrl()}}">{{$post->category->name}}</a>    
                                @elseif(count($post->tags))
                                    @foreach ($post->tags as $tag)
                                        @if ($loop->index < 2)
                                            <a href="{{route('client.search', ['s' => $tag->keyword])}}">{{$tag->name}}</a>{{$loop->last?'':','}}
                                        @endif
                                    @endforeach
                                
                                @endif
                                
                            </div>
                            <a href="{{$url}}">
                                <h4 class="b_title">{{$post->title}}</h4>
                            </a>
                            <p>{{$post->getShortDesc(100)}}</p>
                            {{-- <div class="media post_author">
                                <div class="round_img">
                                    <img src="img/blog-grid/author_1.jpg" alt="">
                                </div>
                                <div class="media-body author_text">
                                    <h4>Jason Response</h4>
                                    <div class="date">Sep 14, 2020</div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @endforeach
                @if ($link)
                    
                <div class="col-lg-12 text-center wow fadeInUp" data-wow-delay="0.3s">
                    <a href="{{$link}}" class="doc_border_btn all_doc_btn">Xem thêm<i class="arrow_right"></i></a>
                </div>
                
                @endif
            </div>
        </div>
    </section>

@endif