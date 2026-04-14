@extends('backend.layouts.master')

@section('title', 'Tambah Sektor Baru')

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

        .form-label {
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Sektor Baru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.sektor.index') }}">Sektor</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Sektor & Data Produk Domestik</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.sektor.store') }}" method="POST" id="form-sektor">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Nama Sektor <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Contoh: Pertanian, Industri, Pariwisata" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <label class="form-label d-block mb-3">Data Produk Domestik per Tahun <span
                                class="text-danger">*</span></label>
                        <div id="produk-container">
                            <div class="row produk-row mb-3 align-items-center">
                                <div class="col-md-5">
                                    <input type="number" name="produk_domestik[0][year]" class="form-control"
                                        placeholder="Tahun" min="2000" max="2100" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="produk_domestik[0][amount]" class="form-control amount-input"
                                        placeholder="Nilai (contoh: 1500000000)" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-produk" class="btn btn-primary w-100 py-2 mb-4">
                            <i class="mdi mdi-plus"></i> Tambah Tahun Produk Domestik
                        </button>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.sektor.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Sektor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Tips Penginputan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Nama sektor harus unik</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Tahun tidak boleh duplikat
                            dalam satu sektor</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Nilai akan otomatis diformat dengan titik
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let rowIndex = 1;

        function formatRibuan(value) {
            return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function attachFormatting() {
            document.querySelectorAll('.amount-input').forEach(input => {
                input.addEventListener('input', function (e) {
                    e.target.value = formatRibuan(e.target.value);
                });
            });
        }

        attachFormatting();

        document.getElementById('add-produk').addEventListener('click', function () {
            const container = document.getElementById('produk-container');
            const newRow = `
                    <div class="row produk-row mb-3 align-items-center">
                        <div class="col-md-5">
                            <input type="number" name="produk_domestik[${rowIndex}][year]" class="form-control"
                                   placeholder="Tahun" min="2000" max="2100" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="produk_domestik[${rowIndex}][amount]" class="form-control amount-input"
                                   placeholder="Nilai (contoh: 1500000000)" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm w-100 remove-row">Hapus</button>
                        </div>
                    </div>`;
            container.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
            attachFormatting();
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                if (document.querySelectorAll('.produk-row').length > 1) {
                    e.target.closest('.produk-row').remove();
                } else {
                    Swal.fire('Minimal harus ada 1 data produk domestik!', '', 'warning');
                }
            }
        });
    </script>
@endpush