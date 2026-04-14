@extends('backend.layouts.master')

@section('title', 'Edit Data Survey')

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

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #556ee6;
            box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.25);
        }

        .indikator-label {
            font-weight: 500;
            color: #364574;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Edit Data Survey Triwulan</h4>
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
                    <h4 class="card-title mb-0 text-white">Edit Data Survey</h4>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <strong>Informasi Data:</strong><br>
                        Tahun: <strong>{{ $survey->year }}</strong> |
                        Triwulan: <strong>{{ $survey->triwulan }}</strong>
                    </div>

                    <form action="{{ route('backend.survey.update', $survey) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tahun & Triwulan hanya untuk tampilan (tidak diubah) -->
                        <input type="hidden" name="year" value="{{ $survey->year }}">
                        <input type="hidden" name="triwulan" value="{{ $survey->triwulan }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Laki-laki <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_laki" class="form-control" min="0"
                                        value="{{ old('jumlah_laki', $survey->jumlah_laki) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Perempuan <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_perempuan" class="form-control" min="0"
                                        value="{{ old('jumlah_perempuan', $survey->jumlah_perempuan) }}" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-primary">Nilai 9 Indikator (Skala 0.00 - 5.00)</h5>
                        <div class="row g-3">
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
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label indikator-label">{{ $label }}</label>
                                    <input type="number" name="{{ $key }}" class="form-control" step="0.01" min="0" max="5"
                                        value="{{ old($key, $survey->$key ?? 0) }}" placeholder="0.00">
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-warning px-5">
                                <i class="mdi mdi-content-save me-1"></i> Update Data
                            </button>
                            <a href="{{ route('backend.survey.index') }}" class="btn btn-secondary px-5 ms-3">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection