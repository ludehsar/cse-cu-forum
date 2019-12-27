<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CSE CU Forum - @yield('title')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="{{asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="{{ asset('frontend/vendor/font-awesome/css/font-awesome.min.css') }}">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="{{ asset('frontend/css/fontastic.css') }}">
        <!-- Google fonts - Open Sans-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
        <!-- Fancybox-->
        <link rel="stylesheet" href="{{ asset('frontend/vendor/@fancyapps/fancybox/jquery.fancybox.min.css') }}">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="{{ asset('frontend/css/style.default.css') }}" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
        <!-- Favicon-->
        <link rel="shortcut icon" href="favicon.png">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <body>
        @include('frontend.parts.navbar')
            @auth
                @if (Auth::user()->email_verified_at == NULL)
                    <section class="notification">
                        <div class="alert alert-primary" role="alert">
                            <strong>Your email has not been verified. </strong>
                            <a href="{{ route('verification.resend') }}">Click here to verify your email</a>.
                        </div>
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif
                    </section>
                @endif
            @endauth
        @yield('content')
        @include('frontend.parts.footer')
        <!-- JavaScript files-->
        <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/popper.js/umd/popper.min.js') }}"> </script>
        <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
        <script src="{{ asset('frontend/vendor/@fancyapps/fancybox/jquery.fancybox.min.js') }} "></script>
        <script src="https://kit.fontawesome.com/7cf490feed.js" crossorigin="anonymous"></script>
        <script src="{{ asset('frontend/js/front.js') }}"></script>
        <script src="{{ asset('js/frontend.js') }}"></script>
    </body>
</html>
