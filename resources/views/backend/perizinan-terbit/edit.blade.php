@extends('backend.layouts.master')

@section('title', 'Edit Data Perizinan Terbit')

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

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #556ee6;
            padding: 1rem;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Edit Data Perizinan Terbit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.perizinan-terbit.index') }}">Perizinan
                                    Terbit</a></li>
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
                    <h4 class="card-title mb-0 text-white">Edit Data Perizinan Terbit</h4>
                </div>

                <div class="card-body p-4">
                    <div class="info-box mb-4">
                        <strong>Tahun:</strong> {{ $perizinan_terbit->year }} |
                        <strong>Triwulan:</strong> {{ $perizinan_terbit->triwulan }}
                    </div>

                    <form action="{{ route('backend.perizinan-terbit.update', $perizinan_terbit) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hidden field untuk year dan triwulan (tidak boleh diubah) -->
                        <input type="hidden" name="year" value="{{ $perizinan_terbit->year }}">
                        <input type="hidden" name="triwulan" value="{{ $perizinan_terbit->triwulan }}">

                        <h5 class="section-title">Jumlah Perizinan Terbit</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">OSS RBA</label>
                                    <input type="number" name="oss_rba" class="form-control" min="0"
                                        value="{{ old('oss_rba', $perizinan_terbit->oss_rba) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">SiCantik Cloud</label>
                                    <input type="number" name="sicantik_cloud" class="form-control" min="0"
                                        value="{{ old('sicantik_cloud', $perizinan_terbit->sicantik_cloud) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">SIMBG</label>
                                    <input type="number" name="simbg" class="form-control" min="0"
                                        value="{{ old('simbg', $perizinan_terbit->simbg) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-warning px-5">
                                <i class="mdi mdi-content-save me-1"></i> Update Data
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