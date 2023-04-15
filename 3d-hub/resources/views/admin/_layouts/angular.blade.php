<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SAAS for designer | Cretip Inc</title>
    <base href="/" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    
    
    <link rel="stylesheet" href="styles.css">

    @yield('css')
</head>

<body>
    @yield('prepend')
    <app-root class="angular-app-root"></app-root>
    @yield('append')
    <script src="{{asset('static/app/js/tasks.js')}}"></script>
    @yield('config')

    @yield('js')

    
<script src="runtime-es2015.js" type="module"></script><script src="runtime-es5.js" nomodule defer></script><script src="polyfills-es5.js" nomodule defer></script><script src="polyfills-es2015.js" type="module"></script><script src="vendor-es2015.js" type="module"></script><script src="vendor-es5.js" nomodule defer></script><script src="main-es2015.js" type="module"></script><script src="main-es5.js" nomodule defer></script>


</body>

</html>
