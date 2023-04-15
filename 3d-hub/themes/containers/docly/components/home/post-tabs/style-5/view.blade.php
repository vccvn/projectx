@php
$postParams = gute_post_params($data, '', [
    '@withCountPublishComments' => 'comment_count',
    '@withAuthor' => true,
], 24, 1);
$title = $postParams->title;
$link = $postParams->link;
extract(gute_post_tabs($postParams, 6));

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
                        <div class="news-block__content -hoz-small">
                            @if ($t = count($sliders = $tab['sliders']))
                                @php
                                    $category = $tab['category']->id ? $tab['category'] : null;
                                @endphp
                                @foreach ($sliders as $slider)
                                    @if ($l = count($slider))
                                        <div class="news-block__content__slide">
                                            <div class="row">
                                                @foreach ($slider as $i => $post)
                                                    <div class="col-12 col-md-6">
                                                        <div class="post-card -theme--blue -small -horizontal">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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