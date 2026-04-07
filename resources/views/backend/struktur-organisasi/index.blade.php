@extends('backend.layouts.master')

@section('title', 'Struktur Organisasi')

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
            margin-bottom: 2rem !important;
        }
        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .bidang-section {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 1.8rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .bidang-header {
            background: linear-gradient(135deg, #f8f9fa, #f1f3f9);
            padding: 1.5rem 1.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .bidang-header:hover {
            background: linear-gradient(135deg, #eef2ff, #e3e9ff);
        }

        .pejabat-photo {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #556ee6;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.2);
        }

        .staff-list {
            padding: 1.5rem 1.8rem;
            background-color: #fff;
        }

        .staff-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 0.8rem;
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }

        .staff-item:hover {
            background-color: #eef2ff;
            transform: translateX(5px);
        }

        .staff-photo {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            margin-right: 1rem;
        }

        .staff-info {
            flex-grow: 1;
        }

        .staff-info strong {
            font-size: 1.05rem;
            color: #364574;
        }

        .no-photo-small {
            width: 55px;
            height: 55px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            border: 2px solid #dee2e6;
        }

        .toggle-icon {
            font-size: 1.6rem;
            transition: transform 0.3s ease;
        }

        .bidang-header.active .toggle-icon {
            transform: rotate(180deg);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Struktur Organisasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Struktur Organisasi</li>
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
                    <h4 class="card-title mb-0 text-white">Struktur Organisasi DPMPTSP</h4>
                    <a href="{{ route('backend.struktur-organisasi.create') }}" class="btn btn-light">
                        <i class="mdi mdi-plus me-1"></i> Tambah Data
                    </a>
                </div>

                <div class="card-body p-0">
                    @forelse ($bidangs as $bidang)
                        <div class="bidang-section">
                            <!-- Header Bidang + Pejabat Utama -->
                            <div class="bidang-header d-flex align-items-center"
                                 data-bs-toggle="collapse"
                                 data-bs-target="#bidang-{{ $bidang->id }}">

                                <div class="d-flex align-items-center flex-grow-1">
                                    @if($bidang->pejabatUtama && $bidang->pejabatUtama->image)
                                        <img src="{{ asset('storage/' . $bidang->pejabatUtama->image) }}"
                                             class="pejabat-photo me-4" alt="Foto Pejabat">
                                    @else
                                        <div class="no-photo me-4">
                                            <i class="mdi mdi-account fs-1 text-muted"></i>
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">
                                        <h5 class="mb-2">{{ $bidang->name }}</h5>
                                        @if($bidang->pejabatUtama)
                                            <p class="mb-1 fw-semibold">{{ $bidang->pejabatUtama->name }}</p>
                                            @if($bidang->pejabatUtama->nip)
                                                <small class="text-muted">NIP. {{ $bidang->pejabatUtama->nip }}</small>
                                            @endif
                                        @else
                                            <p class="mb-0 text-muted fst-italic">Belum ada pejabat utama</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-end d-flex align-items-center gap-3">
                                    <!-- Tombol Edit Pejabat Utama - Perbaikan Kuat -->
                                    @if($bidang->pejabatUtama)
                                        <a href="{{ route('backend.struktur-organisasi.edit', $bidang->pejabatUtama) }}"
                                           class="btn btn-sm btn-warning edit-pejabat-btn"
                                           onclick="event.stopImmediatePropagation(); event.preventDefault(); window.location.href=this.href;">
                                            <i class="mdi mdi-pencil"></i> Edit Pejabat
                                        </a>
                                    @endif

                                    <span class="badge bg-primary">
                                        {{ $bidang->total_staff ?? 0 }} Orang
                                    </span>
                                    <i class="mdi mdi-chevron-down toggle-icon text-muted"></i>
                                </div>
                            </div>

                            <!-- Daftar Staff Biasa -->
                            <div id="bidang-{{ $bidang->id }}" class="staff-list collapse">
                                @if($bidang->staff->count() > 0)
                                    @foreach($bidang->staff as $staff)
                                        <div class="staff-item">
                                            <div>
                                                @if($staff->image)
                                                    <img src="{{ asset('storage/' . $staff->image) }}" class="staff-photo" alt="{{ $staff->name }}">
                                                @else
                                                    <div class="no-photo-small">
                                                        <i class="mdi mdi-account fs-3 text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="staff-info">
                                                <strong>{{ $staff->name }}</strong><br>
                                                @if($staff->nip)
                                                    <small class="text-muted">NIP. {{ $staff->nip }}</small>
                                                @endif
                                                @if($staff->golongan)
                                                    <span class="badge bg-secondary ms-2">{{ $staff->golongan }}</span>
                                                @endif
                                            </div>

                                            <div class="text-end">
                                                <a href="{{ route('backend.struktur-organisasi.edit', $staff) }}"
                                                   class="btn btn-sm btn-warning me-1">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-staff"
                                                        data-id="{{ $staff->id }}"
                                                        data-name="{{ $staff->name }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4 text-muted">
                                        Belum ada staf di bidang ini.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <p class="text-muted">Belum ada data struktur organisasi.</p>
                        </div>
                    @endforelse
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
</script>
<script>
    // Klik pada header → toggle collapse (kecuali tombol edit)
    document.querySelectorAll('.bidang-header').forEach(header => {
        header.addEventListener('click', function (e) {
            // Jika yang diklik adalah tombol edit atau child-nya, jangan toggle
            if (e.target.closest('.edit-pejabat-btn')) {
                e.stopImmediatePropagation();
                return;
            }
            this.classList.toggle('active');
        });
    });

    // Delete confirmation untuk staff
    document.querySelectorAll('.delete-staff').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopImmediatePropagation();

            const id = this.dataset.id;
            const name = this.dataset.name;

            Swal.fire({
                title: 'Yakin hapus?',
                text: `Data "${name}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('backend.struktur-organisasi.destroy', ':id') }}`.replace(':id', id);
                    form.innerHTML = `@csrf @method("DELETE")`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
