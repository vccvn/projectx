@php
$postParams = gute_post_params($data, '', [
    '@withCountPublishComments' => 'comment_count',
    '@withAuthor' => true,
], 15, 1);
$title = $postParams->title;
$link = $postParams->link;
extract(gute_post_tabs($postParams, 4));

@endphp
<div class="container">
    <div class="blog-ocean__content">

        <div class="news-block -theme--blue">
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
                        <div class="news-block__content -hoz">
                            @if ($t = count($sliders = $tab['sliders']))
                                @php
                                    $category = $tab['category']->id ? $tab['category'] : null;
                                @endphp
                                @foreach ($sliders as $slider)
                                    @php
                                        $post = $slider[0]??null;
                                        $l = count($slider);
                                    @endphp
                                    @if ($l)
                                        <div class="news-block__content__slide">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="post-card -theme--blue -large -horizontal -large">
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
                                                                @if ($post->author)
                                                                    
                                                                <div class="info__time info__author">
                                                                    <i class="far fa-user"></i>
                                                                    <p>{{$post->author->name}}</p>
                                                                </div>
                                                            
                                                                @endif
                                                                <div class="info__time">
                                                                    <i class="far fa-clock"></i>
                                                                    <p>{{$post->dateFormat('d/m/Y')}}</p>
                                                                </div>
                                                                <div class="info__comment"><i class="far fa-comment"></i>
                                                                    <p>{{$post->comment_count}}</p>
                                                                </div>
                                                            </div>
                                                            <p class="card__content-description">{{$post->getShortDesc(300)}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        @foreach ($slider as $i => $post)
                                                            @if ($i < 1)
                                                                @continue
                                                            @endif
                                                            <div class="col-12 col-sm-6 col-md-4">
                                                                <div class="post-card -theme--blue -small">
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
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>