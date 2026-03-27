@extends('backend.layouts.master')

@section('title', 'Manajemen Mekanisme Pengaduan')

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
            margin-bottom: 2rem !important;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .table-modern th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .status-badge {
            font-size: 0.85rem;
        }

        .btn-add {
            padding: 0.6rem 1.5rem !important;
            font-size: 1rem !important;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .action-buttons {
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Manajemen Mekanisme Pengaduan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mekanisme Pengaduan</li>
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
                    <h4 class="card-title mb-0">Daftar Mekanisme Pengaduan</h4>
                    <a href="{{ route('backend.mekanisme-pengaduan.create') }}" class="btn btn-light btn-add">
                        <i class="mdi mdi-plus me-1"></i> Tambah Mekanisme Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($mekanisme->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-modern align-middle">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Mekanisme</th>
                                        <th>Deskripsi</th>
                                        <th>URL</th>
                                        <th>Posisi</th>
                                        <th>Status</th>
                                        <th width="180" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mekanisme as $item)
                                        <tr>
                                            <td>{{ $mekanisme->firstItem() + $loop->index }}</td>
                                            <td><strong>{{ $item->name }}</strong></td>
                                            <td>
                                                {!! Str::limit(strip_tags($item->description), 80) !!}
                                            </td>
                                            <td>
                                                @if ($item->url)
                                                    <a href="{{ $item->url }}" target="_blank" class="text-primary">
                                                        {{ Str::limit($item->url, 40) }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $item->position }}</span>
                                            </td>
                                            <td>
                                                <span class="badge status-badge bg-{{ $item->is_active ? 'success' : 'danger' }}">
                                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="action-buttons text-center">
                                                <a href="{{ route('backend.mekanisme-pengaduan.edit', $item) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $mekanisme->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-document-outline font-size-48 mb-3 d-block opacity-50"></i>
                            <h5>Belum ada data Mekanisme Pengaduan</h5>
                            <p class="text-muted">Silakan tambahkan mekanisme pengaduan baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name') || 'item ini';

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Mekanisme "${name}" akan dihapus permanen!`,
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
                        form.action = `{{ route('backend.mekanisme-pengaduan.destroy', ':id') }}`.replace(':id', id);
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // Toast success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
