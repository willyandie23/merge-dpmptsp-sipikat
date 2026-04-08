@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Tentang
@endsection

@push('css')
    <style>
        .field-title-main {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
            line-height: 1.2;
        }

        .field-title-sub {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 30px;
        }

        /* Styling tambahan agar tetap konsisten dengan template ArchCode */
        .about-section h4 {
            position: relative;
            padding-bottom: 15px;
            font-size: 1.35rem;
        }

        .about-section h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
            /* warna emas/kuning khas ArchCode */
        }

        .section-image {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-4">

        <!-- Page Header Baru (sesuai style project kamu) -->
        <h2 class="field-title-main">Tentang DPMTSP</h2>
        <h3 class="field-title-sub">DPMPTSP Kabupaten Katingan</h3>

        <!-- Isi konten tetap sama seperti sebelumnya (dinamis dari model) -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <div class="about-description">
                    {!! $tentang->description !!}
                </div>
            </div>
            <div class="col-lg-4 text-center">
                @if ($tentang->image)
                    <img src="{{ asset('storage/' . $tentang->image) }}" class="img-fluid section-image"
                        alt="DPMTSP Kabupaten Katingan">
                @endif
            </div>
        </div>

        <div class="row g-5">

            <!-- Kolom Kiri -->
            <div class="col-lg-6">

                <div class="about-section mb-5">
                    <h4>Dasar Hukum</h4>
                    {!! $tentang->dasar_hukum !!}
                </div>

                <div class="about-section mb-5">
                    <h4>Visi</h4>
                    {!! $tentang->visi !!}
                </div>

                <div class="about-section mb-5">
                    <h4>Maklumat Layanan</h4>
                    {!! $tentang->maklumat_layanan !!}
                </div>

                <div class="about-section">
                    <h4>Alamat</h4>
                    {!! $tentang->alamat !!}
                </div>

            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-6">

                <div class="about-section mb-5">
                    <h4>Moto Layanan</h4>
                    {!! $tentang->moto_layanan !!}
                </div>

                <div class="about-section mb-5">
                    <h4>Misi</h4>
                    {!! $tentang->misi !!}
                </div>

                <div class="about-section mb-5">
                    <h4>Waktu Layanan</h4>
                    {!! $tentang->waktu_layanan !!}
                </div>

                <div class="about-section">
                    <h4>Struktur Organisasi</h4>
                    {!! $tentang->struktur_organisasi !!}
                </div>

            </div>
        </div>

        <!-- Sasaran Layanan dan Komitmen Kami (Full Width) -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="about-section border-top pt-5">
                    <h4 class="text-center mb-4">Sasaran Layanan dan Komitmen Kami</h4>
                    {!! $tentang->sasaran_layanan !!}
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
