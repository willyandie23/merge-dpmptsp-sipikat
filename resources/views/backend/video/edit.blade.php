@extends('backend.layouts.master')

@section('title', 'Edit Video')

@push('css')
    <style>
        /* CSS persis dari index */
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

        .card-header-modern h4 {
            color: white !important;
            margin: 0 !important;
        }

        .btn-add-banner {
            padding: 0.6rem 1.5rem !important;
            font-size: 1rem !important;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
            transition: all 0.3s ease;
        }

        .btn-add-banner:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85, 110, 230, 0.45) !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(85, 110, 230, 0.06) !important;
        }

        .img-thumbnail-modern {
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .img-thumbnail-modern:hover {
            transform: scale(1.1);
        }

        .aksi-column {
            text-align: center !important;
        }

        .btn-group {
            display: inline-flex;
            justify-content: center;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control,
        .form-control:focus {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
            padding: 0.6rem 1.5rem !important;
            box-shadow: 0 4px 12px rgba(85, 110, 230, 0.35) !important;
            transition: all 0.3s;
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

        .tips-card .card-header {
            background: white !important;
            border-bottom: 1px solid #556ee6 !important;
        }

        .tips-card h5 {
            color: #364574 !important;
        }

        /* Preview video embed */
        .video-preview {
            max-width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: none;
        }
    </style>
@endpush

@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Video: {{ $video->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.video.index') }}">Video</a></li>
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
                    <h4 class="card-title mb-0">Form Edit Video</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.video.update', $video) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Video <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $video->title) }}" required autofocus>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi Video (opsional)</label>
                            <textarea name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $video->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="url" class="form-label">URL Video (YouTube/Vimeo) <span
                                    class="text-danger">*</span></label>
                            <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                                value="{{ old('url', $video->url) }}"
                                placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxxxxxxx" required>
                            @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted mt-2">Paste link YouTube atau Vimeo</small>
                        </div>

                        <div class="mb-4">
                            <div class="video-preview" id="video-preview">
                                <iframe id="preview-frame" width="100%" height="100%" frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="mb-4">
    <div class="form-check form-switch form-switch-lg">
        <!-- Hidden Input WAJIB -->
        <input type="hidden" name="is_active" value="0">

        <input name="is_active" type="checkbox" class="form-check-input" id="is_active"
               value="1"
               {{ old('is_active', $video->is_active ? 1 : 0) ? 'checked' : '' }}>

        <label class="form-check-label" for="is_active">
            Aktifkan video ini
        </label>
    </div>
</div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.video.index') }}" class="btn btn-light waves-effect">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Update Video
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
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan Penting</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gunakan link YouTube atau
                            Vimeo</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Judul maksimal 100 karakter
                        </li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Video aktif akan muncul di halaman depan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview embed video saat ketik URL
        const urlInput = document.getElementById('url');
        const preview = document.getElementById('video-preview');
        const frame = document.getElementById('preview-frame');

        function updatePreview() {
            const url = urlInput.value.trim();
            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                const videoId = url.split('v=')[1] || url.split('/').pop();
                frame.src = `https://www.youtube.com/embed/${videoId}`;
                preview.style.display = 'block';
            } else if (url.includes('vimeo.com')) {
                const videoId = url.split('/').pop();
                frame.src = `https://player.vimeo.com/video/${videoId}`;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
                frame.src = '';
            }
        }

        urlInput.addEventListener('input', updatePreview);
        // Load preview awal kalau edit
        updatePreview();
    </script>
@endpush
