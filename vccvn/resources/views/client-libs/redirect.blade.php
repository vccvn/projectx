<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirect ...</title>
</head>
<body>
    <p style="text-align:center; margin: 40px auto">
        Please click <a href="{{$url}}">Here</a> if not redirect to {{$url}}
    </p>
    <script>
        var url = '{{$url}}';
        if(url){
            top.location.replace(url);
        }
    </script>
</body>
</html>