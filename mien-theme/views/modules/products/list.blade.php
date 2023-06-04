@extends($_layout . 'master')
@section('title', $page_title)
@include($_lib . 'register-meta')

@section('body.class', 'product-page')
@section('content')

    <div class="product-list-content">
        @include($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ])
        @php
            // $tabs = get_product_page_tabs();
            $t = $tab ?? 'all';
        @endphp

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-12 col-main">

                    @include($_current . 'templates.tabs', ['tab' => $t])
                    @if ($t == 'all' && $html->product_banners && $html->product_banners->getComponents())
                        <div class="product-banners">
                            {!! $html->product_banners->components !!}
                        </div>
                    @endif

                    @if (count($products))
                        <div class="product-list row">
                            @foreach ($products as $product)
                                <div class="col-sm-2 col-lg-4 col-item">
                                    <div class="product-item">
                                        @php
                                            $hasPromo = $product->hasPromo();
                                            $reviews = $product->getReviewData();
                                            $hasOption = $product->hasOption();
                                            $u = $product->getViewUrl();
                                            $style_attrs = $product->style_attrs ?? [];
                                            $downPercent = $product->getDownPercent();
                                            $listPrice = $product->priceFormat('list');
                                            $finalPrice = $style_attrs ? get_currency_format($product->checkPrice($product->style_attrs)) : $product->priceFormat('final');
                                        @endphp
                                        <div class="thumbnail">
                                            <a href="{{ $u }}">
                                                <img class="product-thumbnail" src="{{ $product->getImage() }}" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        @if ($product->labels && count($product->labels))
                                            <div class="product-labels">
                                                @foreach ($product->labels as $label)
                                                    <div class="label-item" style="background-color: {{$label->bg_color??'#000'}}; color: {{$label->text_color??'#fff'}}">
                                                        {{$label->title}}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="info">
                                            <h4 class="product-name"><a href="{{ $u }}">{{ $product->name }}</a></h4>
                                            <div class="product-price">
                                                <span>{{ $finalPrice }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mien-pagination">
                            {{ $products->links($_template . 'pagination') }}
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            Không tìm thấy kết quả phù hợp!
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
