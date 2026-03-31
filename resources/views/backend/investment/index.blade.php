@extends('backend.layouts.master')

@section('title', 'Kelola Realisasi Investasi')

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

    .table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .badge-pma {
        background-color: #556ee6 !important;
    }

    .badge-pmdn {
        background-color: #10b981 !important;
    }

    .section-header {
        border-bottom: 3px solid #556ee6;
        padding-bottom: 12px;
        margin-bottom: 1.5rem;
    }

    .total-row {
        background-color: #e9ecef !important;
        font-weight: 700;
        font-size: 1.05rem;
    }

    .total-row td {
        color: #2c3e50;
    }
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
                <!-- Notifikasi -->
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4 section-header">
                    <h5 class="mb-0">Data Realisasi Investasi PMA & PMDN</h5>

                    <div class="d-flex gap-3 align-items-center">
                        <!-- Dropdown Filter Tahun -->
                        <form method="GET" action="{{ route('backend.investment.index') }}"
                            class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0 text-muted">Tahun:</label>
                            <select name="year" class="form-select w-auto" onchange="this.form.submit()">
                                @foreach($years as $y)
                                <option value="{{ $y }}" {{ $selectedYear==$y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
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
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Triwulan</th>
                                <th>Jenis</th>
                                <th class="text-end">Target (Rp)</th>
                                <th class="text-end">Realisasi (Rp)</th>
                                <th class="text-end">% Capaian</th>
                                <th class="text-end">Tenaga Kerja</th>
                                <th width="140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $prevYear = null; @endphp
                            @forelse($data as $index => $item)
                            @php
                            $isFirstRowOfYear = ($item->year != $prevYear);
                            $prevYear = $item->year;

                            $target = $item->target?->target_amount ?? 0;
                            $persentase = $target > 0 ? round(($item->realized_amount / $target) * 100, 2) : 0;
                            @endphp

                            <tr>
                                <td><strong>{{ $item->year }}</strong></td>
                                <td>Triwulan {{ $item->quarter }}</td>
                                <td>
                                    <span
                                        class="badge {{ $item->type == 'PMA' ? 'badge-pma' : 'badge-pmdn' }} text-white">
                                        {{ $item->type }}
                                    </span>
                                </td>
                                <td class="text-end target-col">Rp {{ number_format($target, 0, ',', '.') }}</td>
                                <td class="text-end realization-col fw-bold">Rp {{ number_format($item->realized_amount,
                                    0, ',', '.') }}</td>
                                <td class="text-end">
                                    <span
                                        class="badge bg-{{ $persentase >= 100 ? 'success' : ($persentase >= 80 ? 'warning' : 'danger') }}">
                                        {{ $persentase }}%
                                    </span>
                                </td>
                                <td class="text-end labor-col">{{ number_format($item->labor_absorbed, 0, ',', '.') }}
                                    orang</td>

                                <td>
                                    @if($isFirstRowOfYear)
                                    <a href="{{ route('backend.investment.edit', $item->year) }}"
                                        class="btn btn-sm btn-warning mb-1">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-investment"
                                        data-year="{{ $item->year }}">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </button>
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    Belum ada data untuk tahun ini.<br>
                                    <a href="{{ route('backend.investment.create') }}"
                                        class="btn btn-primary mt-2">Tambah Data Tahun Baru</a>
                                </td>
                            </tr>
                            @endempty
                        </tbody>
                        <!-- BARIS TOTAL -->
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="text-end fw-bold">TOTAL</td>
                                <td class="text-end fw-bold" id="totalTarget">Rp 0</td>
                                <td class="text-end fw-bold" id="totalRealization">Rp 0</td>
                                <td class="text-end fw-bold" id="totalPercentage">—</td>
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
    // Delete confirm dengan SweetAlert2
    document.querySelectorAll('.delete-investment').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const year = this.getAttribute('data-year');

            Swal.fire({
                title: 'Hapus SEMUA data tahun ' + year + '?',
                text: "Data ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("backend.investment.destroy", ":year") }}'.replace(':year', year);
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // === HITUNG TOTAL OTOMATIS ===
    function calculateTableTotals() {
        let sumTarget = 0;
        let sumRealization = 0;
        let sumLabor = 0;
        let totalPersentase = 0;
        let countValidPersentase = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            // Target
            const targetText = row.querySelector('.target-col');
            if (targetText) {
                const targetVal = parseInt(targetText.textContent.replace(/[^0-9]/g, '')) || 0;
                sumTarget += targetVal;
            }

            // Realisasi
            const realizationText = row.querySelector('.realization-col');
            if (realizationText) {
                const realizationVal = parseInt(realizationText.textContent.replace(/[^0-9]/g, '')) || 0;
                sumRealization += realizationVal;
            }

            // Tenaga Kerja
            const laborText = row.querySelector('.labor-col');
            if (laborText) {
                const laborVal = parseInt(laborText.textContent.replace(/[^0-9]/g, '')) || 0;
                sumLabor += laborVal;
            }

            // Hitung persentase (untuk rata-rata)
            const persenBadge = row.querySelector('.badge.bg-success, .badge.bg-warning, .badge.bg-danger');
            if (persenBadge) {
                const persen = parseFloat(persenBadge.textContent) || 0;
                if (persen > 0) {
                    totalPersentase += persen;
                    countValidPersentase++;
                }
            }
        });

        const avgPersentase = countValidPersentase > 0
            ? Math.round(totalPersentase / countValidPersentase)
            : 0;

        // Update tampilan total
        document.getElementById('totalTarget').textContent = 'Rp ' + sumTarget.toLocaleString('id-ID');
        document.getElementById('totalRealization').textContent = 'Rp ' + sumRealization.toLocaleString('id-ID');
        document.getElementById('totalLabor').textContent = sumLabor.toLocaleString('id-ID') + ' orang';
        document.getElementById('totalPercentage').textContent = avgPersentase + '%';
    }

    // Jalankan saat halaman selesai load
    document.addEventListener('DOMContentLoaded', function () {
        calculateTableTotals();

        // Toast success
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
    });
</script>
@endpush
