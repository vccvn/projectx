@extends($_layout . 'master')
@section('title', $page_title)
@include($_lib . 'register-meta')

@section('body.class', 'post-page')
@section('content')

    <div class="post-list-content">
        @include($_template . 'page-header', [
            'title' => $page_title,
            'sub_title' => isset($parent) && $parent ? $parent->title: null,
        ])

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-8 col-main">
                    @if (count($pages))

                        <div class="row post-list blog-list posts blogs mien-posts mien-blogs">

                            @foreach ($pages as $post)
                                <div class="col-sm-6">
                                    <div class="post-item blog-item">
                                        <div class="item-header">
                                            <h4 class="item-title">
                                                <a href="{{ $u = $post->getViewUrl() }}" class="post-link">
                                                    {{ $post->title }}
                                                </a>
                                            </h4>
                                            @if (isset($parent) && $parent)
                                                <div class="item-cate">
                                                    <a href="{{ $parent->getViewUrl() }}" class="post-link">
                                                        {{ $parent->name }}
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="item-body">

                                            <a href="{{ $u }}" class="item-img">
                                                <img src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}" class="item-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="mien-pagination">
                            {{ $pages->links($_template . 'pagination') }}
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-sidebar mt-30 mt-lg-0">
                    <div class="sidebar">
                        {!! $html->sidebar_pages->components !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
