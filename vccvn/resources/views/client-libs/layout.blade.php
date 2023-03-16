<!doctype html>
<html {!! $html->getTagAttributeToString('html', ['lang' => 'vi']) !!}>
<head>
    @include($_lib.'head')
</head>
<body {!! $html->getTagAttributeToString('body') !!}>

    {!! $html->top->embeds !!}

    @yield('body')

    {!! $html->bottom->embeds !!}
    @include($_lib.'js')


</body>
</html>