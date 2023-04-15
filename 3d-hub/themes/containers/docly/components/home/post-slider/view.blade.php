@php
$args = [
    '@limit' => $data->post_number?$data->post_number:12,
    '@sort' => $data->sorttype?$data->sorttype:1,
    '@withTags' =>  true,
    '@withCountPublishComments' => 'comment_count'
];
if($data->dynamic_id && $dynamic = $helper->getDynamic(['id' => $data->dynamic_id])){
    $args['dynamic_id'] = $data->dynamic_id;
}
if($data->category_id && $category = $helper->getPostCategory(['id' => $data->category_id])){
    $args['@category'] = $data->category_id;
    if($category->hasChild() && $data->group_by_category) $args['@groupBy'] = ['posts.category_id'];
    
}
elseif($data->group_by_category) $args['@groupBy'] = ['posts.category_id'];

$args['@withCategory'] = true;
@endphp

@if (count($posts = $helper->getPosts($args)))

<div class="container-full">
    <div class="blog-food__slide__wrapper">
        <div class="blog-food__slide">
            @foreach ($posts as $post)
                
            <div class="blog-food__slide__item">
                <div class="post-card -inner-text">
                    <a class="card__cover" href="{{$u = $post->getViewUrl()}}">
                        <img src="{{$post->getImage('356x534')}}" alt="{{$post->title}}" />
                    </a>
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
                            <div class="info__comment"><i class="far fa-comment"></i>
                                <p>{{$post->comment_count}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
</div>
@endif