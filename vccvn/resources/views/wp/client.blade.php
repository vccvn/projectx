<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $user = get_owner();
        $webSetting = $user->userWebSetting;
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$user->name}} | Wordpress | Fpoly.vn</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
        }
        .container{
            display: flex;
            justify-content: center;
            align-items: center;
        }

            /* just aesthetics */
        .container{
            width:100vw;
            height: 100vh;
            margin: auto;
            text-align: center;
        }

        h2{
            margin-bottom: 15px;

        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>{{$user->name}}</h2>
            <p>Một trang web của Fpoly</p>

            <p>
                Vui lòng truy cập: <a href="{{$u = 'https://wp.'.$webSetting->domain}}">{{$u}}</a> để thiết lập
            </p>
            
        </div>
    </div>
</body>
</html>