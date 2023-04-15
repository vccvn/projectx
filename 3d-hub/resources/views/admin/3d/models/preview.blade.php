<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>preview</title>
    <link rel="stylesheet" href="{{asset('static/manager/css/model-preview.min.css')}}">
    <style>
        .pre-loading-image{
            background: url("{{$model->getThumbnail()}}") no-repeat center center;
            background-size: cover;
        }
    </style>
</head>
<body>
    
    <div class="fix-pos">
        <div class="pre-loading-image">
            {{-- <img src="{{$model->getThumbnail()}}" alt=""> --}}
            
        </div>
        <div class="load-block">
            <div class="mb-3 text-center">
                Crazy 3D
            </div>
            <div class="progress m-progress--lg">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="preview-progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <div id="app-root"></div>
    
    </div>
    <script>
        var model_data = @json($model->toArray());
    </script>
    <script src="{{asset('static/manager/js/r3d.bundle.js')}}"></script>
    <script src="{{asset('static/manager/js/model-preview.js')}}"></script>
</body>
</html>
