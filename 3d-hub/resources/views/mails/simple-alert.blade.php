<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông báo</title>
</head>
<body>
    <div class="cw-wrapper">
        <h3>Xin chào, 
            @if (isset($name))
                {{$name}}
            @endif
        </h3>
        <p>
            {!! nl2br($content) !!}
        </p>

    </div>
</body>
</html>