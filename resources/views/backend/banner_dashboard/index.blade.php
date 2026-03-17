@extends('backend.layouts.master')

@section('title', 'Manajemen Banner Dashboard')

@push('css')
    <style>
        /* Turunkan konten lebih lega dari navbar fixed */
        .main-content {
            padding-top: 100px !important;  /* naikkan nilai ini kalau navbar masih nutup (coba 110px atau 120px) */
        }

        .page-content {
            margin-top: -4rem !important;
        }

        /* Header title full putih & background biru tua */
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

        /* Card header teks putih */
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

        /* Tombol tambah lebih besar, elegan, & aman dari navbar */
        .btn-add-banner {
            padding: 0.6rem 1.5rem !important;
            font-size: 1rem !important;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(85,110,230,0.35) !important;
            transition: all 0.3s ease;
        }
        .btn-add-banner:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85,110,230,0.45) !important;
        }

        /* Card keseluruhan lebih rapi */
        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
            margin-bottom: 2rem !important;
        }

        /* Tabel lebih clean */
        .table-hover tbody tr:hover {
            background-color: rgba(85,110,230,0.06) !important;
        }
        .img-thumbnail-modern {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .img-thumbnail-modern:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <!-- Page Title – diturunkan & teks putih -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Manajemen Banner Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Banner Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Utama – diturunkan lagi -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Banner Dashboard</h4>
                    <a href="{{ route('backend.banner-dashboard.create') }}" class="btn btn-light btn-add-banner">
                        <i class="mdi mdi-plus me-1"></i> Tambah Banner Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th class="aksi-column">Aksi</th>  <!-- ditengah -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($banners as $banner)
                                    <tr>
                                        <td>{{ $loop->iteration + ($banners->currentPage() - 1) * $banners->perPage() }}</td>
                                        <td class="fw-medium">{{ $banner->title }}</td>
                                        <td>{{ Str::limit($banner->description ?? '-', 60) }}</td>
                                        <td>
                                            @if ($banner->image)
                                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}"
                                                     class="img-thumbnail-modern" width="100" height="60" style="object-fit: cover;">
                                            @else
                                                <span class="badge bg-soft-warning px-3 py-2">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 bg-{{ $banner->is_active ? 'success' : 'danger' }}">
                                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="aksi-column">  <!-- ditengah -->
                                            <div class="btn-group">
                                                <a href="{{ route('backend.banner-dashboard.edit', $banner) }}" class="btn btn-sm btn-warning">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('backend.banner-dashboard.destroy', $banner) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                   <button type="button" class="btn btn-sm btn-danger delete-banner"
        data-id="{{ $banner->id }}"
        data-title="{{ $banner->title }}">
    <i class="mdi mdi-delete"></i>
</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-folder-open font-size-48 mb-3 d-block opacity-50"></i>
                                            Belum ada banner dashboard tersimpan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $banners->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Pesan sukses dari session (toast di pojok atas kanan)
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

        // Delete dengan SweetAlert confirm
        document.querySelectorAll('.delete-banner').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // cegah submit langsung kalau pakai <a>

                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title') || 'banner ini';

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Banner "${title}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form delete dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("backend.banner-dashboard.destroy", ":id") }}'.replace(':id', id);
                        form.innerHTML = '@csrf @method("DELETE")';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
