@extends($_layout.'angular')
@section('css')
<link rel="stylesheet" href="{{asset('static/manager/css/3d-pre-loading.min.css')}}" id="pre-loading-css-link">
<style>
    .pre-loading-image{
        background: url("{{$template->getThumbnail()}}") no-repeat center center;
        background-size: cover;
    }
</style>
@endsection
@section('append')
    
<div class="fix-pos">
    <div class="pre-loading-image">
    </div>
    <div class="load-block">
        <div class="mb-3 text-center">
            {{$template->name}}
        </div>
        <div class="progress m-progress--lg">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="preview-progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

</div>
@endsection
@section('config')

    @php
    $config = [
        'key' => uniqid(),
        'csrf' => csrf_token(),
        'urls' => [
            'base' => route($route_name_prefix . '3d.api.base') . '/',
            'logo_url' => siteinfo('fe_logo'),
            'logo_link' => '/admin',
            'templates' => route($route_name_prefix . '3d.templates') . '/',

        ],
        'data' => [
            'template' => $template,
        ]
    ];
    @endphp
    <script>
        window.__3DHub__ = @json($config);
    </script>
@endsection

@section('js')
     <script src="{{asset('static/manager/js/3d-editor.js')}}"></script>
@endsection