@extends($_layout . 'master')
@section('title', $page_title)
@include($_lib . 'register-meta')

@section('body.class', 'product-page')
@section('content')
    @php
        $hasPromo = $product->hasPromo();
        // $reviews = $product->getReviewData();
        $hasOption = $product->hasOption();
        $u = $product->getViewUrl();
        $user = $request->user();
        add_product_schema($product);
        
        $reviewAnalytics = $product->getReviewData();
        
    @endphp
    @php
        $thumbnails = $product->getThumbnailOrderOption();
        $thumbnailImages = [];
        if ($thumbnails) {
            foreach ($thumbnails as $thumbAttr) {
                if (is_array($attrValues = $thumbAttr->values) && count($attrValues)) {
                    foreach ($attrValues as $attrVal) {
                        if ($attrVal->thumbnail) {
                            $thumbnailImages[] = $attrVal;
                        }
                    }
                }
            }
        }
    @endphp
    <div id="product-container" class="product-container">
        <div id="product-detail" class="product-detail  {{ parse_classname('product-detail') }}">
            <div class="inner-content">
                <div class="row">
                    <div class="col-md-6 col-image">
                        <div class="product-gallery">

                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper swiper-viewer">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImage() }}" class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                    </div>
                                    @if ($thumbnailImages)
                                        @foreach ($thumbnailImages as $thumb)
                                            <div class="swiper-slide">
                                                <img src="{{ $thumb->thumbnail }}" id="pav-thumbnail-{{ $thumb->value_id }}" class="img-fluid blur-up lazyload" alt="{{ $thumb->text }}">
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($product->gallery && count($product->gallery))
                                        @foreach ($product->gallery as $item)
                                            <div class="swiper-slide">
                                                <img src="{{ $item->url }}" class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div thumbsSlider="" class="swiper swiper-thumbnails">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImage() }}" class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                    </div>
                                    @if ($thumbnailImages)
                                        @foreach ($thumbnailImages as $thumb)
                                            <div class="swiper-slide">
                                                <img src="{{ $thumb->thumbnail }}" id="pav-thumbnail-{{ $thumb->value_id }}" class="img-fluid blur-up lazyload" alt="{{ $thumb->text }}">
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($product->gallery && count($product->gallery))
                                        @foreach ($product->gallery as $item)
                                            <div class="swiper-slide">
                                                <img src="{{ $item->url }}" class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-info">
                        <div class="product-info {{ parse_classname('product-detail-info', 'product-detail-info-' . $product->id) }}" id="product-detail-{{ $product->id }}" data-id="{{ $product->id }}">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price-box">

                                @if ($hasPromo && $product->price_status > -1)
                                    <span class="old-price">
                                        {{ $product->priceFormat('list') }}
                                    </span>
                                    {{-- <span class="onsale-label">-{{$product->getDownPercent()}}%</span> --}}
                                @endif

                                <span class="regular-price  {{ parse_classname('product-price') }}">{{ $product->priceFormat('final') }}</span>
                            </div>

                            <div class="product-detail-content">
                                {!! $product->detail !!}
                            </div>

                            @if ($ecommerce->allow_place_order && $product->price_status > 0 && $product->status > 0 && $product->available_in_store)
                                <form action="{{ route('client.orders.add-to-cart') }}" method="post" class="{{ $product->price_status < 0 ? '' : parse_classname('product-order-form') }}"data-check-required="{{ $ecommerce->allow_place_order && $product->price_status > 0 && $product->status > 0 && $product->available_in_store ? 'true' : 'false' }}">

                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" class="{{ parse_classname('product-order-id') }}">
                                    <input type="hidden" name="redirect" value="checkout">


                                    {!! $product->attributesToHtml([
                                        'section_class' => '',
                                        'attribute_class' => '',
                                        'attribute_name_class' => '',
                                        'value_list_class' => '',
                                        'value_item_class' => '',
                                        'select_class' => '',
                                        'image_class' => '',
                                        'value_text_class' => '',
                                        'radio_class' => '',
                                        'value_label_class' => '',
                                    ]) !!}





                                    <div class="addeffect-section quantity-block">


                                        <h6 class="quantity-label d-block">Số lượng</h6>

                                        <div class="qty-box">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity" class="form-control input-number {{ $product->price_status < 0 ? '' : parse_classname('product-order-quantity', 'quantity') }}" value="1" min="1" step="1">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>


                                    </div>
                                    @if ($product->note)
                                        <div class="product-note">
                                            {!! nl2br($product->note) !!}
                                        </div>
                                    @endif
                                    <div class="product-buttons">
                                        <button type="submit" class="btn btn-primary btn-add-to-cart ">
                                            <span class="text">Thêm giỏ hàng</span>
                                        </button>
                                    </div>
                                </form>
                            @elseif(!$product->available_in_store)
                                <div class="alert alert-danger">
                                    Sản phẩm tạm hết hàng
                                </div>
                            @endif

                            <ul class="share-buttons">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{$u}}&amp;src=sdkpreparse" target="_blank"><img src="{{theme_asset('images/facebook.png')}}" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="{{theme_asset('images/instagram.png')}}" alt=""></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (count($list = $product->getRelated([
            '@limit' => 6,
                '@with' => ['gallery', 'promoAvailable'],
                '@withOption' => true
        ])))
            
            <div class="relative-products">
                <h3 class="list-title">
                    Có thể bạn sẽ thích
                </h3>
                <div class="product-list row">
                    @foreach ($list as $item)
                        <div class="col-sm-2 col-lg-4 col-item">
                            <div class="product-item">
                                @php
                                    $hasPromo = $item->hasPromo();
                                    $reviews = $item->getReviewData();
                                    $hasOption = $item->hasOption();
                                    $u = $item->getViewUrl();
                                    $style_attrs = $item->style_attrs ?? [];
                                    $downPercent = $item->getDownPercent();
                                    $listPrice = $item->priceFormat('list');
                                    $finalPrice = $style_attrs ? get_currency_format($item->checkPrice($item->style_attrs)) : $item->priceFormat('final');
                                @endphp
                                <div class="thumbnail">
                                    <a href="{{ $u }}">
                                        <img class="product-thumbnail" src="{{ $item->getImage() }}" alt="{{ $item->name }}">
                                    </a>
                                </div>
                                @if ($item->labels && count($item->labels))
                                    <div class="product-labels">
                                        @foreach ($item->labels as $label)
                                            <div class="label-item" style="background-color: {{$label->bg_color??'#000'}}; color: {{$label->text_color??'#fff'}}">
                                                {{$label->title}}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="info">
                                    <h4 class="product-name"><a href="{{ $u }}">{{ $item->name }}</a></h4>
                                    <div class="product-price">
                                        <span>{{ $finalPrice }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

@endsection
