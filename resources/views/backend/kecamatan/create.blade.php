@extends('backend.layouts.master')

@section('title', 'Tambah Kecamatan Baru')

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
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            padding: 1.4rem 1.5rem !important;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
        }

        .btn-add-row {
            border: 2px dashed #556ee6;
            color: #556ee6;
        }

        .btn-add-row:hover {
            background: #556ee6;
            color: white;
        }

        .populasi-row {
            transition: all 0.3s;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tambah Kecamatan Baru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.kecamatan.index') }}">Kecamatan</a></li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Kecamatan & Populasi</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.kecamatan.store') }}" method="POST" id="form-kecamatan">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Nama Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Dynamic Populasi -->
                        <label class="form-label d-block mb-3">Data Populasi per Tahun <span
                                class="text-danger">*</span></label>
                        <div id="populasi-container">
                            <!-- Baris pertama otomatis -->
                            <div class="row populasi-row mb-3">
                                <div class="col-md-5">
                                    <input type="number" name="populasi[0][year]" class="form-control" placeholder="Tahun"
                                        min="2000" max="2100" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="populasi[0][amount]" class="form-control"
                                        placeholder="Jumlah Populasi" min="0" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-populasi" class="btn btn-add-row w-100 py-2 mb-4 btn-primary">
                            <i class="mdi mdi-plus"></i> Tambah Tahun Populasi
                        </button>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.kecamatan.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Kecamatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5>Tips</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Tahun tidak boleh sama dalam satu kecamatan</li>
                        <li>Kamu bisa tambah lebih dari satu tahun populasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let rowIndex = 1;

        document.getElementById('add-populasi').addEventListener('click', function () {
            const container = document.getElementById('populasi-container');

            const newRow = `
            <div class="row populasi-row mb-3">
                <div class="col-md-5">
                    <input type="number" name="populasi[${rowIndex}][year]" class="form-control" placeholder="Tahun" min="2000" max="2100" required>
                </div>
                <div class="col-md-5">
                    <input type="number" name="populasi[${rowIndex}][amount]" class="form-control" placeholder="Jumlah Populasi" min="0" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Hapus</button>
                </div>
            </div>`;

            container.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
        });

        // Hapus baris
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                if (document.querySelectorAll('.populasi-row').length > 1) {
                    e.target.closest('.populasi-row').remove();
                } else {
                    Swal.fire('Minimal 1 data populasi', '', 'warning');
                }
            }
        });
    </script>
@endpush
