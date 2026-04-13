<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Dashbaord Admin DPMPTSP Katingan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
   <link rel="icon" href="{{ asset('build/images/favicon.ico') }}?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('build/images/favicon.ico') }}?v={{ now()->timestamp }}" type="image/x-icon">

<link rel="icon" href="/build/images/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="/build/images/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">

<link rel="icon" href="/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">

    @include('backend/layouts.head-css')
</head>

<body>

    @yield('content')

    @include('backend/layouts.vendor-scripts')
</body>

</html>
