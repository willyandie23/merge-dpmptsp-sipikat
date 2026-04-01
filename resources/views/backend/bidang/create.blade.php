@extends('backend.layouts.master')

@section('title', 'Tambah Bidang Baru')

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
            color: #495057;
        }

        .form-control,
        .form-control:focus {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .tips-card {
            border: 1px solid #556ee6 !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
        }

        .used-positions {
            max-height: 220px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Bidang Baru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.bidang.index') }}">Bidang</a></li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Bidang</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.bidang.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label">Nama Bidang <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Bidang Penanaman Modal dan Pelayanan Terpadu Satu Pintu"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                                    <input type="number" name="position"
                                        class="form-control @error('position') is-invalid @enderror"
                                        value="{{ old('position', 99) }}" min="1" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Semakin kecil angkanya, semakin atas posisinya</small>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Posisi yang Sudah Digunakan -->
                        <div class="mb-4">
                            <label class="form-label text-muted">Daftar Posisi Urutan yang Sudah Digunakan:</label>
                            <div class="border rounded p-3 bg-light used-positions">
                                @forelse($usedPositions as $pos)
                                    <div class="d-flex justify-content-between py-1 small border-bottom">
                                        <span><strong>{{ $pos->position }}</strong></span>
                                        <span class="text-muted">{{ str($pos->title)->limit(45) }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Belum ada data bidang.</p>
                                @endforelse
                            </div>
                            <small class="text-muted">Masukkan nomor posisi yang belum terdaftar di atas.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.bidang.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Bidang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Catatan -->
        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Semakin kecil angka urutan,
                            semakin atas tampilannya</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Setiap posisi harus unik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
