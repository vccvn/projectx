<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yêu cầu tạo lại mật khẩu</title>
</head>
<body>
    <div class="cw-wrapper">
        <h3>Xin chào, {{$user->name}}</h3>
        <p>
            Hình như bạn vừa đăng ký tài khoản trên hệ thống của chúng tôi và chúng tôi cần phải xác minh xem đó có đúng là bạn hay không.
            <br>
            Vui lòng truy cập link bên dưới:
        </p>
        <p>
            link: <a href="{{$url}}">{{$url}}</a>
        </p>

        <p></p>
        <p></p>
        <p>Nếu không phải bạn vui lòng bỏ qua email này!</p>
        {{-- <p>Thân ái <a href="{{route('login')}}">DH Team</a></p> --}}
    </div>
</body>
</html>