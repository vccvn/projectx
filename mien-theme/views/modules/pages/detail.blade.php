@extends($_layout . 'master')
@section('title', $page_title)
@include($_lib . 'register-meta')

@section('body.class', 'article-page')
@section('content')

    @switch($article->id)
        @case($options->theme->about->about_page_id)
            <div class="post-detail-content article-content about-page">
                <div class="inner-content">
                    {!! $html->about_contents->components !!}
                </div>
            </div>
        @break

        @default
            <div class="post-detail-content article-content single-post">
                @include($_template . 'page-header', [
                    'title' => $page_title,
                    'sub_title' => isset($category) ? $category->name : '',
                ])

                <div class="container">
                    <div class="single-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
    @endswitch

@endsection
