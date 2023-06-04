@extends($_layout . 'master')
@section('title', $page_title)
@include($_lib . 'register-meta')

@section('body.class', 'article-page')
@section('content')

    <div class="post-detail-content article-content single-post">
        @include($_template . 'page-header', [
            'title' => $page_title,
            'sub_title' => isset($category)? $category->name : '',
        ])

        <div class="container">
            <div class="single-content">
                {!! $article->content !!}
            </div>
        </div>
    </div>

@endsection