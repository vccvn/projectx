
@php
    
$className = '';

foreach(['xs', 'sm', 'md', 'lg', 'xl'] as $size){
    if($col = $data->get('col_' . $size)){
        $className .= (' col-' . ($size == 'xs' ? $col : $size . '-' . $col));
    }
}
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
    }else{
        if($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
        $args['@withCategory'] = true;
    }
    $args['@withCategory'] = true;
    if($data->title) $title = $data->title;
@endphp

@if (count($posts = $helper->getPosts($args)))

        <div class="{{$className}}">
            <div class="footer-col -feature-post">
                <div class="center-line-title">
                    <h5>{{$title}}</h5>
                </div>
                <div class="feature-post-block">
                    @foreach ($posts as $post)
                        
                    <div class="post-card -tiny">
                        <a class="card__cover" href="{{$u = $post->getViewUrl()}}">
                            <img src="{{$post->getImage('thumbnail')}}" alt="{{$post->title}}" /></a>
                        <div class="card__content">
                            @if ($post->category)
                                <h5 class="card__content-category">{{$post->category->name}}</h5>
                            @endif
                            <a class="card__content-title" href="{{$u}}">{{$post->sub('title', 80)}}</a>
                            <div class="card__content-info">
                                <div class="info__time">
                                    <i class="far fa-clock"></i>
                                    <p>{{$post->dateFormat('d/m/Y')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
            </div>
        </div>

@endif