<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{ URL::Asset('build/images/users/avatar-2.jpg') }}" alt=""
                    class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-body fw-medium font-size-16">Patrick Becker</a>
                <p class="text-muted mt-1 mb-0 font-size-13">UI/UX Designer</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu Utama</li>

                <!-- Dashboard -->
                <li>
                    <a href="" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Banner Section -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-image-filter-hdr"></i>
                        <span>Banner</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('backend.banner-dashboard.index') }}">
                                Banner Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('backend.banner-integritas.index') }}" class="waves-effect">
                                <span>Banner Integritas</span>
                            </a>
                        </li>
                        <li><a href="{{ route('backend.banner-faq.index') }}">Banner FAQ</a></li>
                    </ul>
                </li>

                <!-- Konten Utama -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-newspaper-variant"></i>
                        <span>Konten Utama</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('backend.news.index') }}" class="waves-effect">
                                <span>Berita</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('backend.gallery.index') }}" class="waves-effect">
                                <span>Galeri</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('backend.video.index') }}" class="waves-effect">
                                <span>Video</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('backend.komoditas-unggulan.index') }}" class="waves-effect">
                                <span>Komoditas Unggulan</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Peluang Investasi & Wilayah -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-finance"></i>
                        <span>Peluang Investasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="">Data Peluang Investasi</a>
                        </li>
                        <li>
                            <a href="{{ route('backend.kecamatan.index') }}">
                                Data Kecamatan
                            </a>
                        </li>
                        <li><a href="{{ route('backend.sektor.index') }}">Sektor Usaha</a></li>
                        <li><a href="">Pertumbuhan Ekonomi</a></li>
                    </ul>
                </li>

                <!-- Statistik Layanan -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-chart-pie"></i>
                        <span>Statistik Layanan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="">Hasil Survey</a></li>
                        <li><a href="">Perizinan Terbit</a></li>
                    </ul>
                </li>

                <!-- Struktur Organisasi -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-group"></i>
                        <span>Struktur Organisasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="">Data Bidang</a></li>
                        <li><a href="">Pegawai & Pejabat</a></li>
                    </ul>
                </li>

                <!-- Tentang DPMTSP -->
                <li>
                    <a href="" class="waves-effect">
                        <i class="mdi mdi-information-outline"></i>
                        <span>Tentang DPMTSP</span>
                    </a>
                </li>

                <!-- FAQ -->
                <li>
                    <a href="" class="waves-effect">
                        <i class="mdi mdi-help-circle-outline"></i>
                        <span>FAQ</span>
                    </a>
                </li>

                <!-- Mekanisme Pengaduan -->
                <li>
                    <a href="" class="waves-effect">
                        <i class="mdi mdi-message-alert-outline"></i>
                        <span>Mekanisme Pengaduan</span>
                    </a>
                </li>

                <!-- Menu Tambahan (opsional, bisa di-expand nanti) -->
                <li class="menu-title">Pengaturan</li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-cog-outline"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
