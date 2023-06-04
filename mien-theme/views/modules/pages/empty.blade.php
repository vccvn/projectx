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
                    <div class="alert alert-warning text-center">
                        Không tìm thấy kết quả phù hợp!
                    </div>
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