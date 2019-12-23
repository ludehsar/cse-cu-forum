<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>CSE CU Forum - @yield('title')</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="{{ asset('frontend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

        <!-- Custom styles for this template -->
        <link href="{{ asset('frontend/css/clean-blog.css') }}" rel="stylesheet">

        <!-- Core js !important -->
        <script src="{{ asset('js/app.js') }}" async defer></script>
    </head>

    <body>

        <div id="app">
            @include('frontend.parts.navbar')
            <div style="margin-top: 120px;">
                @yield('content')        
            </div>
        </div>
        
        <hr>
        
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; CSE CU Forum {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Custom scripts for this template -->
        <script src="{{ asset('frontend/js/clean-blog.js') }}"></script>
    </body>
</html>
