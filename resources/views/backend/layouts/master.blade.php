<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Dashbaord Admin DPMPTSP Katingan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- Favicon - Force Refresh Version -->
<link rel="icon" href="{{ asset('build/images/favicon.ico') }}?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('build/images/favicon.ico') }}?v={{ now()->timestamp }}" type="image/x-icon">

<link rel="icon" href="/build/images/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="/build/images/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">

<link rel="icon" href="/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico?v={{ now()->timestamp }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @include('backend/layouts.head-css')
</head>

<body data-layout="detached" data-topbar="colored">
    <!-- Begin page -->
    <div class="container-fluid">
        <div id="layout-wrapper">
            @include('backend/layouts.topbar')
            @include('backend/layouts.sidebar')
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('backend/layouts.footer')
            </div>

        </div>
    </div>

               @include('backend/layouts.right-sidebar')
    @include('backend/layouts/vendor-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/js/ckeditor.js'])

    @stack('script')

    {{-- SCRIPT LOGOUT SWEETALERT - VERSI PALING KUAT --}}
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ SweetAlert Logout script loaded');

            const logoutBtn = document.getElementById('sidebar-logout-btn');
            
            if (logoutBtn) {
                console.log('✅ Tombol logout ditemukan');

                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan keluar dari sistem admin",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            } else {
                console.warn('⚠️ Tombol #sidebar-logout-btn TIDAK ditemukan di DOM');
            }
        });
    </script>
    @endpush

</body>
</html>