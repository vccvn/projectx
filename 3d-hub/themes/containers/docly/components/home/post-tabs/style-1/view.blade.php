@php
    $postParams = gute_post_params($data, '', [
        '@withTags' =>  true,
        '@withCountPublishComments' => 'comment_count'
    ], 4, 1);
    
    $tabHeader = [  
        '<a class="active tab-item" href="#" title="all" data-for="all">Tất cả</a>'
    ];
    $catePosts = [
        [
            // tảo danh mục fake. $helper->crazyArr sẽ trả về instance của class Arr
            'category' => $helper->crazyArr([
                'id' => 0,
                'name' => 'Tất cả',
                'slug' => 'all'
            ]),
            'active' => 'active',
            'posts' => []
        ]
    ];
    $args = $postParams->args;
    $args['@withCategory'] = true;
    if(count($posts = $helper->getPosts($args))){
        $catePosts[0]['posts'] = $posts;
    }

    $cateArgs = [
        '@limit' => $postParams->cate_number,
        '@sort' => $postParams->cate_sorttype,
    ];
    if($postParams->dynamic){
        $cateArgs['dynamic_id'] = $postParams->dynamic->id;
        if($postParams->category){
            $cateArgs['parent_id'] = $postParams->category->id;
        }
    }
    $args = $postParams->args;
    if(count($categories = $helper->getPostCategories($cateArgs))){
        foreach($categories as $category){
            $args['@category'] = $category->id;
            if(count($posts = $helper->getPosts($args))){
                $tabHeader[$category->id] = '<a class="tab-item" href="#" title="'.$category->name.'" data-for="'.$category->slug.'">'.$category->name.'</a>';
                $catePosts[$category->id] = [
                    'category' => $category,
                    'posts' => $posts,
                    'active' => ''
                ];
            }
        }
    }
    
@endphp

<div class="container">
    <div class="blog-section blog-food__section -trending">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4 order-md-2">
                @php
                    $sidebarParams = gute_post_params($data, 'sidebar_', ['@with' => 'category'], 5, 1);
                @endphp

                <div class="blog-sidebar">
                    <div class="blog-sidebar-section -trending-post">
                        <div class="center-line-title">
                            <h5>{{$sidebarParams->title}}</h5>
                        </div>
                        @if (count($posts = $helper->getPosts($sidebarParams->args)))
                            @foreach ($posts as $post)
                                <div class="trending-post">
                                    <div class="trending-post_image">
                                        <div class="rank">{{$loop->index+1}}</div>
                                        <img src="{{$post->getImage('90x90')}}" alt="{{$post->title}}" />
                                    </div>
                                    <div class="trending-post_content">
                                        @if ($post->category)
                                            <h5 class="card__content-category">{{$post->category->name}}</h5>
                                        @endif
                                        <a href="{{$post->getViewUrl()}}">{{$post->title}}</a>
                                        <div class="info__time">
                                            <i class="far fa-clock"></i>
                                            <p>{{$post->dateFormat('d/m/Y')}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-7 col-lg-8 order-md-1">
                

                <div class="news-block">
                    <div class="news-block__header">
                        <div class="header__controller__title">
                            <div class="center-line-title -large -mb-0">
                                <h5>{{$postParams->title?$postParams->title:"Trending"}}</h5>
                            </div>
                        </div>
                        <div class="header__controller">
                            <div class="header__controller__tab">
                                @foreach ($tabHeader as $item)
                                    {!! $item !!}
                                @endforeach
                                
                            </div>
                            <div class="header__controller__slider-control"></div>
                        </div>
                    </div>
                    <div class="news-block__tab">
                        @foreach ($catePosts as $i => $tab)
                            <div class="{{$tab['active']}} news-block__tab__item" data-tab-name="{{$tab['category']->slug}}">
                                <div class="news-block__content -default">
                                    @php
                                        $category = $tab['category']->id ? $tab['category'] : null;
                                        $t = count($tab['posts']);
                                        $sliders = []; // chứa các slider con
                                        $s = 0;
                                        for ($i=0; $i < $t; $i++) { 
                                            if(!array_key_exists($s, $sliders)) $sliders[$s] = [];
                                            $sliders[$s][] = $tab['posts'][$i]; // mỗi slider con lại chứa 3 post
                                            if($i % 3 == 2) $s++;

                                        }
                                    @endphp
                                    @if (count($sliders))
                                        @foreach ($sliders as $slider)
                                            <div class="news-block__content__slide">
                                                <div class="row">
                                                    @if ($m = count($slider))
                                                        @php
                                                            $post = $slider[0];
                                                            
                                                        @endphp
                                                        <div class="col-12">
                                                            <div class="post-card -large">
                                                                <a class="card__cover" href="{{$u = $post->getViewUrl()}}">
                                                                    <img src="{{$post->getImage('770x385')}}" alt="{{$post->title}}" />
                                                                </a>
                                                                <div class="card__content">
                                                                    @if ($category)
                                                                        <h5 class="card__content-category">{{$category->name}}</h5>
                                                                    @elseif ($post->category)
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
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                @for ($i = 1; $i < $m; $i++)
                                                                    @if ($post = $slider[$i])
                                                                    
                                                                        <div class="col-12 col-sm-6">
                                                                            
                                                                            <div class="post-card -small">
                                                                                <a class="card__cover" href="{{$u = $post->getViewUrl()}}">
                                                                                    <img src="{{$post->getImage('thumb')}}" alt="{{$post->title}}" />
                                                                                </a>
                                                                                <div class="card__content">
                                                                                    @if ($category)
                                                                                        <h5 class="card__content-category">{{$category->name}}</h5>
                                                                                    @elseif ($post->category)
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
                                                                        </div>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>