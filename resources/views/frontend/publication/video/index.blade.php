@extends('frontend.layouts.app')

@push('css')
    <style>
        .video-card {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .video-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.14);
        }

        /* Thumbnail wrapper dengan play button overlay */
        .video-thumbnail {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 */
            overflow: hidden;
            background: #000;
        }
        .video-thumbnail img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .video-card:hover .video-thumbnail img {
            transform: scale(1.05);
        }
        .video-play-btn {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.25);
            transition: background 0.3s ease;
        }
        .video-card:hover .video-play-btn {
            background: rgba(0,0,0,0.45);
        }
        .video-play-btn span {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.92);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #ff0000;
            transition: transform 0.3s ease;
        }
        .video-card:hover .video-play-btn span {
            transform: scale(1.12);
        }

        /* Info */
        .video-info {
            padding: 14px 16px 16px;
        }
        .video-info .video-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 6px;
            color: #222;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .video-info .video-desc {
            font-size: 0.82rem;
            color: #777;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        /* Modal Video */
        #videoModal .modal-dialog {
            max-width: 800px;
        }
        #videoModal .modal-content {
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }
        #videoModal .modal-header {
            background: #111;
            border: 0;
            padding: 10px 16px;
        }
        #videoModal .modal-header .modal-title {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 600;
        }
        #videoModal .modal-header .btn-close {
            filter: invert(1);
        }
        .video-responsive {
            position: relative;
            padding-top: 56.25%;
            background: #000;
        }
        .video-responsive iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">

        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span class="text-primary fw-semibold"
                            style="font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">Publikasi</span>
                        <h2 class="mb-0" style="font-size: 2rem; font-weight: 700; line-height: 1.2;">Video</h2>
                    </div>
                    <div class="dz-separator style-1 text-primary mb-0 flex-grow-1"
                        style="margin-top: 28px;"></div>
                </div>
                @if ($videos->currentPage() > 1)
                <p class="text-muted mt-1 mb-0" style="font-size: 0.85rem;">
                    Halaman {{ $videos->currentPage() }} dari {{ $videos->lastPage() }}
                </p>
                @endif
            </div>
        </div>

        {{-- Video Grid --}}
        @if ($videos->isNotEmpty())
        <div class="row g-4 mb-4">
            @foreach ($videos as $item)
            @php
                // Konversi URL YouTube ke embed + ambil thumbnail
                preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $item->url, $matches);
                $videoId   = $matches[1] ?? null;
                $embedUrl  = $videoId ? 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&rel=0' : null;
                $thumbnail = $videoId ? 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg' : null;
            @endphp
            @if ($videoId)
            <div class="col-xl-4 col-lg-4 col-md-6 aos-item"
                data-aos="fade-up" data-aos-duration="800"
                data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="video-card"
                    data-bs-toggle="modal"
                    data-bs-target="#videoModal"
                    data-embed="{{ $embedUrl }}"
                    data-title="{{ $item->title }}">
                    <div class="video-thumbnail">
                        <img src="{{ $thumbnail }}" alt="{{ $item->title }}">
                        <div class="video-play-btn">
                            <span><i class="fab fa-youtube"></i></span>
                        </div>
                    </div>
                    <div class="video-info">
                        <div class="video-title">{{ $item->title }}</div>
                        @if ($item->description)
                        <p class="video-desc">{{ $item->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="fab fa-youtube text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada video tersedia.</p>
            </div>
        </div>
        @endif

        {{-- Pagination --}}
        @if ($videos->hasPages())
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <nav aria-label="Video Pagination">
                    <ul class="pagination text-center m-b30">
                        <li class="page-item {{ $videos->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link prev" href="{{ $videos->previousPageUrl() }}">
                                <i class="la la-angle-left"></i>
                            </a>
                        </li>
                        @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
                        <li class="page-item">
                            <a class="page-link {{ $page == $videos->currentPage() ? 'active' : '' }}"
                                href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ !$videos->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link next" href="{{ $videos->nextPageUrl() }}">
                                <i class="la la-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        @endif

    </div>

    {{-- Video Modal --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="videoModalTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="video-responsive">
                    <iframe id="videoIframe" src="" allowfullscreen
                        allow="autoplay; encrypted-media"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const videoModal = document.getElementById('videoModal');

        // Saat modal dibuka — set iframe src + judul
        videoModal.addEventListener('show.bs.modal', function (e) {
            const trigger = e.relatedTarget;
            document.getElementById('videoIframe').src      = trigger.getAttribute('data-embed');
            document.getElementById('videoModalTitle').textContent = trigger.getAttribute('data-title');
        });

        // Saat modal ditutup — reset iframe src agar video berhenti
        videoModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('videoIframe').src = '';
        });
    </script>
@endpush
