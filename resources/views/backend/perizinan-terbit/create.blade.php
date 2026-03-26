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

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
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
                    <h4 class="mb-0 font-size-18">Tambah Data Perizinan Terbit</h4>
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
                    <h4 class="card-title mb-0">Form Input Perizinan Terbit Baru</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.perizinan-terbit.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" name="year" class="form-control" min="2000" max="2100"
                                        placeholder="Contoh: 2025" value="{{ old('year') }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                                    <select name="month" class="form-select" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                                            <option value="{{ $num }}" {{ old('month') == $num ? 'selected' : '' }}>
                                                {{ $num }} - {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title mt-4">Jumlah Perizinan Terbit</h5>
                        <div class="row">
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

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('backend.perizinan-terbit.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
