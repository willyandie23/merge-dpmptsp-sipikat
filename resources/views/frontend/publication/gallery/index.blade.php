@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Galeri
@endsection

@push('css')
    <style>
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
        }

        .gallery-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            display: block;
        }

        .gallery-card:hover img {
            transform: scale(1.07);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px;
            text-align: center;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay .gallery-icon {
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 8px;
        }

        .gallery-overlay .gallery-title {
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
            line-height: 1.3;
        }

        /* ==================== MODAL GAMBAR ORIGINAL ==================== */
        #galleryModal .modal-dialog {
            max-width: 920px;
        }

        #galleryModal .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        #galleryModal .modal-img {
            width: 100%;
            height: auto;
            max-height: 82vh;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            background: #f8f9fa;
        }

        #galleryModal .modal-body {
            padding: 24px;
        }

        #galleryModal .modal-title-text {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        #galleryModal .modal-desc-text {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.7;
            margin: 0;
        }

        #galleryModal .btn-close-modal {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s;
        }

        #galleryModal .btn-close-modal:hover {
            background: rgba(0, 0, 0, 0.85);
            transform: rotate(90deg);
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
                        <h2 class="mb-0" style="font-size: 2rem; font-weight: 700; line-height: 1.2;">Galeri</h2>
                    </div>
                    <div class="dz-separator style-1 text-primary mb-0 flex-grow-1" style="margin-top: 28px;"></div>
                </div>
                @if ($gallerys->currentPage() > 1)
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.85rem;">
                        Halaman {{ $gallerys->currentPage() }} dari {{ $gallerys->lastPage() }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Bento Grid Layout --}}
        @php
            $layouts = [
                // Baris 1
                ['col' => 'col-xl-8 col-lg-8 col-md-8', 'height' => '380px'],
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '380px'],
                // Baris 2
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '240px'],
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '240px'],
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '240px'],
                // Baris 3
                ['col' => 'col-xl-6 col-lg-6 col-md-6', 'height' => '300px'],
                ['col' => 'col-xl-6 col-lg-6 col-md-6', 'height' => '300px'],
                // Baris 4
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '260px'],
                ['col' => 'col-xl-8 col-lg-8 col-md-8', 'height' => '260px'],
                // Baris 5
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '300px'],
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '300px'],
                ['col' => 'col-xl-4 col-lg-4 col-md-4', 'height' => '300px'],
                // Baris 6
                ['col' => 'col-xl-5 col-lg-5 col-md-6', 'height' => '340px'],
                ['col' => 'col-xl-7 col-lg-7 col-md-6', 'height' => '340px'],
                // Baris 7
                ['col' => 'col-xl-6 col-lg-6 col-md-6', 'height' => '260px'],
                ['col' => 'col-xl-3 col-lg-3 col-md-6', 'height' => '260px'],
                ['col' => 'col-xl-3 col-lg-3 col-md-6', 'height' => '260px'],
                // Baris 8
                ['col' => 'col-xl-12 col-lg-12 col-md-12', 'height' => '320px'],
            ];
        @endphp

        @if ($gallerys->isNotEmpty())
            <div class="row g-3 mb-4">
                @foreach ($gallerys as $item)
                    @php $layout = $layouts[$loop->index % 18]; @endphp
                    <div class="{{ $layout['col'] }} aos-item" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                        <div class="gallery-card" style="height: {{ $layout['height'] }};" data-bs-toggle="modal"
                            data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $item->image) }}"
                            data-title="{{ $item->title }}" data-description="{{ $item->description ?? '' }}">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                            <div class="gallery-overlay">
                                <div class="gallery-icon">
                                    <i class="fas fa-expand-alt"></i>
                                </div>
                                <div class="gallery-title">{{ Str::limit($item->title, 50) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <i class="fas fa-images text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada galeri tersedia.</p>
                </div>
            </div>
        @endif

        {{-- Pagination --}}
        @if ($gallerys->hasPages())
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <nav aria-label="Gallery Pagination">
                        <ul class="pagination text-center m-b30">
                            <li class="page-item {{ $gallerys->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link prev" href="{{ $gallerys->previousPageUrl() }}">
                                    <i class="la la-angle-left"></i>
                                </a>
                            </li>
                            @foreach ($gallerys->getUrlRange(1, $gallerys->lastPage()) as $page => $url)
                                <li class="page-item">
                                    <a class="page-link {{ $page == $gallerys->currentPage() ? 'active' : '' }}"
                                        href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li class="page-item {{ !$gallerys->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link next" href="{{ $gallerys->nextPageUrl() }}">
                                    <i class="la la-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        @endif

    </div>

    {{-- Gallery Modal - GAMBAR ORIGINAL FULL SIZE --}}
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden" style="border-radius: 12px;">
                <div style="position: relative;">
                    <button class="btn-close-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                    <img id="modalImage" src="" alt="" class="modal-img">
                </div>
                <div class="modal-body">
                    <p class="modal-title-text" id="modalTitle"></p>
                    <p class="modal-desc-text" id="modalDesc"></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const galleryModal = document.getElementById('galleryModal');
        galleryModal.addEventListener('show.bs.modal', function(e) {
            const trigger = e.relatedTarget;

            const modalImg = document.getElementById('modalImage');
            modalImg.src = trigger.getAttribute('data-image');
            modalImg.alt = trigger.getAttribute('data-title');

            document.getElementById('modalTitle').textContent = trigger.getAttribute('data-title');
            document.getElementById('modalDesc').textContent = trigger.getAttribute('data-description') || '';
        });
    </script>
@endpush
