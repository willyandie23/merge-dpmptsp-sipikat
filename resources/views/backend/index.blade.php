@extends('backend/layouts.master')

@section('title', 'Dashboard')

@push('css')
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .main-content { padding-top: 100px !important; }
        .page-content { margin-top: -4rem !important; }

        .section-header {
            border-bottom: 3px solid #556ee6;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
        }

        .service-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12) !important;
        }

        .layanan-utama-img {
            height: 195px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .service-card:hover .layanan-utama-img {
            transform: scale(1.05);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            background: linear-gradient(135deg, #556ee6, #364574);
            color: white;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(85, 110, 230, 0.3);
        }

        .status-badge {
            font-size: 0.82rem;
            padding: 0.4em 0.85em;
        }

        .empty-state {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 3rem 2rem;
        }
    </style>
@endpush

@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Dashboard Admin</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Selamat Datang Kembali</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Utama Section -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Layanan Utama</h5>
                    <p class="text-muted mb-0">Layanan unggulan yang ditampilkan di halaman depan</p>
                </div>
                <a href="{{ route('backend.layanan-utama.index') }}" class="btn btn-primary">
                    <i class="mdi mdi-cog-outline me-1"></i> Kelola Semua
                </a>
            </div>
        </div>

        @forelse ($layananUtama as $item)
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card service-card h-100">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="layanan-utama-img w-100" alt="{{ $item->title }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 195px;">
                            <i class="mdi mdi-image-off font-size-48 text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2">{{ $item->title }}</h5>
                        <p class="card-text text-muted flex-grow-1 small">
                            {{ Str::limit(strip_tags($item->description ?? '-'), 95) }}
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <span class="status-badge badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <small class="text-muted">Posisi: {{ $item->position }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center">
                    <i class="mdi mdi-image-multiple font-size-48 text-muted mb-3"></i>
                    <h5>Belum ada Layanan Utama</h5>
                    <p class="text-muted">Tambahkan layanan utama melalui tombol Kelola</p>
                </div>
            </div>
        @endempty
    </div>

    <!-- Layanan Perizinan Usaha Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Layanan Perizinan Usaha</h5>
                    <p class="text-muted mb-0">Daftar layanan perizinan yang tersedia</p>
                </div>
                <a href="{{ route('backend.layanan-perizinan.index') }}" class="btn btn-primary">
                    <i class="mdi mdi-cog-outline me-1"></i> Kelola Semua
                </a>
            </div>
        </div>

        @forelse ($layananPerizinan as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card service-card h-100 text-center">
                    <div class="card-body pt-4 pb-2">
                        <div class="icon-box mx-auto mb-3">
                            <i class="{{ $item->icon }}"></i>
                        </div>
                        <h5 class="card-title mb-3">{{ $item->title }}</h5>
                    </div>

                    <div class="card-footer bg-white border-0">
                        <span class="status-badge badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center">
                    <i class="mdi mdi-file-document-multiple font-size-48 text-muted mb-3"></i>
                    <h5>Belum ada Layanan Perizinan</h5>
                    <p class="text-muted">Tambahkan layanan perizinan melalui tombol Kelola</p>
                </div>
            </div>
        @endempty
    </div>
@endsection

@push('script')
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endpush
