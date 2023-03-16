<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yêu cầu Truy cập trang quản lý đơn hàng</title>
</head>
<body>
    <div class="cw-wrapper">
        <h3>Xin chào, {{$customer->name}}</h3>
        <p>
            Hình như bạn vừa yêu cầu truy cập trang quản lý đơn hàng.
            <br>
            Vui lòng nhấp vào <a href="{{$url}}">Đây</a> hoặc truy cập link bên dưới để tiếp tục
        </p>
        <p>
            link: <a href="{{$url}}">{{$url}}</a>
        </p>

        <p></p>
        <p></p>
        <p>Nếu không phải bạn vui lòng bỏ qua email này!</p>
    </div>
</body>
</html>