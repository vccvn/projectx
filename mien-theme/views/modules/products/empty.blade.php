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
                    @if ($t == 'all')
                        <div class="product-banners">
                            {!! $html->product_banners->components !!}
                        </div>
                    @endif


                    <div class="alert alert-warning text-center">
                        Không tìm thấy kết quả phù hợp!
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
