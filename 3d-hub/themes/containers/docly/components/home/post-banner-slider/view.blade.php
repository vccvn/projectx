@php
    $args = [
        '@limit' => $data->post_number?$data->post_number:4,
        '@sort' => $data->sorttype?$data->sorttype:1,
        '@withCountPublishComments' => 'comment_count'
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
    }elseif($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
        
    $args['@withCategory'] = true;
    if($data->title) $title = $data->title;

    
@endphp
@count($posts = $helper->getPosts($args))
    <div class="container-max no-gutter">
        <div class="blog-ocean__slider">
            @foreach ($posts as $post)
                <div class="blog-ocean__slider__item">
                    <div class="slider-item__image">
                        <img src="{{$post->getImage()}}" alt="{{$post->title}}" />
                    </div>
                    <div class="slider-item__content">
                        <div class="post-card -center -theme--blue">
                            <div></div>
                            <div class="card__content">
                                @if ($post->category)
                                    <h5 class="card__content-category">{{$post->category->name}}</h5>
                                @endif
                                <a class="card__content-title" href="{{$post->getViewUrl()}}">{{$post->title}}</a>
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endcount