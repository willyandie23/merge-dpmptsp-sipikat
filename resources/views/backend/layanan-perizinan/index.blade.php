@extends('backend.layouts.master')

@section('title', 'Layanan Perizinan Usaha')

@push('css')
    <style>
        .main-content { padding-top: 100px !important; }
        .page-content { margin-top: -4rem !important; }

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

        .icon-preview {
            font-size: 42px;
            color: #556ee6;
        }

        .btn-add {
            padding: 0.6rem 1.5rem !important;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .max-limit-alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Layanan Perizinan Usaha</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Layanan Perizinan</li>
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
                    <h4 class="card-title mb-0 text-white">Daftar Layanan Perizinan Usaha</h4>
                    
                    @if($layanan->total() < 3)
                        <a href="{{ route('backend.layanan-perizinan.create') }}" class="btn btn-light btn-add">
                            <i class="mdi mdi-plus me-1"></i> Tambah Layanan Baru
                        </a>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="mdi mdi-information-outline me-1"></i> Maksimal 3 Layanan Perizinan
                        </span>
                    @endif
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert max-limit-alert alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($layanan->count() > 0)
                        <div class="row">
                            @foreach ($layanan as $item)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 text-center">
                                        <div class="card-body pt-4">
                                            <div class="mb-4">
                                                <i class="{{ $item->icon }} icon-preview"></i>
                                            </div>
                                            <h5 class="card-title">{{ $item->title }}</h5>
                                            @if($item->link)
                                                <a href="{{ $item->link }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="mdi mdi-link"></i> Link
                                                </a>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                            <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                            <div>
                                                <a href="{{ route('backend.layanan-perizinan.edit', $item) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $item->id }}" data-title="{{ $item->title }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $layanan->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-document-multiple font-size-48 mb-3 d-block opacity-50"></i>
                            <h5>Belum ada data Layanan Perizinan Usaha</h5>
                            <p class="text-muted">Silakan tambahkan maksimal 3 layanan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title') || 'layanan ini';

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Layanan "${title}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('backend.layanan-perizinan.destroy', ':id') }}`.replace(':id', id);
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

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