<!-- Footer -->
<footer class="site-footer style-1" id="footer" style="background-image:url({{ asset('frontend/images/background/pattern3.png') }})">
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    <div class="widget">
                        <div class="widget-title">
                            <h4 class="title text-primary">DPMPTSP KABUPATEN KATINGAN</h4>
                        </div>
                        <div class="text-muted text-justify" style="text-align: justify;">
                            Jl. Garuda No II, Kasongan Lama, Katingan Hilir, Kasongan Lama, Kabupaten Katingan, Kalimantan Tengah 74411
                        </div>
                        <div class="text-start mt-4">
                            <ul class="social-list style-1">
                                {{-- Internet/Website --}}
                                {{-- <li><a href="javascript:void(0);"><i class="fas fa-globe"></i></a></li> --}}
                                
                                {{-- Facebook --}}
                                <li><a href="https://www.facebook.com/share/1GbJiNx3dh/?mibextid=wwXIfr" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                
                                {{-- Instagram --}}
                                <li><a href="https://www.instagram.com/dpmptsp.katingankab?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                
                                {{-- X (Twitter) --}}
                                {{-- <li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li> --}}
                                
                                {{-- YouTube --}}
                                <li><a href="https://youtube.com/@dpmptspkatinganbidangp2ip2m?si=dnGVTtoqH5DXFjQg" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                
                                {{-- TikTok --}}
                                {{-- <li><a href="javascript:void(0);"><i class="fab fa-tiktok"></i></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="800">
                    <div class="widget widget_categories">
                        <div class="widget-title">
                            <h4 class="title">Data dan Informasi</h4>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>
                        <ul class="list-1">
                            <li class="cat-item"><a href="https://portal.katingankab.go.id/" target="_blank">Portal Katingan</a></li>
                            <li class="cat-item"><a href="https://oss.go.id/id" target="_blank">OSS</a></li>
                            <li class="cat-item"><a href="https://oss.go.id/id/kbli" target="_blank">KBLI</a></li>
                            <li class="cat-item"><a href="https://regionalinvestment.bkpm.go.id/" target="_blank">PIR</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="800">
                    <div class="widget widget_categories">
                        <div class="widget-title">
                            <h4 class="title">Layanan</h4>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>
                        <ul class="list-1">
                            <li class="cat-item"><a href="https://singkah.katingankab.go.id/" target="_blank">Informasi Wisata</a></li>
                            <li class="cat-item"><a href="https://mpppenyanghinjesimpei.katingankab.go.id/" target="_blank">Konsultasi Investasi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 aos-item" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="1000">
                    <div class="widget widget_getintuch">
                        <div class="widget-title">
                            <h4 class="title">Kontak Kami</h4>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>

                        {{-- Tombol WhatsApp --}}
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="btn d-flex align-items-center justify-content-center gap-2 mt-3"
                            style="background-color: #25D366; color: #fff; border-radius: 8px; padding: 10px 16px; text-decoration: none; font-weight: 600;">
                            <i class="fab fa-whatsapp" style="font-size: 1.4rem;"></i>
                            Chat Via WhatsApp
                        </a>

                        {{-- Statistik Pengunjung --}}
                        <ul class="list-unstyled mt-4" style="line-height: 2.2;">
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-calendar-day text-primary"></i>
                                <span>Pengunjung Hari Ini</span>
                                <span class="ms-auto fw-bold">{{ $daily ?? 0 }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-users text-primary"></i>
                                <span>Total Pengunjung</span>
                                <span class="ms-auto fw-bold">{{ $total ?? 0 }}</span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center fb-inner spno">
                <div class="col-lg-12 col-md-12 text-center">
                    <span class="copyright-text">Copyright © <span class="current-year">2026</span> <a
                            href="https://dexignzone.com/" class="text-primary" target="_blank">SIPIKAT</a> All
                        Rights Reserved.</span>
                </div>
                {{-- <div class="col-lg-6 col-md-12 text-end">
                    <ul class="footer-link d-inline-block">
                        <li><a href="javascript:void(0);">Privacy Policy</a></li>
                        <li><a href="javascript:void(0);">Team &amp; Condition</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
</footer>
