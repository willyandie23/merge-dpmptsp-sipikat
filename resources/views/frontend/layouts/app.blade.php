<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="DPMPTSP" />
    <meta property="og:title" content="DPMPTSP" />
    <meta property="og:description" content="DPMPTSP" />
    <meta property="og:image" content="https://archcode.dexignzone.com/xhtml/social-image.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title', 'DPMPTSP')</title>

    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">

    <!-- Stylesheet -->
    {{-- <link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('frontend/vendor/lightgallery/css/lightgallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/aos/aos.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/rangeslider/rangeslider.css') }}">
    <link rel="stylesheet" class="skin" href="{{ asset('frontend/css/skin/skin-1.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('build/materialdesignicons.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        .page-wraper {
            overflow-y: hidden;
        }

        .sub-menu li.active > a {
            color: var(--primary) !important;
            font-weight: 600;
        }

    </style>

    @stack('css')
    @stack('styles')

</head>

<body id="bg" class="theme-rounded">
    <div id="loading-area" class="loading-page-1">
        <div class="spinner">
            <div class="ball"></div>
            <p>LOADING</p>
        </div>
    </div>
    <div class="page-wraper">

        @include('frontend.layouts.navbar')

        @yield('content')

        @include('frontend.layouts.footer')

        {{-- <button href="#" class="scroltop icon-up" type="button"><i class="fas fa-arrow-up"></i></button> --}}

    </div>
    <!-- JAVASCRIPT FILES ========================================= -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ asset('frontend/vendor/rangeslider/rangeslider.js') }}"></script><!-- RANGESLIDER -->
    <script src="{{ asset('frontend/vendor/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
    <script src="{{ asset('frontend/vendor/lightgallery/js/lightgallery-all.min.js') }}"></script><!-- LIGHTGALLERY -->
    <script src="{{ asset('frontend/vendor/counter/waypoints-min.js') }}"></script><!-- WAYPOINTS JS -->
    <script src="{{ asset('frontend/vendor/counter/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
    <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script><!-- OWL-CAROUSEL -->
    <script src="{{ asset('frontend/vendor/aos/aos.js') }}"></script><!-- AOS -->
    <script src="{{ asset('frontend/js/dz.carousel.js') }}"></script><!-- OWL-CAROUSEL -->
    <script src="{{ asset('frontend/js/dz.ajax.js') }}"></script><!-- AJAX -->
    <script src="{{ asset('frontend/js/custom.js') }}"></script><!-- CUSTOM JS -->

    @stack('scripts')
</body>

</html>
