@extends('backend.layouts.master')

@section('title', 'Tentang DPMPTSP')

@push('css')
    <style>
        .main-content {
            padding-top: 100px !important;
        }

        .page-content {
            margin-top: -4rem !important;
        }

        .page-title-box {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            padding: 1.8rem 1.5rem !important;
            border-radius: 10px;
        }

        .page-title-box h4,
        .page-title-box .breadcrumb {
            color: white !important;
        }

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .card-header-modern h4 {
            color: white !important;
            margin: 0 !important;
        }

        .profile-header {
            background: linear-gradient(135deg, #556ee6, #364574);
            color: white;
            padding: 2.5rem 2rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .profile-image {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
        }

        .section-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(85, 110, 230, 0.15);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #364574;
            border-bottom: 2px solid #556ee6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .content-preview {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tentang DPMPTSP</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tentang DPMPTSP</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">

                <!-- Header Profil -->
                <div class="profile-header">
                    <h3 class="mb-1 text-white">Profil DPMPTSP</h3>
                    <p class="mb-0 opacity-90">Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu</p>
                </div>

                <div class="card-body p-4">

                    @if ($tentang)
                        <div class="row">

                            <!-- Gambar Utama -->
                            <div class="col-lg-4 mb-4">
                                <div class="text-center">
                                    @if ($tentang->image)
                                        <img src="{{ Storage::url($tentang->image) }}"
                                             alt="Gambar DPMPTSP"
                                             class="profile-image">
                                    @else
                                        <div class="profile-image d-flex align-items-center justify-content-center bg-light text-muted">
                                            <i class="mdi mdi-image-off" style="font-size: 4rem;"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Informasi Utama -->
                            <div class="col-lg-8">
                                <div class="row g-4">

                                    <!-- Deskripsi Umum -->
                                    <div class="col-12">
                                        <div class="section-card p-4">
                                            <h5 class="section-title"><i class="mdi mdi-information-outline me-2"></i>Deskripsi Umum</h5>
                                            <div class="content-preview">
                                                {!! $tentang->description ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Visi & Misi -->
                                    <div class="col-md-6">
                                        <div class="section-card p-4 h-100">
                                            <h5 class="section-title"><i class="mdi mdi-eye-outline me-2"></i>Visi</h5>
                                            <div class="content-preview">
                                                {!! $tentang->visi ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="section-card p-4 h-100">
                                            <h5 class="section-title"><i class="mdi mdi-target me-2"></i>Misi</h5>
                                            <div class="content-preview">
                                                {!! $tentang->misi ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dasar Hukum, Maklumat, Sasaran -->
                                    <div class="col-md-6">
                                        <div class="section-card p-4 h-100">
                                            <h5 class="section-title"><i class="mdi mdi-scale-balance me-2"></i>Dasar Hukum</h5>
                                            <div class="content-preview">
                                                {!! $tentang->dasar_hukum ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="section-card p-4 h-100">
                                            <h5 class="section-title"><i class="mdi mdi-handshake me-2"></i>Maklumat Layanan</h5>
                                            <div class="content-preview">
                                                {!! $tentang->maklumat_layanan ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Moto, Waktu, Alamat, Struktur -->
                                    <div class="col-12">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="section-card p-4">
                                                    <h5 class="section-title"><i class="mdi mdi-star-outline me-2"></i>Moto Layanan</h5>
                                                    <p class="mb-0 fw-medium">{{ $tentang->moto_layanan ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="section-card p-4">
                                                    <h5 class="section-title"><i class="mdi mdi-clock-outline me-2"></i>Waktu Layanan</h5>
                                                    <p class="mb-0 fw-medium">{{ $tentang->waktu_layanan ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="section-card p-4">
                                            <h5 class="section-title"><i class="mdi mdi-map-marker-outline me-2"></i>Alamat Kantor</h5>
                                            <div class="content-preview">
                                                {!! $tentang->alamat ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="section-card p-4">
                                            <h5 class="section-title"><i class="mdi mdi-account-group me-2"></i>Struktur Organisasi</h5>
                                            <div class="content-preview">
                                                {!! $tentang->struktur_organisasi ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="section-card p-4">
                                            <h5 class="section-title"><i class="mdi mdi-bullseye-arrow me-2"></i>Sasaran Layanan</h5>
                                            <div class="content-preview">
                                                {!! $tentang->sasaran_layanan ?? '<em class="text-muted">Belum diisi</em>' !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Tombol Edit -->
                        <div class="text-center mt-5">
                            <a href="{{ route('backend.tentang-dpmptsp.edit', $tentang) }}"
                               class="btn btn-primary btn-lg px-5">
                                <i class="mdi mdi-pencil me-2"></i> Edit Seluruh Data
                            </a>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="empty-state">
                            <i class="mdi mdi-office-building-outline" style="font-size: 6rem; opacity: 0.2;"></i>
                            <h4 class="mt-4 text-muted">Data Tentang DPMPTSP belum tersedia</h4>
                            <p class="text-muted mb-4">Silakan buat data profil organisasi pertama kali.</p>
                            <a href="{{ route('backend.tentang-dpmptsp.edit') }}"
                               class="btn btn-gradient btn-lg">
                                <i class="mdi mdi-plus me-2"></i> Buat Data Sekarang
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
