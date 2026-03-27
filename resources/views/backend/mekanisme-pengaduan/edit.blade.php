@extends('backend.layouts.master')

@section('title', 'Edit Mekanisme Pengaduan')

@push('css')
    <style>
        /* Style sama seperti create */
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

        .tips-card {
            border: 1px solid #556ee6 !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
        }

        .preview-image {
            max-width: 100%;
            max-height: 250px;
            border-radius: 8px;
            margin-top: 12px;
            border: 2px solid #e9ecef;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Mekanisme Pengaduan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.mekanisme-pengaduan.index') }}">Mekanisme Pengaduan</a></li>
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
                    <h4 class="card-title mb-0">Form Edit Mekanisme Pengaduan</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.mekanisme-pengaduan.update', $mekanisme_pengaduan) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">Nama Mekanisme <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $mekanisme_pengaduan->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $mekanisme_pengaduan->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            @if ($mekanisme_pengaduan->image)
                                <img src="{{ asset('storage/' . $mekanisme_pengaduan->image) }}"
                                     class="preview-image mb-3" alt="Current Image">
                            @endif

                            <label class="form-label">Ganti Gambar Baru (Opsional)</label>
                            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>

                            <!-- Preview Gambar Baru -->
                            <img id="preview" class="preview-image" alt="Preview Gambar Baru">
                        </div>

                        <!-- Field lainnya tetap sama -->
                        <div class="mb-4">
                            <label class="form-label">URL Tautan (Opsional)</label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                                value="{{ old('url', $mekanisme_pengaduan->url) }}">
                            @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Posisi Urutan</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                value="{{ old('position', $mekanisme_pengaduan->position) }}" min="1">
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <input name="is_active" type="checkbox" class="form-check-input" id="is_active" value="1"
                                       {{ old('is_active', $mekanisme_pengaduan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktifkan di halaman depan</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.mekanisme-pengaduan.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Update Mekanisme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan Penting</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gambar lama akan tetap digunakan jika tidak diganti</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Preview hanya muncul untuk gambar baru yang dipilih</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview Gambar Saat Edit
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
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
