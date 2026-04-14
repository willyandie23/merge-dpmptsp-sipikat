@extends('backend.layouts.master')

@section('title', 'Peraturan Bupati')

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

        .teks-perbup {
            line-height: 1.8;
            font-size: 1.02rem;
            color: #495057;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Peraturan Bupati</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Perbup</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 text-white">Teks Peraturan Bupati</h4>
                    <a href="{{ route('backend.perbup.create') }}" class="btn btn-light">
                        <i class="mdi mdi-pencil me-1"></i> Edit Teks Perbup
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($perbup)
                        <div class="alert alert-info">
                            <i class="mdi mdi-information-outline me-2"></i>
                            Status:
                            <span class="badge {{ $perbup->is_active ? 'bg-success' : 'bg-secondary' }} status-badge">
                                {{ $perbup->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <div class="teks-perbup border rounded p-4 bg-light">
                            {!! nl2br(e($perbup->teks_perbup)) !!}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-document-outline font-size-48 text-muted mb-3"></i>
                            <h5>Belum ada teks Peraturan Bupati</h5>
                            <p class="text-muted">Silakan tambahkan teks Perbup terlebih dahulu.</p>
                            <a href="{{ route('backend.perbup.create') }}" class="btn btn-primary mt-3">
                                <i class="mdi mdi-plus"></i> Tambah Teks Perbup
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // SweetAlert Success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush