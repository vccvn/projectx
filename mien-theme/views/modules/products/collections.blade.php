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
                    
                    @if (count($collections))
                        <div class="product-list row">
                            @foreach ($collections as $item)
                                <div class="col-sm-2 col-lg-4 col-item">
                                    <div class="product-item">
                                        @php
                                            // $u = $item->getViewUrl();
                                            $u = route('client.products', ['collection' => $item->id]);
                                            // $url.="?collection=" . $item->id;
                                            
                                        @endphp
                                        <div class="thumbnail">
                                            <a href="{{ $u }}">
                                                <img class="product-thumbnail" src="{{ $item->image }}" alt="{{ $item->name }}">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <h4 class="product-name"><a href="{{ $u }}">{{ $item->name }}</a></h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mien-pagination">
                            {{ $collections->links($_template . 'pagination') }}
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
