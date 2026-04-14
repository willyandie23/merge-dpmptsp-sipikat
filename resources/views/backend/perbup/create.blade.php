@extends('backend.layouts.master')

@section('title', 'Edit Peraturan Bupati')

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

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .ck-editor__editable_inline {
            min-height: 420px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Edit Teks Peraturan Bupati</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.perbup.index') }}">Perbup</a></li>
                            <li class="breadcrumb-item active">Edit Teks</li>
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
                    <h4 class="card-title mb-0 text-white">Form Teks Peraturan Bupati</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('backend.perbup.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Teks Peraturan Bupati <span class="text-danger">*</span></label>
                            <textarea name="teks_perbup" id="teks_perbup" 
                                      class="form-control ckeditor @error('teks_perbup') is-invalid @enderror" 
                                      rows="12">{{ old('teks_perbup', $perbup->teks_perbup ?? '') }}</textarea>
                            @error('teks_perbup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Masukkan teks lengkap Peraturan Bupati Katingan Nomor 38 Tahun 2022 yang akan ditampilkan di website.
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-lg">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" 
                                       class="form-check-input" value="1" 
                                       {{ old('is_active', $perbup->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Aktifkan teks ini di halaman dashboard website
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('backend.perbup.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary text-white px-4">
                                <i class="mdi mdi-content-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // CKEditor 5 Initialization (sesuai global setup project kamu)
        ClassicEditor
            .create(document.querySelector('.ckeditor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });

        // SweetAlert Success
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