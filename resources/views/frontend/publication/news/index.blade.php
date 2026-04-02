@extends('frontend.layouts.app')

@push('css')
    <style>
        /* Title max 2 baris */
        .dz-card .dz-title a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Featured title max 3 baris */
        .dz-card.featured-news .dz-title a {
            -webkit-line-clamp: 3;
        }
        /* Description max 3 baris */
        .dz-card .dz-post-text p {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
                @if ($news->currentPage() > 1)
                <p class="text-muted mt-1 mb-0" style="font-size: 0.85rem;">
                    Halaman {{ $news->currentPage() }} dari {{ $news->lastPage() }}
                </p>
                @endif
            </div>
        </div>

        @if ($news->currentPage() == 1)
            {{-- ==================== HALAMAN 1: Featured + Regular Grid ==================== --}}
            @php 
                $items = $news->items(); 
                $totalItems = count($items);
            @endphp

            {{-- 1. Featured Section (index 0-2) --}}
            @if ($totalItems > 0)
            <div class="row mb-4">
                {{-- Berita Besar (index 0) --}}
                @if (isset($items[0]))
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="dz-card blog-grid style-1 h-100 aos-item featured-news" data-aos="fade-up" data-aos-duration="1000">
                        @if ($items[0]->image)
                        <div class="dz-media" style="height: 380px; overflow: hidden; border-radius: 8px;">
                            <a href="{{ route('news.show', $items[0]->id) }}">
                                <img src="{{ asset('storage/' . $items[0]->image) }}" alt="{{ $items[0]->title }}" style="width:100%; height:380px; object-fit:cover;">
                            </a>
                        </div>
                        @endif
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">{{ $items[0]->created_at->translatedFormat('d F Y') }}</li>
                                    <li class="post-user">By {{ Str::limit($items[0]->author, 20) }}</li>
                                </ul>
                            </div>
                            <h3 class="dz-title">
                                <a href="{{ route('news.show', $items[0]->id) }}">{{ $items[0]->title }}</a>
                            </h3>
                            <div class="dz-post-text text">
                                <p>{{ Str::limit(strip_tags($items[0]->description), 450) }}</p>
                            </div>
                            <a href="{{ route('news.show', $items[0]->id) }}" class="btn-link">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Kolom kanan untuk berita kecil (index 1 & 2) --}}
                @if ($totalItems >= 2)
                <div class="col-xl-4 col-lg-4 col-md-4 d-flex flex-column gap-4">
                    @for ($i = 1; $i <= 2; $i++)
                        @if (isset($items[$i]))
                        <div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $i == 1 ? '200' : '400' }}">
                            @if ($items[$i]->image)
                            <div class="dz-media" style="height: 100px; overflow:hidden; border-radius:8px;">
                                <a href="{{ route('news.show', $items[$i]->id) }}">
                                    <img src="{{ asset('storage/' . $items[$i]->image) }}" alt="{{ $items[$i]->title }}" style="width:100%; height:100px; object-fit:cover;">
                                </a>
                            </div>
                            @endif
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-date">{{ $items[$i]->created_at->translatedFormat('d F Y') }}</li>
                                        <li class="post-user">By {{ Str::limit($items[$i]->author, 10) }}</li>
                                    </ul>
                                </div>
                                <h5 class="dz-title">
                                    <a href="{{ route('news.show', $items[$i]->id) }}">{{ Str::limit($items[$i]->title, 20) }}</a>
                                </h5>
                                <div class="dz-post-text text">
                                    <p>{{ Str::limit(strip_tags($items[$i]->description), 40) }}</p>
                                </div>
                                <a href="{{ route('news.show', $items[$i]->id) }}" class="btn-link">Selengkapnya</a>
                            </div>
                        </div>
                        @endif
                    @endfor
                </div>
                @endif
            </div>
            @endif

            {{-- 2. Regular Grid (index 3 dst) - SATU ROW TUNGGAL --}}
            @if ($totalItems > 3)
            <div class="row">
                @for ($i = 3; $i < $totalItems; $i++)
                    @php $item = $items[$i]; @endphp
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                        <div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            @if ($item->image)
                            <div class="dz-media" style="height: 200px; overflow:hidden; border-radius:8px;">
                                <a href="{{ route('news.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width:100%; height:200px; object-fit:cover;">
                                </a>
                            </div>
                            @endif
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-date">{{ $item->created_at->translatedFormat('d F Y') }}</li>
                                        <li class="post-user">By {{ Str::limit($item->author, 10) }}</li>
                                    </ul>
                                </div>
                                <h5 class="dz-title">
                                    <a href="{{ route('news.show', $item->id) }}">{{ Str::limit($item->title, 60) }}</a>
                                </h5>
                                <div class="dz-post-text text">
                                    <p>{{ Str::limit(strip_tags($item->description), 90) }}</p>
                                </div>
                                <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            @endif

        @else
            {{-- ==================== HALAMAN 2+ : Grid biasa 3 kolom ==================== --}}
            <div class="row">
                @foreach ($news as $item)
                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        @if ($item->image)
                        <div class="dz-media" style="height: 200px; overflow:hidden; border-radius:8px;">
                            <a href="{{ route('news.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="width:100%; height:200px; object-fit:cover;">
                            </a>
                        </div>
                        @endif
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">{{ $item->created_at->translatedFormat('d F Y') }}</li>
                                    <li class="post-user">By {{ Str::limit($item->author, 10) }}</li>
                                </ul>
                            </div>
                            <h5 class="dz-title">
                                <a href="{{ route('news.show', $item->id) }}">{{ Str::limit($item->title, 60) }}</a>
                            </h5>
                            <div class="dz-post-text text">
                                <p>{{ Str::limit(strip_tags($item->description), 90) }}</p>
                            </div>
                            <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        {{-- Pagination --}}
        @if ($news->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Blog Pagination">
                    <ul class="pagination text-center m-b30">
                        <li class="page-item {{ $news->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link prev" href="{{ $news->previousPageUrl() }}">
                                <i class="la la-angle-left"></i>
                            </a>
                        </li>
                        @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                        <li class="page-item">
                            <a class="page-link {{ $page == $news->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ !$news->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link next" href="{{ $news->nextPageUrl() }}">
                                <i class="la la-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        @endif

    </div>
@endsection

@push('scripts')
    <script></script>
@endpush