@extends('backend.layouts.master')

@section('title', 'Edit Tentang DPMPTSP')

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

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control,
        .form-control:focus {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .img-preview {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        /* CKEditor Style */
        .ck-editor__editable_inline {
            min-height: 350px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Tentang DPMPTSP</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.tentang-dpmptsp.index') }}">Tentang
                                    DPMPTSP</a></li>
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
                    <h4 class="card-title mb-0">Form Edit Data Tentang DPMPTSP</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.tentang-dpmptsp.update', $tentang) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label class="form-label">Gambar Utama</label><br>
                            @if ($tentang->image)
                                <img src="{{ Storage::url($tentang->image) }}" class="img-preview mb-3"
                                    style="max-height: 220px; object-fit: cover;">
                            @else
                                <p class="text-muted">Belum ada gambar</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Ganti Gambar (opsional)</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 2MB (jpg, png, webp)</small>
                        </div>

                        <div id="image-preview" class="mb-4 text-center" style="display: none;">
                            <img id="preview-img" class="img-preview" src="#" alt="Preview Gambar Baru">
                        </div>

                        <!-- Semua Field Menggunakan CKEditor -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi Umum</label>
                            <textarea name="description" id="editor-description"
                                class="form-control ckeditor">{{ old('description', $tentang->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="dasar_hukum" class="form-label">Dasar Hukum</label>
                            <textarea name="dasar_hukum" id="editor-dasar_hukum"
                                class="form-control ckeditor">{{ old('dasar_hukum', $tentang->dasar_hukum) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="visi" class="form-label">Visi</label>
                            <textarea name="visi" id="editor-visi"
                                class="form-control ckeditor">{{ old('visi', $tentang->visi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="misi" class="form-label">Misi</label>
                            <textarea name="misi" id="editor-misi"
                                class="form-control ckeditor">{{ old('misi', $tentang->misi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="maklumat_layanan" class="form-label">Maklumat Layanan</label>
                            <textarea name="maklumat_layanan" id="editor-maklumat"
                                class="form-control ckeditor">{{ old('maklumat_layanan', $tentang->maklumat_layanan) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="moto_layanan" class="form-label">Moto Layanan</label>
                            <textarea name="moto_layanan" id="editor-moto"
                                class="form-control ckeditor">{{ old('moto_layanan', $tentang->moto_layanan) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="waktu_layanan" class="form-label">Waktu Layanan</label>
                            <textarea name="waktu_layanan" id="editor-waktu"
                                class="form-control ckeditor">{{ old('waktu_layanan', $tentang->waktu_layanan) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat Kantor</label>
                            <textarea name="alamat" id="editor-alamat"
                                class="form-control ckeditor">{{ old('alamat', $tentang->alamat) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="struktur_organisasi" class="form-label">Struktur Organisasi</label>
                            <textarea name="struktur_organisasi" id="editor-struktur"
                                class="form-control ckeditor">{{ old('struktur_organisasi', $tentang->struktur_organisasi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="sasaran_layanan" class="form-label">Sasaran Layanan</label>
                            <textarea name="sasaran_layanan" id="editor-sasaran"
                                class="form-control ckeditor">{{ old('sasaran_layanan', $tentang->sasaran_layanan) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('backend.tentang-dpmptsp.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Perubahan
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
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Ganti gambar akan otomatis
                            menghapus file lama</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Semua field teks menggunakan
                            CKEditor</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Data Tentang DPMPTSP biasanya hanya 1
                            record</li>
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
            const previewDiv = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    previewImg.src = ev.target.result;
                    previewDiv.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.style.display = 'none';
            }
        });

        // Toast Success Message
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
