@extends('backend.layouts.master')

@section('title', 'Tambah Pertumbuhan Ekonomi')

@push('css')
    <style>
        /* CSS persis dari index Banner Dashboard */
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

        .btn-add-banner {
            padding: 0.6rem 1.5rem !important;
            font-size: 1rem !important;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
            transition: all 0.3s ease;
        }

        .btn-add-banner:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(85, 110, 230, 0.06) !important;
        }

        .img-thumbnail-modern {
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .img-thumbnail-modern:hover {
            transform: scale(1.1);
        }

        .aksi-column {
            text-align: center !important;
        }

        .btn-group {
            display: inline-flex;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tambah Data Pertumbuhan Ekonomi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.pertumbuhan-ekonomi.index') }}">Pertumbuhan Ekonomi</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h4 class="card-title mb-0">Form Tambah Pertumbuhan Ekonomi</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.pertumbuhan-ekonomi.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                                   value="{{ old('year') }}" min="2000" max="2100" placeholder="Contoh: 2025" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Pertumbuhan Ekonomi (%) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" min="0" max="100" placeholder="Contoh: 5.23" required>
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Masukkan nilai persentase (0 - 100)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.pertumbuhan-ekonomi.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5>Tips Penginputan</h5></div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">• Tahun tidak boleh duplikat</li>
                        <li class="mb-2">• Nilai pertumbuhan dalam persen (contoh: 5.23)</li>
                        <li>• Maksimal 100%</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
