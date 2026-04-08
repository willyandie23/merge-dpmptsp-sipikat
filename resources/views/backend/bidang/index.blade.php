@extends('backend.layouts.master')

@section('title', 'Manajemen Bidang')

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

        .aksi-column {
            text-align: center !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Manajemen Bidang</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bidang</li>
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
                    <h4 class="card-title mb-0 text-white">Daftar Bidang</h4>
                    <a href="{{ route('backend.bidang.create') }}" class="btn btn-light">
                        <i class="mdi mdi-plus me-1"></i> Tambah Bidang Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Bidang</th>
                                    <th>Urutan</th>
                                    <th class="text-center">Jumlah Pejabat</th>
                                    <th class="aksi-column">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bidangs as $bidang)
                                    <tr>
                                        <td>{{ $loop->iteration + ($bidangs->currentPage() - 1) * $bidangs->perPage() }}</td>
                                        <td><strong>{{ $bidang->name }}</strong></td>
                                        <td class="text-center">{{ $bidang->position }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $bidang->strukturOrganisasi()->count() }}</span>
                                        </td>
                                        <td class="aksi-column">
                                            <a href="{{ route('backend.bidang.edit', $bidang) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-bidang"
                                                data-id="{{ $bidang->id }}" data-name="{{ $bidang->name }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">Belum ada data bidang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $bidangs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        @endif

        document.querySelectorAll('.delete-bidang').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;

                Swal.fire({
                    title: 'Yakin hapus bidang ini?',
                    html: `Bidang <strong>"${name}"</strong> dan <strong>SEMUA</strong> struktur organisasi di dalamnya akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form delete
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('backend.bidang.destroy', ':id') }}`.replace(':id', id);
                        form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
