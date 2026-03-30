<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <!-- User Widget - Nama & Role Dinamis -->
        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="{{ URL::asset('build/images/users/avatar-2.png') }}" alt=""
                    class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">
                <a href="#" class="text-body fw-medium font-size-16">
                    {{ auth()->user()->name }}
                </a>
                <p class="text-muted mt-1 mb-0 font-size-13">
                    {{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}
                </p>
            </div>
        </div>

        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Menu Utama</li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('backend.index') }}" class="waves-effect">
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
                        <li><a href="{{ route('backend.banner-dashboard.index') }}">Banner Dashboard</a></li>
                        <li><a href="{{ route('backend.banner-integritas.index') }}">Banner Integritas</a></li>
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
                        <li><a href="{{ route('backend.news.index') }}">Berita</a></li>
                        <li><a href="{{ route('backend.gallery.index') }}">Galeri</a></li>
                        <li><a href="{{ route('backend.video.index') }}">Video</a></li>
                        <li><a href="{{ route('backend.komoditas-unggulan.index') }}">Komoditas Unggulan</a></li>
                    </ul>
                </li>

                <!-- Peluang Investasi & Wilayah -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-finance"></i>
                        <span>Peluang Investasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.peluang-investasi.index') }}">Data Peluang Investasi</a></li>
                        <li><a href="{{ route('backend.kecamatan.index') }}">Data Kecamatan</a></li>
                        <li><a href="{{ route('backend.sektor.index') }}">Sektor Usaha</a></li>
                        <li><a href="{{ route('backend.pertumbuhan-ekonomi.index') }}">Pertumbuhan Ekonomi</a></li>
                    </ul>
                </li>

                <!-- Statistik Layanan -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-chart-pie"></i>
                        <span>Statistik Layanan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.survey.index') }}">Hasil Survey</a></li>
                        <li><a href="{{ route('backend.perizinan-terbit.index') }}">Perizinan Terbit</a></li>
                    </ul>
                </li>

                <!-- Struktur Organisasi -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-group"></i>
                        <span>Struktur Organisasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backend.bidang.index') }}">Data Bidang</a></li>
                        <li><a href="{{ route('backend.struktur-organisasi.index') }}">Pegawai & Pejabat</a></li>
                    </ul>
                </li>

                <!-- Tentang DPMTSP -->
                <li>
                    <a href="{{ route('backend.tentang-dpmptsp.index') }}" class="waves-effect">
                        <i class="mdi mdi-information-outline"></i>
                        <span>Tentang DPMTSP</span>
                    </a>
                </li>

                <!-- FAQ -->
                <li>
                    <a href="{{ route('backend.faq.index') }}" class="waves-effect">
                        <i class="mdi mdi-help-circle-outline"></i>
                        <span>FAQ</span>
                    </a>
                </li>

                <!-- Mekanisme Pengaduan -->
                <li>
                    <a href="{{ route('backend.mekanisme-pengaduan.index') }}" class="waves-effect">
                        <i class="mdi mdi-message-alert-outline"></i>
                        <span>Mekanisme Pengaduan</span>
                    </a>
                </li>

                {{-- ==================== MENU KHUSUS SUPER ADMIN ==================== --}}
                @if (auth()->user()->hasRole('superadmin'))
                    <li class="menu-title">Super Admin</li>

                    <li>
                        <a href="{{ route('backend.users.index') }}" class="waves-effect">
                            <i class="mdi mdi-account-multiple"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('backend.app-logs.index') }}" class="waves-effect">
                            <i class="mdi mdi-history"></i>
                            <span>App Log</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->

<!-- Script untuk Active Menu + Collapse -->
@push('script')
    <script>
        $(document).ready(function () {
            var currentUrl = window.location.href.toLowerCase();

            $('#side-menu a').each(function () {
                var linkHref = $(this).attr('href');

                if (linkHref && linkHref !== '#' && linkHref !== 'javascript: void(0);') {
                    if (currentUrl.includes(linkHref.toLowerCase()) ||
                        window.location.pathname === linkHref) {

                        $(this).addClass('active');
                        $(this).parents('ul.sub-menu').addClass('in').attr('aria-expanded', 'true');
                        $(this).closest('li').addClass('mm-active');
                        $(this).parents('li.has-arrow').addClass('mm-active');
                    }
                }
            });

            // Inisialisasi MetisMenu
            $('#side-menu').metisMenu();
        });
    </script>
@endpush
