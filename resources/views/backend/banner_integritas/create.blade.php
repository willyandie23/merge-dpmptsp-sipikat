@extends('backend.layouts.master')

@section('title', 'Tambah Banner Integritas')

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
        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }
        .img-preview {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .tips-card {
            border: 1px solid #556ee6 !important;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Banner Integritas</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.banner-integritas.index') }}">Banner Integritas</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Banner Integritas</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.banner-integritas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Banner <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Integritas Pelayanan Publik" required autofocus>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi Banner (opsional)</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan penjelasan singkat banner">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Upload Gambar Banner <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*" required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted mt-2">
                                Rekomendasi: <strong>1200 × 300 px</strong>, max 2MB (jpg, png, webp)
                            </small>
                        </div>

                        <div id="image-preview" class="mb-4 text-center" style="display: none;">
                            <label class="form-label">Preview Gambar</label>
                            <img id="preview-img" class="img-preview" src="#" alt="Preview">
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active"
                                       class="form-check-input" value="1"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan banner ini di halaman Integritas
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.banner-integritas.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Tips Banner Integritas</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Rekomendasi ukuran: <strong>1200 × 300 px</strong></li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gunakan gambar landscape yang bersih dan profesional</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Judul maksimal 100 karakter</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Banner aktif akan muncul di halaman Integritas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview Gambar
        document.getElementById('image').addEventListener('change', function (e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    img.src = event.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
@endpush
