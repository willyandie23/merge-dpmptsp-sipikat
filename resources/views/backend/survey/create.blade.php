@extends('backend.layouts.master')

@section('title', 'Tambah Data Survey')

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
                    <h4 class="mb-0 font-size-18 text-white">Tambah Data Survey Triwulan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active">Tambah Data</li>
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
                    <h4 class="card-title mb-0 text-white">Form Input Data Survey Baru</h4>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('backend.survey.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="year" class="form-control" min="2000" max="2100"
                                        value="{{ old('year') }}" placeholder="Contoh: 2026" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Triwulan <span class="text-danger">*</span></label>
                                    <select name="triwulan" class="form-select" required>
                                        <option value="">-- Pilih Triwulan --</option>
                                        <option value="1" {{ old('triwulan') == 1 ? 'selected' : '' }}>Triwulan 1 (Januari -
                                            Maret)</option>
                                        <option value="2" {{ old('triwulan') == 2 ? 'selected' : '' }}>Triwulan 2 (April -
                                            Juni)</option>
                                        <option value="3" {{ old('triwulan') == 3 ? 'selected' : '' }}>Triwulan 3 (Juli -
                                            September)</option>
                                        <option value="4" {{ old('triwulan') == 4 ? 'selected' : '' }}>Triwulan 4 (Oktober -
                                            Desember)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Laki-laki <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_laki" class="form-control" min="0"
                                        value="{{ old('jumlah_laki') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Perempuan <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_perempuan" class="form-control" min="0"
                                        value="{{ old('jumlah_perempuan') }}" required>
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
                                        value="{{ old($key) }}" placeholder="0.00">
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-success px-5">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Data Survey
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