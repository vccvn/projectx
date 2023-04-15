

        <div class="container">
            <div class="blog-imageless-mansonry">
                @php
                    $url = null;
                    $args = [
                        '@limit' => $data->cate_number?$data->cate_number:5,
                        '@sort' => $data->cate_sorttype,
                        '@advance' => ['post_count'],
                    ];
                    $title = null;
                    if($data->cate_dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->cate_dynamic_id])){
                        $args['dynamic_id'] = $data->cate_dynamic_id;
                        $title = $dynamic->name;
                        $url = $dynamic->getViewUrl();
                    }
                    if($data->cate_category_id && $category = $helper->getPostCategory(['id' => $data->cate_category_id])){
                        $args['parent_id'] = $data->cate_category_id;
                        if(!$title) $title = $category->name;
                    }
                    if($data->cate_title) $title = $data->cate_title;
                @endphp
                @count($categories = $helper->getPostCategories($args))
                    <div class="blog-imageless-mansonry__categories">
                        @foreach ($categories as $category)
                            <a class="category -round " href="{{$category->getViewUrl()}}">
                                <div class="category__background" style="background-image: url({{$category->getFeatureImage()}})"></div>
                                <h5 class="title">{{$category->name}}</h5>
                                <h5 class="quantity">{{$category->post_count}}</h5>
                            </a>
                        @endforeach
                    </div>
                @endcount
                @php
                    $sizes = ['small', 'big', 'long', 'small', 'small', 'big', 'long', 'small', 'long', 'small', 'big', 'small'];
                    $imgsz = [
                        'small' => '277x184',
                        'big' => '575x388',
                        'long' => '277x388'
                    ];
                    $d = null;
                    $list_args = [
                        '@limit' => $data->list_post_number?$data->list_post_number:12,
                        '@sort' => $data->list_sorttype?$data->list_sorttype:1,
                        '@withCountPublishComments' => 'comment_count'
                    ];
                    $link = null;
                    $title = null;
                    if($data->list_dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->list_dynamic_id])){
                        $list_args['dynamic_id'] = $data->list_dynamic_id;
                        $title = $dynamic->name;
                        $link = $dynamic->getViewUrl();
                    }
                    if($data->list_category_id && $category = $helper->getPostCategory(['id' => $data->list_category_id])){
                        $list_args['@category'] = $data->list_category_id;
                        if($category->hasChild() && $data->list_group_by_category) $args['@groupBy'] = ['posts.category_id'];
                        $title = $category->name;
                        $link = $category->getViewUrl();
                    }elseif($data->list_group_by_category) $list_args['@groupBy'] = ['posts.category_id'];
                    
                    $list_args['@withCategory'] = true;
                    if($data->list_title) $title = $data->list_title;
                    if($data->list_link) $link = $data->list_link;
                @endphp
            
                <div class="blog-imageless-mansonry__content">
                    @if (count($posts = $helper->getPosts($list_args)))
                        @foreach ($posts as $post)
                            @php
                                $size = isset($sizes[$loop->index])?$sizes[$loop->index]:'small';
                            @endphp
                            <div class="post-card -center -middle -inner-text -{{$size}}">
                                <a class="card__cover" href="{{$u = $post->getViewUrl()}}">
                                    <img src="{{$post->getImage($imgsz[$size])}}" alt="{{$post->title}}" />
                                </a>
                                <div class="card__content">
                                    @if ($post->category)
                                        <h5 class="card__content-category">{{$post->category->name}}</h5>
                                    @endif
                                    <a class="card__content-title" href="{{$u}}">{{$post->title}}</a>
                                    <div class="card__content-info">
                                        <div class="info__time">
                                            <i class="far fa-clock"></i>
                                            <p>{{$post->dateFormat('d/m/Y')}}</p>
                                        </div>
                                        <div class="info__comment"><i class="far fa-comment"></i>
                                            <p>{{$post->comment_count}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($link)
                    
                    <div class="center">
                        <a class="btn -normal load-more-btn mb-0" href="{{$link}}">{{$data->seemore("Xem thêm")}}</a>
                    </div>
                
                @endif
            </div>
        </div>