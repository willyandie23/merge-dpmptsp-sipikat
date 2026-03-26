@extends('backend.layouts.master')

@section('title', 'Edit Peluang Investasi')

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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Peluang Investasi: {{ $peluang_investasi->title }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.peluang-investasi.index') }}">Peluang Investasi</a></li>
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
                    <h4 class="card-title mb-0">Form Edit Peluang Investasi</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('backend.peluang-investasi.update', $peluang_investasi) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <!-- Kecamatan -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Kecamatan <span class="text-danger">*</span></label>
                            <select name="kecamatan_id" id="kecamatan_id"
                                    class="form-control @error('kecamatan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id }}"
                                        {{ old('kecamatan_id', $peluang_investasi->id_kecamatan) == $kec->id ? 'selected' : '' }}>
                                        {{ $kec->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Sektor -->
                        <div class="mb-4">
                            <label class="form-label">Pilih Sektor <span class="text-danger">*</span></label>
                            <select name="sektor_id" id="sektor_id"
                                    class="form-control @error('sektor_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Sektor --</option>
                                @foreach($sektors as $sektor)
                                    <option value="{{ $sektor->id }}"
                                        {{ old('sektor_id', $peluang_investasi->id_sektor) == $sektor->id ? 'selected' : '' }}>
                                        {{ $sektor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sektor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label">Judul Peluang Investasi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $peluang_investasi->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label class="form-label">Upload Gambar Utama (Opsional)</label>
                            <input type="file" name="image" id="image"
                                   class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                        </div>

                        <!-- Preview Gambar Saat Ini -->
                        @if($peluang_investasi->image)
                            <div class="mb-4 text-center">
                                <label class="form-label">Gambar Saat Ini</label><br>
                                <img src="{{ Storage::url($peluang_investasi->image) }}"
                                     class="img-preview" style="max-height: 250px;" alt="Current Image">
                            </div>
                        @endif

                        <!-- Preview Gambar Baru -->
                        <div id="image-preview" class="mb-4 text-center" style="display: none;">
                            <label class="form-label">Preview Gambar Baru</label><br>
                            <img id="preview-img" class="img-preview" src="#" alt="Preview" style="max-height: 300px;">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Peluang Investasi <span class="text-danger">*</span></label>
                            <textarea name="description" id="editor"
                                class="form-control @error('description') is-invalid @enderror">
                                {{ old('description', $peluang_investasi->description) }}
                            </textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.peluang-investasi.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i> Update Peluang Investasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card tips-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="mdi mdi-lightbulb-outline me-2"></i>Catatan Edit</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Ganti kecamatan akan mempengaruhi pilihan sektor</li>
                        <li class="mb-3"><i class="mdi mdi-check-circle text-success me-2"></i>Upload gambar baru jika ingin mengganti</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    // Preview Gambar Baru
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

    // Dependent Dropdown untuk Edit
    const kecamatanSelectEdit = document.getElementById('kecamatan_id');
    const sektorSelectEdit = document.getElementById('sektor_id');

    kecamatanSelectEdit.addEventListener('change', function () {
        const kecamatanId = this.value;
        sektorSelectEdit.innerHTML = '<option value="">-- Loading... --</option>';

        if (!kecamatanId) {
            sektorSelectEdit.innerHTML = '<option value="">-- Pilih Sektor --</option>';
            return;
        }

        fetch(`{{ route('backend.peluang-investasi.getSektorsByKecamatan') }}?kecamatan_id=${kecamatanId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            sektorSelectEdit.innerHTML = '<option value="">-- Pilih Sektor --</option>';
            data.forEach(sektor => {
                const selected = (sektor.id == {{ $peluang_investasi->id_sektor ?? 0 }}) ? 'selected' : '';
                sektorSelectEdit.innerHTML += `<option value="${sektor.id}" ${selected}>${sektor.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error fetching sectors:', error);
            sektorSelectEdit.innerHTML = '<option value="">-- Gagal memuat sektor --</option>';
        });
    });
</script>
@endpush
