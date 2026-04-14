@extends('backend.layouts.master')

@section('title', $isEdit ? 'Edit Realisasi Investasi Tahun ' . $year : 'Tambah Realisasi Investasi')

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
        .form-control, .form-control:focus { border-radius: 8px; }

        .table th {
            background: #f8f9fa;
            vertical-align: middle;
            font-weight: 600;
        }

        .total-row {
            background-color: #e9ecef !important;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .target-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.2rem;
            border-left: 5px solid #556ee6;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #556ee6, #364574) !important;
            border: none;
        }

        .currency-input { font-weight: 500; }
        .year-input[readonly] {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            cursor: not-allowed;
        }

        .alert-debug {
            background: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">
                        {{ $isEdit ? 'Edit' : 'Tambah' }} Data Realisasi Investasi
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.investment.index') }}">Realisasi Investasi</a></li>
                            <li class="breadcrumb-item active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
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
                    <h4 class="card-title mb-0 text-white">
                        Form {{ $isEdit ? 'Edit' : 'Tambah' }} Realisasi Investasi 
                        @if($year) Tahun {{ $year }} @endif
                    </h4>
                </div>
                <div class="card-body p-4">

                    {{-- DEBUG ERROR YANG JELAS --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ada kesalahan validasi:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif

                    <form action="{{ $isEdit ? route('backend.investment.update', $year) : route('backend.investment.store') }}"
                          method="POST">
                        @csrf
                        @if($isEdit) @method('PUT') @endif

                        <!-- Input Tahun -->
                        <div class="mb-4">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="year"
                                   class="form-control year-input @error('year') is-invalid @enderror"
                                   value="{{ old('year', $year ?? date('Y')) }}" 
                                   min="2000" max="2100" required {{ $isEdit ? 'readonly' : '' }}>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Target Tahunan -->
                        <div class="target-box mb-4">
                            <label class="form-label">Target Investasi Tahunan (Rp) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="target_amount"
                                   class="form-control text-end currency-input target-input fs-5"
                                   value="{{ old('target_amount', $target?->target_amount ?? ($data[0]['target_amount'] ?? 0)) }}"
                                   placeholder="0" required>
                            <small class="text-muted">Target ini berlaku untuk keseluruhan tahun (PMA + PMDN)</small>
                            @error('target_amount')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="investmentTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="120">Triwulan</th>
                                        <th width="100">Jenis</th>
                                        <th class="text-end">Realisasi (Rp)</th>
                                        <th class="text-end">Tenaga Kerja Terserap</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $index => $row)
                                        <tr>
                                            <td>
                                                <strong>Triwulan {{ $row['quarter'] }}</strong>
                                                <input type="hidden" name="data[{{$index}}][quarter]" value="{{ $row['quarter'] }}">
                                            </td>
                                            <td>
                                                <span class="badge {{ $row['type'] == 'PMA' ? 'bg-primary' : 'bg-success' }}">
                                                    {{ $row['type'] }}
                                                </span>
                                                <input type="hidden" name="data[{{$index}}][type]" value="{{ $row['type'] }}">
                                            </td>
                                            <td>
                                                <input type="text" 
                                                       name="data[{{$index}}][realized_amount]"
                                                       class="form-control text-end currency-input realization-input"
                                                       value="{{ old('data.' . $index . '.realized_amount', $row['realized_amount']) }}"
                                                       placeholder="0" required>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       name="data[{{$index}}][labor_absorbed]"
                                                       class="form-control text-end labor-input"
                                                       value="{{ old('data.' . $index . '.labor_absorbed', $row['labor_absorbed']) }}"
                                                       min="0" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="2" class="text-end"><strong>TOTAL</strong></td>
                                        <td class="text-end" id="totalRealization">Rp 0</td>
                                        <td class="text-end" id="totalLabor">0 orang</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('backend.investment.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-gradient text-white">
                                <i class="mdi mdi-content-save me-1"></i>
                                {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
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
    document.addEventListener('DOMContentLoaded', function () {
        const realizationInputs = document.querySelectorAll('.realization-input');
        const laborInputs = document.querySelectorAll('.labor-input');
        const currencyInputs = document.querySelectorAll('.currency-input');

        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value ? parseInt(value).toLocaleString('id-ID') : '';
        }

        function calculateTotals() {
            let sumRealization = 0, sumLabor = 0;

            realizationInputs.forEach(inp => {
                sumRealization += parseInt(inp.value.replace(/\./g, '')) || 0;
            });

            laborInputs.forEach(inp => {
                sumLabor += parseInt(inp.value) || 0;
            });

            document.getElementById('totalRealization').textContent = 'Rp ' + sumRealization.toLocaleString('id-ID');
            document.getElementById('totalLabor').textContent = sumLabor.toLocaleString('id-ID') + ' orang';
        }

        currencyInputs.forEach(input => {
            formatCurrency(input);
            input.addEventListener('input', () => { formatCurrency(input); calculateTotals(); });
            input.addEventListener('focus', () => { input.value = input.value.replace(/\./g, ''); });
            input.addEventListener('blur', () => { formatCurrency(input); calculateTotals(); });
        });

        laborInputs.forEach(input => input.addEventListener('input', calculateTotals));

        calculateTotals();

        // Bersihkan titik sebelum submit
        document.querySelector('form').addEventListener('submit', function () {
            currencyInputs.forEach(inp => {
                inp.value = inp.value.replace(/\./g, '');
            });
        });
    });
</script>
@endpush