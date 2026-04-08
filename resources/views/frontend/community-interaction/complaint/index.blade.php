@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Pengaduan
@endsection

@push('css')
    <style>
        .com-banner-slider {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            --swiper-navigation-color: var(--primary);
            --swiper-pagination-color: var(--primary);
        }
        .com-banner-slide img {
            width: 100% !important;
            height: 300px !important;           /* Ukuran sama dengan FAQ Banner */
            object-fit: cover !important;
            display: block;
        }

        /* Responsive Mobile (sama seperti FAQ) */
        @media (max-width: 991px) {
            .com-banner-slide img {
                height: 240px !important;
            }
        }
        @media (max-width: 768px) {
            .com-banner-slide img {
                height: 220px !important;
            }
        }

        .com-banner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.35);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3rem;
            color: #fff;
        }
        .com-banner-title { 
            font-size: 2rem; 
            font-weight: 800; 
            letter-spacing: .03em; 
        }
        .com-banner-desc { 
            max-width: 520px; 
            margin-top: .75rem; 
            font-size: .95rem; 
        }

        /* ==================== MEKANISME CARD ==================== */
        .mekanisme-card {
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            min-height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(var(--primary-rgb), 0.25);
        }
        .mekanisme-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(var(--primary-rgb), 0.35);
        }
        .mekanisme-card .title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.3;
        }

        /* ==================== MODAL ==================== */
        #mekanismeModal .modal-dialog { max-width: 720px; }
        #mekanismeModal .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        #mekanismeModal .modal-header {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 1.25rem 1.75rem;
        }
        #mekanismeModal .modal-img {
            width: 100%;
            height: auto;
            max-height: 420px;
            object-fit: contain;
            background: #f8f9fa;
        }
        #mekanismeModal .modal-body { padding: 24px; }
        #mekanismeModal .modal-title { font-size: 1.35rem; font-weight: 700; }
        #mekanismeModal .modal-desc {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
        }
        .youtube-embed {
            position: relative;
            padding-top: 56.25%;
            background: #000;
        }
        .youtube-embed iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-5">

        {{-- Banner --}}
        @if($banners->count())
            <div class="com-banner-slider mb-5">
                <div class="swiper comSwiper">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            <div class="swiper-slide com-banner-slide">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
                                <div class="com-banner-overlay">
                                    <div class="com-banner-title">{{ $banner->title }}</div>
                                    @if($banner->description)
                                        <p class="com-banner-desc mb-0">{{ $banner->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        @endif

        {{-- Mekanisme Pengaduan --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary" style="font-size: 2rem;">Mekanisme Pengaduan</h2>
        </div>

        @if($mekanismes->count())
            <div class="row g-4">
                @foreach($mekanismes as $mek)
                    @php
                        // Konversi URL YouTube ke embed (sama persis dengan halaman Video)
                        $embedUrl = null;
                        if ($mek->url) {
                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $mek->url, $matches);
                            $videoId = $matches[1] ?? null;
                            if ($videoId) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&rel=0';
                            }
                        }
                    @endphp

                    <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                        <div class="mekanisme-card"
                             data-bs-toggle="modal"
                             data-bs-target="#mekanismeModal"
                             data-name="{{ $mek->name }}"
                             data-description="{{ $mek->description }}"
                             data-image="{{ $mek->image ? asset('storage/' . $mek->image) : '' }}"
                             data-embed="{{ $embedUrl }}">
                            <div class="title">{{ $mek->name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <p>Belum ada data mekanisme pengaduan.</p>
            </div>
        @endif

        {{-- Tombol Ajukan Pengaduan --}}
        <div class="text-center mt-5">
            {{-- <p class="mb-2 text-muted">Tidak Menemukan Jawaban?</p> --}}
            {{-- <p class="fw-semibold mb-3">Kami siap membantu.</p> --}}
            {{-- <a href="#" class="d-inline-flex align-items-center gap-2 text-primary mb-4">
                <i class="fas fa-sync fa-2x"></i>
                <span class="fs-5">Hubungi Kami</span> 
            </a>  --}}
            {{--  <br>   --}}
            <a href="#" class="btn btn-primary btn-lg px-5 py-3 rounded-3">
                Ajukan Pengaduan &gt;&gt;
            </a>
        </div>

    </div>

    {{-- MODAL MEKANISME --}}
    <div class="modal fade" id="mekanismeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="modalName"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- Gambar --}}
                    <div id="modalImageContainer" class="mb-4 text-center d-none">
                        <img id="modalImage" src="" alt="" class="modal-img rounded-3 shadow-sm">
                    </div>

                    {{-- YouTube --}}
                    <div id="modalYoutubeContainer" class="mb-4 d-none">
                        <div class="youtube-embed">
                            <iframe id="modalYoutube" src="" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <p id="modalDescription" class="modal-desc"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Swiper Banner
            if (typeof Swiper !== 'undefined') {
                new Swiper('.comSwiper', {
                    loop: true,
                    pagination: { el: '.comSwiper .swiper-pagination', clickable: true },
                    navigation: {
                        nextEl: '.comSwiper .swiper-button-next',
                        prevEl: '.comSwiper .swiper-button-prev'
                    },
                    autoplay: { delay: 5000, disableOnInteraction: false }
                });
            }

            // Modal YouTube (sama persis dengan halaman Video yang berhasil)
            const modalEl = document.getElementById('mekanismeModal');

            modalEl.addEventListener('show.bs.modal', function (e) {
                const trigger = e.relatedTarget;

                const name  = trigger.getAttribute('data-name');
                const desc  = trigger.getAttribute('data-description');
                const image = trigger.getAttribute('data-image');
                const embed = trigger.getAttribute('data-embed');

                document.getElementById('modalName').textContent = name;
                document.getElementById('modalDescription').innerHTML = desc || '<em>Tidak ada deskripsi.</em>';

                // Reset
                document.getElementById('modalImageContainer').classList.add('d-none');
                document.getElementById('modalYoutubeContainer').classList.add('d-none');

                // Tampilkan gambar jika ada
                if (image) {
                    document.getElementById('modalImage').src = image;
                    document.getElementById('modalImageContainer').classList.remove('d-none');
                }

                // Tampilkan YouTube jika ada
                if (embed) {
                    document.getElementById('modalYoutube').src = embed;
                    document.getElementById('modalYoutubeContainer').classList.remove('d-none');
                }
            });

            // Reset iframe saat modal ditutup (agar video berhenti)
            modalEl.addEventListener('hidden.bs.modal', function () {
                const iframe = document.getElementById('modalYoutube');
                if (iframe) iframe.src = '';
            });
        });
    </script>
@endpush