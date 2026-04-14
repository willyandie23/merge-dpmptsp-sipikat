@extends('backend.layouts.master')

@section('title', 'Kelola Realisasi Investasi')

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

    .table th {
        background: #f8f9fa;
        font-weight: 600;
        vertical-align: middle;
    }

    .badge-pma  { background-color: #556ee6 !important; }
    .badge-pmdn { background-color: #10b981 !important; }

    .section-header {
        border-bottom: 3px solid #556ee6;
        padding-bottom: 12px;
        margin-bottom: 1.5rem;
    }

    .total-row {
        background-color: #e9ecef !important;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .year-group { background-color: #f8f9fa; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18 text-white">Kelola Realisasi Investasi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Realisasi Investasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-modern">
            <div class="card-body p-4">

                @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                @if (session('warning')) <div class="alert alert-warning">{{ session('warning') }}</div> @endif
                @if (session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

                <div class="d-flex justify-content-between align-items-center mb-4 section-header">
                    <h5 class="mb-0">Data Realisasi Investasi PMA & PMDN Tahun {{ $selectedYear }}</h5>

                    <div class="d-flex gap-3">
                        <form method="GET" action="{{ route('backend.investment.index') }}" class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0 text-muted">Tahun:</label>
                            <select name="year" class="form-select w-auto" onchange="this.form.submit()">
                                @foreach($years as $y)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </form>

                        <a href="{{ route('backend.investment.create') }}" class="btn btn-primary text-white">
                            <i class="mdi mdi-plus-circle me-1"></i> Tambah Data Tahun Baru
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="investmentTable">
                        <thead class="table-light">
                            <tr>
                                <th>Tahun</th>
                                <th>Triwulan</th>
                                <th>Jenis</th>
                                <th class="text-end">Target Tahunan (Rp)</th>
                                <th class="text-end">Realisasi (Rp)</th>
                                <th class="text-end">% Capaian</th>
                                <th class="text-end">Tenaga Kerja</th>
                                <th width="140">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $prevYear = null; 
                                $currentTarget = 0;
                            @endphp

                            @forelse($realizations as $item)
                                @php
                                    $isFirstRowOfYear = ($item->year != $prevYear);
                                    if ($isFirstRowOfYear) {
                                        $currentTarget = $target?->target_amount ?? 0;
                                    }
                                    $prevYear = $item->year;

                                    // Hitung persentase per baris (BENAR)
                                    $persentase = $currentTarget > 0 
                                        ? round(($item->realized_amount / $currentTarget) * 100, 4) 
                                        : 0;
                                @endphp

                                <tr class="{{ $isFirstRowOfYear ? 'year-group' : '' }}">
                                    <td>@if($isFirstRowOfYear)<strong>{{ $item->year }}</strong>@else<span class="text-muted">—</span>@endif</td>
                                    <td>Triwulan {{ $item->quarter }}</td>
                                    <td>
                                        <span class="badge {{ $item->type == 'PMA' ? 'badge-pma' : 'badge-pmdn' }} text-white">
                                            {{ $item->type }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        @if($isFirstRowOfYear)
                                            Rp {{ number_format($currentTarget, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end realization-col fw-bold">
                                        Rp {{ number_format($item->realized_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-{{ $persentase >= 100 ? 'success' : ($persentase >= 80 ? 'warning' : 'danger') }}">
                                            {{ $persentase }}%
                                        </span>
                                    </td>
                                    <td class="text-end labor-col">
                                        {{ number_format($item->labor_absorbed, 0, ',', '.') }} orang
                                    </td>
                                    <td>
                                        @if($isFirstRowOfYear)
                                            <a href="{{ route('backend.investment.edit', $item->year) }}" class="btn btn-sm btn-warning">
                                                <i class="mdi mdi-pencil"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-investment" data-year="{{ $item->year }}">
                                                <i class="mdi mdi-delete"></i> Hapus
                                            </button>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Belum ada data untuk tahun ini.</td>
                                </tr>
                            @endempty
                        </tbody>

                        <!-- TOTAL ROW -->
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="text-end fw-bold">Total Tahun {{ $selectedYear }}</td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($target?->target_amount ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-bold" id="totalRealization">Rp 0</td>
                                <td class="text-end fw-bold" id="totalPercentage">— %</td>
                                <td class="text-end fw-bold" id="totalLabor">0 orang</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.querySelectorAll('.delete-investment').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const year = this.getAttribute('data-year');

            Swal.fire({
                title: 'Hapus Semua data tahun ' + year + '?',
                text: "Data target dan seluruh realisasi triwulan akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form delete secara dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('backend.investment.destroy', ':year') }}`.replace(':year', year);
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    function calculateTableTotals() {
        let sumRealization = 0;
        let sumLabor = 0;

        document.querySelectorAll('.realization-col').forEach(el => {
            const val = parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
            sumRealization += val;
        });

        document.querySelectorAll('.labor-col').forEach(el => {
            const val = parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
            sumLabor += val;
        });

        const targetAmount = {{ $target?->target_amount ?? 0 }};
        const totalPercentage = targetAmount > 0 
            ? round((sumRealization / targetAmount) * 100, 2) 
            : 0;

        document.getElementById('totalRealization').textContent = 'Rp ' + sumRealization.toLocaleString('id-ID');
        document.getElementById('totalLabor').textContent = sumLabor.toLocaleString('id-ID') + ' orang';
        document.getElementById('totalPercentage').textContent = totalPercentage + '%';
    }

    function round(num, decimals) {
        return Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateTableTotals();

        @if (session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', toast: true, position: 'top-end', timer: 3000 });
        @endif
    });
</script>
@endpush