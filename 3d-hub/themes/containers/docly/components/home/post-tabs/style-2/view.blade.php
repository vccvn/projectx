
<div class="container">
    <div class="blog-section blog-food__section">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4 order-md-2">
                <div class="blog-sidebar">
                    @if ($data->social_show)
                        
                        <div class="blog-sidebar-section -category">
                            <div class="center-line-title">
                                <h5>{{$data->social_title}}</h5>
                            </div>
                            <div class="social-block">
                                @php
                                    $socials = $options->theme->socials;
                                    $list = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];
                                @endphp
                                @foreach ($list as $item)
                                    @if ($link = $socials->get($item))
                                        <a href="{{$link}}"><i class="fab fa-{{$item.($item=="facebook"?'-f':'')}}"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                    @endif
                    @if ($data->cate_show)
                        @php
                            $url = null;
                            $args = [
                                '@limit' => $data->cate_number?$data->cate_number:10,
                                '@sort' => $data->cate_sort,
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
                            <div class="blog-sidebar-section -category">
                                <div class="center-line-title">
                                    <h5>{{$title}}</h5>
                                </div>
                                <div class="category-block">
                                    @foreach ($categories as $category)
                                        <a class="category -square " href="{{$category->getViewUrl()}}">
                                            <div class="category__background" style="background-image: url({{$category->getFeatureImage()}})"></div>
                                            <h5 class="title">{{$category->name}}</h5>
                                            <h5 class="quantity">({{$category->post_count}})</h5>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endcount
                    @endif
                    @if ($data->newsletter_show)
                        <form method="post" action="{{route('client.subcribe')}}" class="{{parse_classname('subcribe-form')}} subcribe-box -theme--yellow subcribe-box">
                            <h5>{{$data->newsletter_title('Đăng ký nhận tin')}}</h5>
                            <p>{{$data->newsletter_description}}</p>
                            <input placeholder="Nhập email" name="email" type="email" />
                            <button type="submit" class="btn -normal">{{$data->newsletter_button('Đăng ký')}}</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8 order-md-1">
                @php

                    $postParams = gute_post_params($data, 'slider_', [
                        '@withCountPublishComments' => 'comment_count',
                        '@withAuthor' => true,
                    ], 15, 1);
                    $title = $postParams->title;
                    $link = $postParams->link;
                    extract(gute_post_tabs($postParams, 4));
                    
                @endphp
                <div class="news-block">
                    <div class="news-block__header">
                        <div class="header__controller__title">
                            <div class="center-line-title -large -mb-0">
                                <h5>{{$title}}</h5>
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
                        @foreach ($catePosts as $tab)
                            <div class="{{$tab['active']}} news-block__tab__item" data-tab-name="{{$tab['category']->slug}}">
                                <div class="news-block__content -default">
                                    @if ($t = count($sliders = $tab['sliders']))
                                        @php
                                            $category = $tab['category']->id ? $tab['category'] : null;
                                        @endphp
                                        @foreach ($sliders as $slider)                         
                                            <div class="news-block__content__slide">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            @foreach ($slider as $j => $post)
                                                                @if ($j > 1)
                                                                    @break
                                                                @endif
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="post-card null">
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
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @if (count($slider) > 2)
                                                        <div class="col-12">
                                                            <div class="row">
                                                                @foreach ($slider as $k => $post)
                                                                    @if ($k < 2)
                                                                        @continue
                                                                    @endif

                                                                    <div class="col-12 col-sm-6 col-lg-4">
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
                                                                @endforeach
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
                
                @php
                    $d = null;
                    $darg = [
                        '@paginate' => $options->posts->per_page(12)
                    ];
                    $listParams = gute_post_params($data, 'list_', [
                        '@withCountPublishComments' => 'comment_count'
                    ], 15, 1);
                    if($listParams->dynamic){
                        $dargs['dynamic_id'] = $listParams->dynamic->id;
                        $d = $listParams->dynamic;
                    }
                    $title = $listParams->title;
                    $link = $listParams->link;
                    extract(gute_post_tabs($listParams, 5));
                    
                @endphp
                
                <div class="blog-section blog-food__section -lastest-post">
                    <div class="news-block">
                        <div class="news-block__header">
                            <div class="header__controller__title">
                                <div class="center-line-title -large -mb-0">
                                    <h5>{{$title}}</h5>
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
                            @foreach ($catePosts as $tab)
                                <div class="{{$tab['active']}} news-block__tab__item" data-tab-name="{{$tab['category']->slug}}">
                                    <div class="news-block__content -default">
                                        @if ($t = count($sliders = $tab['sliders']))
                                            @php
                                                $category = $tab['category']->id ? $tab['category'] : null;
                                            @endphp
                                            @foreach ($sliders as $slider)                                                        
                                                <div class="news-block__content__slide">
                                                    @foreach ($slider as $post)
                                                        
                                                        <div class="post-card -small -horizontal">
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
                                                                <p class="card__content-description">{{$post->getShortDesc(120)}}</p>
                                                            </div>                                                        </div>
                                                    @endforeach
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

        @if ($listParams->dynamic && $dargs)
            @if (count($posts = $helper->getPosts($dargs)))
                @php
                    $posts->withPath($d->slug . '.html');
                @endphp
                {{$posts->links($_template.'pagination')}}
            @endif
        @endif
    </div>
</div>