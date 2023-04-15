<!DOCTYPE html>
<html lang="en">


<head>
    @include($_template.'head')
</head>

<body class="ms-body ms-primary-theme ms-logged-out">
    <!-- Preloader -->
    <div id="preloader-wrap">
        <div class="spinner spinner-8">
            <div class="ms-circle1 ms-child"></div>
            <div class="ms-circle2 ms-child"></div>
            <div class="ms-circle3 ms-child"></div>
            <div class="ms-circle4 ms-child"></div>
            <div class="ms-circle5 ms-child"></div>
            <div class="ms-circle6 ms-child"></div>
            <div class="ms-circle7 ms-child"></div>
            <div class="ms-circle8 ms-child"></div>
            <div class="ms-circle9 ms-child"></div>
            <div class="ms-circle10 ms-child"></div>
            <div class="ms-circle11 ms-child"></div>
            <div class="ms-circle12 ms-child"></div>
        </div>
    </div>
    <!-- Overlays -->
    
    <!-- Main Content -->
    <main class="body-content">
        
        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper ms-auth">
            <div class="ms-auth-container">
                <div class="ms-auth-col">
                    <div class="ms-auth-form">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        
    </main>
    <!-- MODALS -->
    @yield('modal')
    @include($_template.'js')
</body>



</html>