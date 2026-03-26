@extends('backend.layouts.master')

@section('title', 'Edit Data Survey')

@push('css')
    <style>
        /* CSS Dasar dari Template Admin Anda */
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

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }

        /* Style Tambahan untuk Form Create & Edit */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.65rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #556ee6;
            box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.25);
        }

        .indikator-label {
            font-weight: 500;
            color: #364574;
            margin-bottom: 0.4rem;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        /* Card untuk Indikator */
        .indikator-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #556ee6;
        }

        /* Tombol */
        .btn-success {
            background: linear-gradient(135deg, #2ecc71, #27ae60) !important;
            border: none;
            padding: 0.7rem 1.8rem;
            font-weight: 500;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f1c40f, #f39c12) !important;
            border: none;
            padding: 0.7rem 1.8rem;
            font-weight: 500;
        }

        .btn-secondary {
            padding: 0.7rem 1.8rem;
            font-weight: 500;
        }

        /* Small text helper */
        small.text-muted {
            font-size: 0.82rem;
        }

        /* Animasi halus */
        .card-modern {
            animation: fadeInCard 0.5s ease forwards;
        }

        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Data Survey</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active">Edit Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h4 class="card-title mb-0">Edit Data Survey</h4>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <strong>Informasi Data:</strong><br>
                        Tahun: <strong>{{ $survey->year }}</strong> |
                        Bulan: <strong>{{ \Carbon\Carbon::create()->month($survey->month)->translatedFormat('F') }}</strong>
                    </div>

                    <form action="{{ route('backend.survey.update', $survey) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tahun & Bulan hanya tampilan (tidak bisa diubah) -->
                        <input type="hidden" name="year" value="{{ $survey->year }}">
                        <input type="hidden" name="month" value="{{ $survey->month }}">

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Laki-laki <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_laki" class="form-control" min="0"
                                        value="{{ old('jumlah_laki', $survey->jumlah_laki) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Perempuan <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_perempuan" class="form-control" min="0"
                                        value="{{ old('jumlah_perempuan', $survey->jumlah_perempuan) }}" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-primary">Nilai Indikator (Skala 0.00 - 4.00)</h5>
                        <div class="row">
                            @php
                                $indikators = [
                                    'indikator1' => 'Persyaratan',
                                    'indikator2' => 'Sistem, Mekanisme dan Prosedur',
                                    'indikator3' => 'Waktu Penyelesaian',
                                    'indikator4' => 'Biaya / Tarif',
                                    'indikator5' => 'Produk / Spesifikasi Jenis Pelayanan',
                                    'indikator6' => 'Kompetensi Pelaksana',
                                    'indikator7' => 'Perilaku Pelaksana',
                                    'indikator8' => 'Penanganan Pengaduan, Saran dan Masukan',
                                    'indikator9' => 'Sarana dan Prasarana'
                                ];
                            @endphp

                            @foreach($indikators as $key => $label)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label class="form-label indikator-label">{{ $label }}</label>
                                    <input type="number" name="{{ $key }}" class="form-control" step="0.01" min="0" max="4"
                                        value="{{ old($key, $survey->$key ?? 0) }}" placeholder="0.00">
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="mdi mdi-content-save me-1"></i> Update Data
                            </button>
                            <a href="{{ route('backend.survey.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
