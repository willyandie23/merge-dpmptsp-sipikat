@extends('backend.layouts.master')

@section('title', 'Tambah Data Perizinan Terbit')

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
            padding: 0.65rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #556ee6;
            box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .section-title {
            color: #364574;
            font-weight: 600;
            margin-bottom: 1.2rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Data Perizinan Terbit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.perizinan-terbit.index') }}">Perizinan
                                    Terbit</a></li>
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
                    <h4 class="card-title mb-0 text-white">Form Input Data Perizinan Terbit Baru</h4>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('backend.perizinan-terbit.store') }}" method="POST">
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

                        <h5 class="section-title mt-4">Jumlah Perizinan Terbit</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">OSS RBA</label>
                                    <input type="number" name="oss_rba" class="form-control" min="0"
                                        value="{{ old('oss_rba') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">SiCantik Cloud</label>
                                    <input type="number" name="sicantik_cloud" class="form-control" min="0"
                                        value="{{ old('sicantik_cloud') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">SIMBG</label>
                                    <input type="number" name="simbg" class="form-control" min="0"
                                        value="{{ old('simbg') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-success px-5">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('backend.perizinan-terbit.index') }}" class="btn btn-secondary px-5 ms-3">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection