@extends('backend.layouts.master')

@section('title', 'Manajemen Sektor')

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

        .btn-add {
            padding: 0.6rem 1.5rem !important;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Manajemen Sektor Usaha</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sektor</li>
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
                    <h4 class="card-title mb-0 text-white">Daftar Sektor</h4>
                    <a href="{{ route('backend.sektor.create') }}" class="btn btn-light btn-add">
                        <i class="mdi mdi-plus me-1"></i> Tambah Sektor Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Sektor</th>
                                    <th>Produk Domestik Terbaru</th>
                                    <th>Tahun</th>
                                    <th>Total PDRB (Rp)</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sektors as $sektor)
                                    <tr>
                                        <td>{{ $loop->iteration + ($sektors->currentPage() - 1) * $sektors->perPage() }}</td>
                                        <td><strong>{{ $sektor->name }}</strong></td>
                                        <td>
                                            @php 
                                                $latest = $sektor->produkDomestik->sortByDesc('year')->first(); 
                                            @endphp
                                            @if($latest)
                                                Rp {{ number_format($latest->amount, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $latest->year ?? '-' }}</td>
                                        <td>
                                            Rp {{ number_format($sektor->produkDomestik->sum('amount'), 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('backend.sektor.edit', $sektor) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-sektor"
                                                data-id="{{ $sektor->id }}" data-name="{{ $sektor->name }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="mdi mdi-folder-outline font-size-48 text-muted mb-3 d-block"></i>
                                            Belum ada data sektor
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $sektors->links('pagination::bootstrap-5') }}
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
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        document.querySelectorAll('.delete-sektor').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Sektor "${name}" akan dihapus permanen beserta data produk domestiknya!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('backend.sektor.destroy', ':id') }}`.replace(':id', id);
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush