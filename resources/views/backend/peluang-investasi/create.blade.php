@extends('backend.layouts.master')

@section('title', 'Tambah Peluang Investasi')

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
        }

        .ck-editor__editable_inline {
            min-height: 450px !important;
        }

        .img-preview {
            max-height: 300px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Tambah Peluang Investasi Baru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.peluang-investasi.index') }}">Peluang
                                    Investasi</a></li>
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
                    <h4 class="card-title mb-0 text-white">Form Tambah Peluang Investasi</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.peluang-investasi.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Pilih Kecamatan <span class="text-danger">*</span></label>
                            <select name="kecamatan_id" class="form-control @error('kecamatan_id') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                        {{ $kec->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Pilih Sektor <span class="text-danger">*</span></label>
                            <select name="sektor_id" class="form-control @error('sektor_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Sektor --</option>
                                @foreach($sektors as $sektor)
                                    <option value="{{ $sektor->id }}" {{ old('sektor_id') == $sektor->id ? 'selected' : '' }}>
                                        {{ $sektor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sektor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Judul Peluang Investasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Contoh: Investasi Pabrik Pengolahan Kopi" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Gambar Utama <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal 2MB</small>
                        </div>

                        <div id="image-preview" class="mb-4 text-center" style="display:none;">
                            <img id="preview-img" class="img-preview" src="#" alt="Preview">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi Peluang Investasi <span class="text-danger">*</span></label>
                            <textarea name="description"
                                class="form-control ckeditor @error('description') is-invalid @enderror" rows="12">
                                    {{ old('description') }}
                                </textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.peluang-investasi.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Peluang Investasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Tips Penginputan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Pilih Kecamatan dan Sektor
                            secara bebas</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gambar utama wajib diupload
                        </li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Deskripsi menggunakan CKEditor (rich text)
                        </li>
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
                reader.onload = function (event) {
                    previewImg.src = event.target.result;
                    previewDiv.style.display = 'block';
                };
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
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush