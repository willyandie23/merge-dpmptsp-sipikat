@extends('backend.layouts.master')

@section('title', 'Tambah Layanan Perizinan Usaha')

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

        .form-label { font-weight: 600; color: #495057; }

        .form-control, .form-control:focus {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
            padding: 0.6rem 1.5rem !important;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
        }

        .icon-preview {
            font-size: 48px;
            color: #556ee6;
            margin: 20px 0;
            min-height: 70px;
        }

        .used-positions {
            max-height: 220px;
            overflow-y: auto;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Layanan Perizinan Usaha</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.layanan-perizinan.index') }}">Layanan Perizinan</a></li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Layanan Perizinan</h4>
                </div>
                <div class="card-body p-4">

                    @if($currentCount >= 3)
                        <div class="alert alert-danger">
                            <strong>Maksimal 3 Layanan Perizinan Usaha!</strong><br>
                            Anda sudah mencapai batas maksimal. Silakan hapus salah satu terlebih dahulu jika ingin menambahkan yang baru.
                        </div>
                    @else
                        <form action="{{ route('backend.layanan-perizinan.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Icon (Material Design Icon) <span class="text-danger">*</span></label>
                                <input type="text" id="icon-input" name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon') }}"
                                       placeholder="Contoh: mdi mdi-file-document-outline" required>
                                @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                <div class="text-center mt-4">
                                    <p class="text-muted small mb-2">Preview Icon:</p>
                                    <div id="icon-preview" class="icon-preview">
                                        <i class="{{ old('icon') }}"></i>
                                    </div>
                                </div>

                                <small class="text-muted d-block mt-2">
                                    Buka <a href="https://pictogrammers.com/library/mdi/" target="_blank">Material Design Icons</a><br>
                                    Copy nama lengkap icon (contoh: <code>mdi mdi-office-building</code>)
                                </small>
                            </div>

                            <!-- Field Link Baru -->
                            <div class="mb-4">
                                <label class="form-label">Link URL <span class="text-muted">(Opsional)</span></label>
                                <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                                    value="{{ old('link') }}" placeholder="https://example.com/layanan-izin">
                                @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Link ini akan ditampilkan di halaman depan dashboard website.</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Posisi Urutan <span class="text-danger">*</span></label>
                                <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                    value="{{ old('position') }}" min="1" required>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted">Daftar Posisi Urutan yang Sudah Digunakan:</label>
                                <div class="used-positions">
                                    @forelse($usedPositions as $pos)
                                        <div class="d-flex justify-content-between py-1 border-bottom">
                                            <span><strong>{{ $pos->position }}</strong></span>
                                            <span class="text-muted text-truncate">{{ $pos->title }}</span>
                                        </div>
                                    @empty
                                        <p class="text-muted mb-0">Belum ada data layanan perizinan.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch form-switch-lg">
                                    <input type="hidden" name="is_active" value="0">
                                    <input name="is_active" type="checkbox" class="form-check-input" id="is_active" value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktifkan layanan ini di halaman depan</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('backend.layanan-perizinan.index') }}" class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-gradient text-white">
                                    <i class="mdi mdi-content-save me-1"></i> Simpan Layanan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Petunjuk</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Maksimal hanya 3 layanan perizinan</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Link opsional untuk mengarah ke halaman detail</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Icon menggunakan Material Design Icons</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Live Icon Preview
        const iconInput = document.getElementById('icon-input');
        const iconPreview = document.getElementById('icon-preview');

        iconInput.addEventListener('input', function() {
            const iconClass = this.value.trim();
            iconPreview.innerHTML = iconClass 
                ? `<i class="${iconClass}"></i>` 
                : `<i class="mdi mdi-help-circle-outline text-muted"></i>`;
        });

        if (iconInput.value.trim()) {
            iconPreview.innerHTML = `<i class="${iconInput.value.trim()}"></i>`;
        }

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