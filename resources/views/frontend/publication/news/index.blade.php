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
                {{-- Tampilkan info halaman jika bukan halaman 1 --}}
                @if ($news->currentPage() > 1)
                <p class="text-muted mt-1 mb-0" style="font-size: 0.85rem;">
                    Halaman {{ $news->currentPage() }} dari {{ $news->lastPage() }}
                </p>
                @endif
            </div>
        </div>

        @forelse ($news as $item)
            @php $index = $loop->index; @endphp

            @if ($news->currentPage() == 1)

                @if ($index == 0)
                <div class="row mb-4">
                @endif

                    {{-- Item 0: Berita besar (kiri) --}}
                    @if ($index == 0)
                    <div class="col-xl-8 col-lg-8 col-md-8">
                        <div class="dz-card blog-grid style-1 h-100 aos-item featured-news"
                            data-aos="fade-up" data-aos-duration="1000">
                            @if ($item->image)
                            <div class="dz-media" style="height: 380px; overflow: hidden; border-radius: 8px;">
                                <a href="{{ route('news.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->title }}"
                                        style="width:100%; height:380px; object-fit:cover;">
                                </a>
                            </div>
                            @endif
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-date">
                                            {{ $item->created_at->translatedFormat('d F Y') }}
                                        </li>
                                        <li class="post-user">
                                            By {{ Str::limit($item->author, 20) }}
                                        </li>
                                    </ul>
                                </div>
                                <h3 class="dz-title">
                                    <a href="{{ route('news.show', $item->id) }}">
                                        {{ Str::limit($item->title) }}
                                    </a>
                                </h3>
                                <div class="dz-post-text text">
                                    <p>{{ Str::limit(strip_tags($item->description), 450) }}</p>
                                </div>
                                <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                            </div>
                        </div>
                    </div>

                    {{-- Buka kolom kanan untuk item 1 & 2 --}}
                    <div class="col-xl-4 col-lg-4 col-md-4 d-flex flex-column gap-4">
                    @endif

                    {{-- Item 1 & 2: Berita kecil (kanan, stacked) --}}
                    @if ($index == 1 || $index == 2)
                    <div class="dz-card blog-grid style-1 aos-item"
                        data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="{{ $index == 1 ? '200' : '400' }}">
                        @if ($item->image)
                        <div class="dz-media" style="height: 100px; overflow:hidden; border-radius:8px;">
                            <a href="{{ route('news.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    style="width:100%; height:100px; object-fit:cover;">
                            </a>
                        </div>
                        @endif
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </li>
                                    <li class="post-user">
                                        By {{ Str::limit($item->author, 10) }}
                                    </li>
                                </ul>
                            </div>
                            <h5 class="dz-title">
                                <a href="{{ route('news.show', $item->id) }}">
                                    {{ Str::limit($item->title, 20) }}
                                </a>
                            </h5>
                            <div class="dz-post-text text">
                                <p>{{ Str::limit(strip_tags($item->description), 40) }}</p>
                            </div>
                            <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                        </div>
                    </div>
                    @endif

                @if ($index == 2)
                    </div> {{-- tutup col kanan --}}
                </div>  {{-- tutup row featured --}}
                <div class="row">
                @endif

                {{-- Item 3 dst: Grid 3 kolom --}}
                @if ($index >= 3)
                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="dz-card blog-grid style-1 aos-item"
                        data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        @if ($item->image)
                        <div class="dz-media" style="height: 200px; overflow:hidden; border-radius:8px;">
                            <a href="{{ route('news.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    style="width:100%; height:200px; object-fit:cover;">
                            </a>
                        </div>
                        @endif
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </li>
                                    <li class="post-user">
                                        By {{ Str::limit($item->author, 10) }}
                                    </li>
                                </ul>
                            </div>
                            <h5 class="dz-title">
                                <a href="{{ route('news.show', $item->id) }}">
                                    {{ Str::limit($item->title, 60) }}
                                </a>
                            </h5>
                            <div class="dz-post-text text">
                                <p>{{ Str::limit(strip_tags($item->description), 90) }}</p>
                            </div>
                            <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endif

                @if ($loop->last && $index >= 3)
                </div>
                @endif

            @else
            {{-- HALAMAN 2+: Grid biasa 3 per baris --}}

                @if ($index == 0)
                <div class="row">
                @endif

                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="dz-card blog-grid style-1 aos-item"
                        data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        @if ($item->image)
                        <div class="dz-media" style="height: 200px; overflow:hidden; border-radius:8px;">
                            <a href="{{ route('news.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    style="width:100%; height:200px; object-fit:cover;">
                            </a>
                        </div>
                        @endif
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </li>
                                    <li class="post-user">
                                        By {{ Str::limit($item->author, 10) }}
                                    </li>
                                </ul>
                            </div>
                            <h5 class="dz-title">
                                <a href="{{ route('news.show', $item->id) }}">
                                    {{ Str::limit($item->title, 60) }}
                                </a>
                            </h5>
                            <div class="dz-post-text text">
                                <p>{{ Str::limit(strip_tags($item->description), 90) }}</p>
                            </div>
                            <a href="{{ route('news.show', $item->id) }}" class="btn-link">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                @if ($loop->last)
                </div>
                @endif

            @endif

        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada berita tersedia.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if ($news->hasPages())
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <nav aria-label="Blog Pagination">
                    <ul class="pagination text-center m-b30">
                        <li class="page-item {{ $news->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link prev" href="{{ $news->previousPageUrl() }}">
                                <i class="la la-angle-left"></i>
                            </a>
                        </li>
                        @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                        <li class="page-item">
                            <a class="page-link {{ $page == $news->currentPage() ? 'active' : '' }}"
                                href="{{ $url }}">{{ $page }}</a>
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
    <script>
        
    </script>
@endpush