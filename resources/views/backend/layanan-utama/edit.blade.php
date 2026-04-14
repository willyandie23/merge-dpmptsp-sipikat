@extends('backend.layouts.master')

@section('title', 'Edit Layanan Utama')

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
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .preview-image {
            max-width: 100%;
            max-height: 250px;
            border-radius: 8px;
            margin-top: 12px;
            border: 2px solid #e9ecef;
        }

        .tips-card {
            border: 1px solid #556ee6 !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
        }

        /* CKEditor Style */
        .ck-editor__editable_inline {
            min-height: 320px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Edit Layanan Utama</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.layanan-utama.index') }}">Layanan Utama</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                    <h4 class="card-title mb-0 text-white">Form Edit Layanan Utama</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.layanan-utama.update', $layanan_utama) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">Judul Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $layanan_utama->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" id="editor-description"
                                class="form-control ckeditor">{{ old('description', $layanan_utama->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
    <label class="form-label">Link URL <span class="text-muted">(Opsional)</span></label>
    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
        value="{{ old('link', $layanan_utama->link) }}" placeholder="https://example.com">
    @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <small class="text-muted">Link ini akan ditampilkan di halaman depan (dashboard website).</small>
</div>

                        <div class="mb-4">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            @if ($layanan_utama->image)
                                <img src="{{ asset('storage/' . $layanan_utama->image) }}"
                                     class="preview-image mb-3" alt="Current Image">
                            @endif

                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>

                            <img id="preview" class="preview-image" style="display:none;" alt="Preview Gambar Baru">
                        </div>

                       <!-- Posisi Urutan -->
<div class="mb-4">
    <label class="form-label">Posisi Urutan <span class="text-danger">*</span></label>
    <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
        value="{{ old('position', $layanan_utama->position) }}" min="1" required>
    @error('position')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Informasi Posisi yang Sudah Dipakai -->
<div class="mb-4">
    <label class="form-label text-muted">Daftar Posisi Urutan yang Sudah Digunakan:</label>
    <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
        @forelse($usedPositions as $pos)
            <div class="d-flex justify-content-between py-1 small border-bottom">
                <span>
                    <strong>{{ $pos->position }}</strong>
                    @if($pos->id == $layanan_utama->id)
                        <span class="badge bg-primary ms-2">Saat Ini</span>
                    @endif
                </span>
                <span class="text-muted">{{ Str::limit($pos->title, 40) }}</span>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada data.</p>
        @endforelse
    </div>
</div>

<!-- Checkbox Aktif -->
<div class="mb-4">
    <div class="form-check form-switch form-switch-lg">
        <input type="hidden" name="is_active" value="0">
        <input name="is_active" type="checkbox" class="form-check-input" id="is_active" value="1"
               {{ old('is_active', $layanan_utama->is_active) ? 'checked' : '' }}>
        <label class="form-check-label fw-semibold" for="is_active">Aktifkan layanan ini di halaman depan</label>
    </div>
</div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.layanan-utama.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Update Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gambar lama tetap digunakan jika tidak diganti</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Deskripsi menggunakan CKEditor</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Posisi menentukan urutan tampilan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview Gambar
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

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
