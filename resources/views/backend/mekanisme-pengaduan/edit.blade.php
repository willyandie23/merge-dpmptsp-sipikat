@extends('backend.layouts.master')

@section('title', 'Edit Mekanisme Pengaduan')

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

        .preview-image {
            max-width: 100%;
            max-height: 280px;
            border-radius: 12px;
            margin-top: 12px;
            border: 3px solid #28a745;
        }

        .new-preview {
            max-width: 100%;
            max-height: 280px;
            border-radius: 12px;
            margin-top: 12px;
            border: 3px solid #e9ecef;
            display: none;
        }

        .video-preview {
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Edit Mekanisme Pengaduan</h4>
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
                    <h4 class="card-title mb-0 text-white">Form Edit Mekanisme Pengaduan</h4>
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
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">
                                {{ old('description', $mekanisme_pengaduan->description) }}
                            </textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Gambar Saat Ini -->
                        <div class="mb-4">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            @if ($mekanisme_pengaduan->image)
                                <img src="{{ Storage::url($mekanisme_pengaduan->image) }}"
                                     class="preview-image" alt="Gambar Saat Ini">
                            @else
                                <p class="text-muted">Belum ada gambar</p>
                            @endif
                        </div>

                        <!-- Ganti Gambar Baru -->
                        <div class="mb-4">
                            <label class="form-label">Ganti Gambar Baru (Opsional)</label>
                            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>

                            <img id="preview" class="new-preview" alt="Preview Gambar Baru">
                        </div>

                        <!-- URL Tautan + Preview Video -->
                        <div class="mb-4">
                            <label class="form-label">URL Tautan (YouTube / Vimeo - Opsional)</label>
                            <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                                value="{{ old('url', $mekanisme_pengaduan->url) }}" placeholder="https://www.youtube.com/watch?v=...">
                            @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            <div id="video-preview" class="video-preview">
                                <iframe id="video-frame" width="100%" height="280" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="mb-4">
    <label class="form-label">Posisi Urutan <span class="text-danger">*</span></label>
    <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
        value="{{ old('position', $mekanisme_pengaduan->position) }}" min="1" required>
    @error('position')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label text-muted">Daftar Posisi Urutan yang Sudah Digunakan:</label>
    <div class="border rounded p-3 bg-light" style="max-height: 220px; overflow-y: auto;">
        @forelse($usedPositions as $pos)
            <div class="d-flex justify-content-between py-1 border-bottom">
                <span>
                    <strong>{{ $pos->position }}</strong>
                    @if($pos->id == $mekanisme_pengaduan->id)
                        <span class="badge bg-primary ms-2">Data Saat Ini</span>
                    @endif
                </span>
                <span class="text-muted">{{ $pos->name }}</span>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada data.</p>
        @endforelse
    </div>
</div>

                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <!-- Hidden input penting untuk checkbox -->
                                <input type="hidden" name="is_active" value="0">
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

        <!-- Tips -->
        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan Penting</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gambar lama akan tetap digunakan jika tidak diganti</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>URL YouTube/Vimeo akan otomatis ditampilkan sebagai video</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Posisi kecil = tampil lebih atas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview Gambar Baru
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
            } else {
                preview.style.display = 'none';
            }
        });

        // Preview Video URL
        document.getElementById('url').addEventListener('input', function() {
            const url = this.value.trim();
            const previewContainer = document.getElementById('video-preview');
            const frame = document.getElementById('video-frame');

            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                let videoId = url.split('v=')[1] || url.split('/').pop();
                if (videoId) videoId = videoId.split('&')[0];
                frame.src = `https://www.youtube.com/embed/${videoId}`;
                previewContainer.style.display = 'block';
            }
            else if (url.includes('vimeo.com')) {
                const videoId = url.split('/').pop();
                frame.src = `https://player.vimeo.com/video/${videoId}`;
                previewContainer.style.display = 'block';
            }
            else {
                previewContainer.style.display = 'none';
                frame.src = '';
            }
        });

        // Toast Success
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
