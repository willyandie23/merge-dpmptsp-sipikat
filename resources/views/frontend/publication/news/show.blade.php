@extends('frontend.layouts.app')

@push('css')
    <style>
        .widget-post .dz-title-hover:hover {
            color: var(--primary) !important;
            transition: color 0.3s ease;
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
                        <span class="text-primary fw-semibold" style="font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">Publikasi</span>
                        <h2 class="mb-0" style="font-size: 2rem; font-weight: 700; line-height: 1.2;">Berita</h2>
                    </div>
                    <div class="dz-separator style-1 text-primary mb-0 flex-grow-1" style="margin-top: 28px;"></div>
                </div>
                {{-- Breadcrumb di bawah judul --}}
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb mb-0" style="font-size: 0.82rem;">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.index') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('news.index') }}">Berita</a>
                        </li>
                        <li class="breadcrumb-item active text-muted">
                            {{ Str::limit($newsItem->title, 40) }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            {{-- KONTEN UTAMA --}}
            <div class="col-xl-8 col-lg-8">
                <div class="dz-card blog-single style-1">

                    {{-- Gambar Utama --}}
                    @if ($newsItem->image)
                    <div class="dz-media" style="border-radius: 12px; overflow: hidden; max-height: 480px;">
                        <img src="{{ asset('storage/' . $newsItem->image) }}"
                            alt="{{ $newsItem->title }}"
                            class="w-100"
                            style="object-fit: cover; height: 480px;">
                    </div>
                    @endif

                    <div class="dz-info mt-4">

                        {{-- Judul --}}
                        <h2 class="dz-title" style="font-size: 1.8rem; line-height: 1.4;">
                            {{ $newsItem->title }}
                        </h2>

                        {{-- Meta Info --}}
                        <div class="dz-meta my-3">
                            <ul class="d-flex align-items-center gap-3 flex-wrap"
                                style="list-style: none; padding: 0; margin: 0;">
                                <li class="d-flex align-items-center gap-1"
                                    style="font-size: 0.88rem;">
                                    <i class="far fa-calendar-alt text-primary"></i>
                                    {{ $newsItem->created_at->translatedFormat('d F Y') }}
                                </li>
                                <li class="d-flex align-items-center gap-1"
                                    style="font-size: 0.88rem;">
                                    <i class="far fa-user text-primary"></i>
                                    {{ $newsItem->author }}
                                </li>
                            </ul>
                        </div>

                        <div class="dz-separator style-1 text-primary mb-4"></div>

                        {{-- Deskripsi --}}
                        <div class="dz-post-text" style="font-size: 1rem; line-height: 1.9; color: #444;">
                            {!! $newsItem->description !!}
                        </div>

                        {{-- Share & Kembali --}}
                        <div class="dz-separator style-1 text-primary mt-3 mb-4"></div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-5">
                            <a href="{{ route('news.index') }}"
                                class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2">
                                <i class="fas fa-arrow-left"></i> Kembali ke Berita
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- SIDEBAR - BERITA TERBARU --}}
            <div class="col-xl-4 col-lg-4">
                <aside class="side-bar sticky-top" style="top: 100px;">
                    <div class="widget widget-post">
                        <div class="widget-title">
                            <h4 class="title">Berita Terbaru</h4>
                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>
                        <ul class="mt-3" style="list-style: none; padding: 0;">
                            @foreach ($latestNews as $latest)
                            <li class="d-flex gap-3 mb-3 pb-3"
                                style="border-bottom: 1px solid #f0f0f0;">
                                @if ($latest->image)
                                <img src="{{ asset('storage/' . $latest->image) }}"
                                    alt="{{ $latest->title }}"
                                    style="width:75px; height:58px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                                @endif
                                <div>
                                    <a href="{{ route('news.show', $latest->id) }}"
                                        class="fw-semibold text-dark dz-title-hover"
                                        style="font-size: 0.85rem; line-height: 1.4; display:block;">
                                        {{ Str::limit($latest->title, 55) }}
                                    </a>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $latest->created_at->translatedFormat('d M Y') }}
                                    </small>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        
    </script>
@endpush