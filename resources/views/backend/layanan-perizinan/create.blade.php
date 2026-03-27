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

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control, .form-control:focus {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
            padding: 0.6rem 1.5rem !important;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .icon-preview {
            font-size: 48px;
            color: #556ee6;
            margin: 20px 0;
            min-height: 70px;
        }

        .tips-card {
            border: 1px solid #556ee6 !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tambah Layanan Perizinan Usaha</h4>
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
                    <h4 class="card-title mb-0">Form Tambah Layanan Perizinan</h4>
                </div>
                <div class="card-body p-4">
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

                            <!-- Live Preview -->
                            <div class="text-center mt-4">
                                <p class="text-muted small mb-2">Preview Icon:</p>
                                <div id="icon-preview" class="icon-preview">
                                    <i class="{{ old('icon') }}"></i>
                                </div>
                            </div>

                            <small class="text-muted d-block mt-2">
                                Buka situs
                                <a href="https://pictogrammers.com/library/mdi/" target="_blank" class="text-primary">
                                    Material Design Icons
                                </a><br>
                                Cari icon → Copy nama lengkap (contoh: <code>mdi mdi-office-building</code>) lalu paste di atas.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Posisi Urutan</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                value="{{ old('position', 99) }}" min="1">
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <input name="is_active" type="checkbox" class="form-check-input" id="is_active" value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktifkan di halaman depan</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.layanan-perizinan.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Layanan
                            </button>
                        </div>
                    </form>
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
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Buka situs Material Design Icons</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Cari icon yang diinginkan</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Copy nama icon lengkap lalu paste di kolom Icon</li>
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

        // Initial preview jika ada old value
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
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endpush
