@extends('backend.layouts.master')

@section('title', 'Manajemen FAQ')

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

        .page-title-box h4,
        .page-title-box .breadcrumb {
            color: white !important;
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

        .faq-item {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .faq-question {
            background: linear-gradient(135deg, #f8f9fa, #f1f3f9);
            padding: 1.4rem 1.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: linear-gradient(135deg, #eef2ff, #e3e9ff);
        }

        .faq-answer {
            padding: 1.5rem 1.8rem;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .toggle-icon {
            font-size: 1.6rem;
            transition: transform 0.3s ease;
        }

        .faq-item.active .toggle-icon {
            transform: rotate(180deg);
        }

        .status-badge {
            font-size: 0.85rem;
        }

        .btn-add-banner {
            padding: 0.6rem 1.5rem !important;
            font-size: 1rem !important;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .btn-add-banner:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .action-buttons {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Manajemen FAQ</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">FAQ</li>
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
                    <h4 class="card-title mb-0">Daftar FAQ</h4>
                    <a href="{{ route('backend.faq.create') }}" class="btn btn-light btn-add-banner">
                        <i class="mdi mdi-plus me-1"></i> Tambah FAQ Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    @if ($faqs->count() > 0)
                        @foreach ($faqs as $faq)
                            <div class="faq-item">
                                <!-- Pertanyaan (Selalu Terlihat) -->
                                <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-answer-{{ $faq->id }}">
                                    <span>{{ $faq->title }}</span>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge status-badge bg-{{ $faq->is_active ? 'success' : 'danger' }}">
                                            {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                        <i class="mdi mdi-chevron-down toggle-icon text-muted"></i>
                                    </div>
                                </div>

                                <!-- Jawaban + Tombol Aksi (Muncul Saat Dibuka) -->
                                <div id="faq-answer-{{ $faq->id }}" class="faq-answer collapse">
                                    <div class="mb-4">
                                        {!! $faq->answer !!}
                                    </div>

                                    <div class="action-buttons d-flex justify-content-end gap-2">
                                        <a href="{{ route('backend.faq.edit', $faq) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-faq" data-id="{{ $faq->id }}"
                                            data-title="{{ $faq->title }}">
                                            <i class="mdi mdi-delete me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $faqs->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-frequently-asked-questions font-size-48 mb-3 d-block opacity-50"></i>
                            <h5>Belum ada FAQ tersimpan</h5>
                            <p class="text-muted">Silakan tambahkan pertanyaan dan jawaban FAQ.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Toggle icon rotate
        document.querySelectorAll('.faq-question').forEach(header => {
            header.addEventListener('click', function () {
                this.classList.toggle('active');
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-faq').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopImmediatePropagation(); // cegah accordion terbuka

                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title') || 'FAQ ini';

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `FAQ "${title}" akan dihapus permanen!`,
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
                        form.action = '{{ route("backend.faq.destroy", ":id") }}'.replace(':id', id);
                        form.innerHTML = '@csrf @method("DELETE")';
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
