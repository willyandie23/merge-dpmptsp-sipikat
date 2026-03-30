@extends('backend.layouts.master')

@section('title', 'Tambah Peluang Investasi')

@push('css')
    <style>
        /* CSS persis dari index Banner Dashboard */
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

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
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

         .ck-editor__editable_inline {
            min-height: 450px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tambah Peluang Investasi Baru</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.peluang-investasi.index') }}">Peluang
                                    Investasi</a></li>
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
                    <h4 class="card-title mb-0">Form Tambah Peluang Investasi</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.peluang-investasi.store') }}" method="POST"
                        enctype="multipart/form-data" id="form-peluang">
                        @csrf

                        <!-- Kecamatan -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Kecamatan <span class="text-danger">*</span></label>
                            <select name="kecamatan_id" id="kecamatan_id"
                                class="form-control @error('kecamatan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                        {{ $kec->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Sektor (akan diisi via AJAX) -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Sektor <span class="text-danger">*</span></label>
                            <select name="sektor_id" id="sektor_id"
                                class="form-control @error('sektor_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Sektor --</option>
                            </select>
                            @error('sektor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label">Judul Peluang Investasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Contoh: Investasi Pabrik Pengolahan Sawit" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label class="form-label">Upload Gambar Utama <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Rekomendasi: 1200x800 px, maksimal 2MB</small>
                        </div>

                        <!-- Preview Gambar -->
                        <div id="image-preview" class="mb-4 text-center" style="display: none;">
                            <label class="form-label">Preview Gambar</label><br>
                            <img id="preview-img" class="img-preview" src="#" alt="Preview" style="max-height: 300px;">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Peluang Investasi <span class="text-danger">*</span></label>
                            <textarea name="description"
                                class="form-control ckeditor @error('description') is-invalid @enderror" rows="12">
            {{ old('description') }}
        </textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.peluang-investasi.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Peluang Investasi
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
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Tips Penginputan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Pilih Kecamatan terlebih
                            dahulu</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Sektor akan muncul otomatis
                            sesuai kecamatan</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Gambar utama wajib diupload
                        </li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i>Deskripsi bisa menggunakan format rich
                            text</li>
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
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Dependent Dropdown
        const kecamatanSelect = document.getElementById('kecamatan_id');
        const sektorSelect = document.getElementById('sektor_id');

        kecamatanSelect.addEventListener('change', function () {
            const kecamatanId = this.value;
            sektorSelect.innerHTML = '<option value="">-- Loading... --</option>';

            if (!kecamatanId) {
                sektorSelect.innerHTML = '<option value="">-- Pilih Sektor --</option>';
                return;
            }

            fetch(`{{ route('backend.peluang-investasi.getSektorsByKecamatan') }}?kecamatan_id=${kecamatanId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    sektorSelect.innerHTML = '<option value="">-- Pilih Sektor --</option>';
                    if (data.length === 0) {
                        sektorSelect.innerHTML += '<option value="">-- Tidak ada sektor di kecamatan ini --</option>';
                    } else {
                        data.forEach(sektor => {
                            sektorSelect.innerHTML += `<option value="${sektor.id}">${sektor.name}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    sektorSelect.innerHTML = '<option value="">-- Gagal memuat sektor --</option>';
                });
        });
    </script>
@endpush
