@extends('backend.layouts.master')

@section('title', 'Tambah Struktur Organisasi')

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

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.65rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #556ee6;
            box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.25);
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #556ee6;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tambah Struktur Organisasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.struktur-organisasi.index') }}">Struktur
                                    Organisasi</a></li>
                            <li class="breadcrumb-item active">Tambah Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h4 class="card-title mb-0">Form Tambah Anggota Struktur Organisasi</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.struktur-organisasi.store') }}" method="POST"
                        enctype="multipart/form-data" id="formStruktur">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select name="id_bidang" id="id_bidang" class="form-select" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $bidang)
                                            <option value="{{ $bidang->id }}">{{ $bidang->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_pejabat" id="is_pejabat"
                                            value="1">
                                        <label class="form-check-label fw-semibold" for="is_pejabat" id="label-pejabat">
                                            Ini adalah Pejabat Utama / Kepala Bidang
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Golongan / Pangkat</label>
                                    <input type="text" name="golongan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Foto</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <div id="image-preview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <div id="warning-pejabat" class="alert alert-danger d-none mt-3">
                            <strong>Tidak Diperbolehkan!</strong> Bidang ini sudah memiliki Pejabat Utama.
                            Anda tidak dapat menambahkan Pejabat Utama lagi di bidang yang sama.
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success px-4" id="btn-submit">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('backend.struktur-organisasi.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Preview Foto
        $('#image').on('change', function () {
            const preview = $('#image-preview');
            preview.html('');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.html(`<img src="${e.target.result}" class="preview-image">`);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Cek apakah bidang sudah punya pejabat utama
        $('#id_bidang').on('change', function () {
            const bidangId = $(this).val();
            const checkbox = $('#is_pejabat');
            const warning = $('#warning-pejabat');
            const submitBtn = $('#btn-submit');

            if (!bidangId) {
                warning.addClass('d-none');
                checkbox.prop('disabled', false);
                return;
            }

            $.ajax({
                url: "{{ route('backend.struktur-organisasi.check-pejabat') }}",
                method: 'GET',
                data: { bidang_id: bidangId },
                success: function (response) {
                    if (response.has_pejabat) {
                        warning.removeClass('d-none');
                        checkbox.prop('disabled', true).prop('checked', false);
                        submitBtn.prop('disabled', true);
                    } else {
                        warning.addClass('d-none');
                        checkbox.prop('disabled', false);
                        submitBtn.prop('disabled', false);
                    }
                }
            });
        });

        // Reset saat form di-submit (opsional)
        $('#formStruktur').on('submit', function () {
            $('#btn-submit').prop('disabled', true);
        });
    </script>
@endpush
