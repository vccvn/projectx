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
        <h3>Xin chào, {{$name}}</h3>
        <p>{{$admin}} vừa phản hồi liên hệ của bạn với nội dung sau:</p>
        <p>
            {!! nl2br($reply_message) !!}
        </p>

    </div>
</body>
</html>