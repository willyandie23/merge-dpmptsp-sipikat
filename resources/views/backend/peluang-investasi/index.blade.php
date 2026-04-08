@extends('backend.layouts.master')

@section('title', 'Manajemen Peluang Investasi')

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
                    <h4 class="mb-0 font-size-18">Manajemen Peluang Investasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Peluang Investasi</li>
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
                    <h4 class="card-title mb-0">Daftar Peluang Investasi</h4>
                    <a href="{{ route('backend.peluang-investasi.create') }}" class="btn btn-light btn-add">
                        <i class="mdi mdi-plus me-1"></i> Tambah Peluang Investasi
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Kecamatan</th>
                                    <th>Sektor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peluangs as $peluang)
                                    <tr>
                                        <td>{{ $loop->iteration + ($peluangs->currentPage() - 1) * $peluangs->perPage() }}</td>
                                        <td>
                                            @if($peluang->image)
                                                <img src="{{ Storage::url($peluang->image) }}" class="img-thumbnail-modern"
                                                    width="80" alt="{{ $peluang->title }}">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $peluang->title }}</td>
                                        <td>{{ $peluang->kecamatan->name ?? '-' }}</td>
                                        <td>{{ $peluang->sektor->name ?? '-' }}</td>
                                        <td class="aksi-column">
                                            <a href="{{ route('backend.peluang-investasi.edit', $peluang) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-peluang"
                                                data-id="{{ $peluang->id }}" data-title="{{ $peluang->title }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">Belum ada data peluang investasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $peluangs->links('pagination::bootstrap-5') }}
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

        document.querySelectorAll('.delete-peluang').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const title = this.dataset.title;

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Peluang "${title}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('backend.peluang-investasi.destroy', ':id') }}`.replace(':id', id);
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
