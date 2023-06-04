@extends($_layout . 'master')
@section('meta.robots', 'noindex')
@section('title', '404 - Không tìm thấy')

@section('content')
    <!-- 404 Section Start -->
    <section class="page-not-found section-b-space section">
        <div class="container">
            <div class="row gx-md-2 gx-0 gy-md-0 gy-3">
                <div class="col-md-5 col-xl-4 col-xxl-3">
                    <div class="page-image">
                        <img src="{{ theme_asset('images/inner-page/404.png') }}" class="img-fluid blur-up lazyload" alt="">
                    </div>
                </div>

                <div class="col-md-7 mt-md-0 mt-3 col-xl-5 d-flex flex-center">
                    <div class="text-center text-md-left">
                        <div>
                            <h2 class="mb-2">Không tìm thấy</h2>
                            <p class="mb-3">Trang mà bạn truy cập có thể đang bị lỗi tạm thời hoặc đã bị xóa, bạn có thể truy cập sau hoặc xem thêm các sản phẩm hấp dẫn khác trên website <strong>Wisestyle.vn</strong></p>
                            <a href="{{ route('home') }}" class="btn btn-colored-default">Về Trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>


            @php
                $args = [];
                $routeParams = [];
                $url = route('client.products');
                $args['@limit'] = 4;
                $args['@sorttype'] = 'rand()';
                $url .= '?sorttype=6';
                
                if ($args) {
                    $args = array_merge($args, [
                        '@with' => ['promoAvailable'],
                        '@withOption' => true,
                        '@withGallery' => true,
                        '@withCategory' => true,
                    ]);
                }
            @endphp
            @if ($args && count($list = $helper->getProducts($args)))
                <div class="product-page">
                    <div class="container">

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
                                                    <div class="label-item" style="background-color: {{ $label->bg_color ?? '#000' }}; color: {{ $label->text_color ?? '#fff' }}">
                                                        {{ $label->title }}
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
                        <div class="section-buttons mt-10 text-center d-sm-none">
                            <a href="{{ $url }}" class="btn btn-outline-default btn-def-size">Xem thêm</a>
                        </div>
                    </div>
                </div>




            @endif


        </div>
    </section>
    <!-- 404 Section End -->
@endsection
