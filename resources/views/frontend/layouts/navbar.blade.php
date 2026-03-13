<!-- Header -->
<header class="site-header mo-left header style-1">

    <!-- Main Header -->
    <div class="sticky-header main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix ">
            <div class="container-fluid clearfix">
                <!-- Website Logo -->
                <div class="logo-header mostion logo-dark">
                    <a href="{{ route('home.index') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
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
                        <a href="{{ route('home.index') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
                    </div>
                    <ul class="nav navbar-nav navbar navbar-left">
                        <li class="sub-menu {{ request()->routeIs('home.index') ? 'active' : '' }}">
                            <a href="{{ route('home.index') }}">Beranda</a>
                        </li>
                        <li class="sub-menu-down {{ request()->routeIs('about.index', 'organization_structure.index', 'field.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);">Profil</a>
                            <ul class="sub-menu">
                                <li class="{{ request()->routeIs('about.index') ? 'active' : '' }}">
                                    <a href="{{ route('about.index') }}">Tentang DPMPTSP</a>
                                </li>
                                <li class="{{ request()->routeIs('organization_structure.index') ? 'active' : '' }}">
                                    <a href="{{ route('organization_structure.index') }}">Struktur Organisasi</a>
                                </li>
                                <li class="{{ request()->routeIs('field.index') ? 'active' : '' }}">
                                    <a href="{{ route('field.index') }}">Sekretariat & Bidang</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu-down"><a href="javascript:void(0);">Mal Pelayanan Publik</a>
                            <ul class="sub-menu">
                                <li><a href="#">Tentang Mal Pelayanan Publik</a></li>
                                <li><a href="#">Tenan & Layanan</a></li>
                                <li><a href="#">Standar Layanan</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu-down {{ request()->routeIs('com_sat_sur.index', 'licensing_process.index', 'complaint.index', 'faq.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);">Interaksi Masyarakat</a>
                            <ul class="sub-menu">
                                <li class="{{ request()->routeIs('com_sat_sur.index') ? 'active' : '' }}">
                                    <a href="{{ route('com_sat_sur.index') }}">Hasil Survey Kepuasan Masyarakat</a>
                                </li>
                                <li class="{{ request()->routeIs('licensing_process.index') ? 'active' : '' }}">
                                    <a href="{{ route('licensing_process.index') }}">Hasil Proses Perizinan</a>
                                </li>
                                <li class="{{ request()->routeIs('complaint.index') ? 'active' : '' }}">
                                    <a href="{{ route('complaint.index') }}">Pengaduan</a>
                                </li>
                                <li class="{{ request()->routeIs('faq.index') ? 'active' : '' }}">
                                    <a href="{{ route('faq.index') }}">FAQ</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu-down {{ request()->routeIs('news.index', 'gallery.index', 'video.index') ? 'active' : '' }}">
                            <a href="javascript:void(0);">Publikasi</a>
                            <ul class="sub-menu">
                                <li class="{{ request()->routeIs('news.index') ? 'active' : '' }}">
                                    <a href="{{ route('news.index') }}">Berita</a>
                                </li>
                                <li class="{{ request()->routeIs('gallery.index') ? 'active' : '' }}">
                                    <a href="{{ route('gallery.index') }}">Galeri</a>
                                </li>
                                <li class="{{ request()->routeIs('video.index') ? 'active' : '' }}">
                                    <a href="{{ route('video.index') }}">Video</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Header End -->
</header>
