<!-- Header -->
<header class="site-header mo-left header style-1">

    <!-- Main Header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix ">
            <div class="container-fluid clearfix">
                <!-- Website Logo -->
                <div class="logo-header mostion logo-dark">
                    <a href="index.html"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
                </div>
                <!-- Nav Toggle Button -->
                <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-nav navbar-collapse collapse justify-content-center" id="navbarNavDropdown">
                    <div class="logo-header logo-dark">
                        <a href="index.html"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
                    </div>
                    <ul class="nav navbar-nav navbar navbar-left">
                        {{-- <li class="sub-menu-down active"><a href="javascript:void(0);">Home</a>
                            <ul class="sub-menu">
                                <li><a href="index.html">Home 1</a></li>
                                <li><a href="index-2.html">Home 2</a></li>
                            </ul>
                        </li> --}}
                        <li class="sub-menu active">
                            <a href="{{ route('home.index') }}">Beranda</a>
                        </li>
                        <li class="sub-menu-down"><a href="javascript:void(0);">Profil</a>
                            <ul class="sub-menu">
                                <li><a href="#">Tentang DPMPTSP</a></li>
                                <li><a href="#">Struktur Organisasi</a></li>
                                <li><a href="#">Sekretarian & Bidang</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu-down"><a href="javascript:void(0);">Mal Pelayanan Publik</a>
                            <ul class="sub-menu">
                                <li><a href="#">Tentang Mal Pelayanan Publik</a></li>
                                <li><a href="#">Tenan & Layanan</a></li>
                                <li><a href="#">Standar Layanan</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu-down"><a href="javascript:void(0);">Interaksi Masyarakat</a>
                            <ul class="sub-menu">
                                <li><a href="#">Hasil Survey Kepuasan Masyarakat</a></li>
                                <li><a href="#">Hasil Proses Perizinan</a></li>
                                <li><a href="#">Pengaduan</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu-down"><a href="javascript:void(0);">Publikasi</a>
                            <ul class="sub-menu">
                                <li><a href="#">Berita</a></li>
                                <li><a href="#">Galery</a></li>
                                <li><a href="#">Video</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->
</header>
