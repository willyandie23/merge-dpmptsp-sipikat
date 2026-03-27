@extends('frontend.layouts.app')

@push('css')
<style>
    .survey-card {  /* pakai class yang sama dengan survey biar konsisten */
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        height: 100%;
        background: #fff;
    }

    .perizinan-card {
        background: var(--primary);
        color: white;
        border-radius: 12px;
        padding: 20px 15px;
        text-align: center;
        transition: transform 0.2s;
    }
    .perizinan-card:hover {
        transform: translateY(-4px);
    }
    .perizinan-card h5 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        opacity: 0.9;
    }
    .perizinan-card .number {
        font-size: 2.8rem;
        font-weight: 700;
        line-height: 1;
    }
    .perizinan-card .label {
        font-size: 1rem;
        opacity: 0.9;
    }

    .year-selector {
        max-width: 280px;
        margin: 0 auto;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .chart-container {
        position: relative;
        height: 380px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <h1 class="text-center mb-1 fw-bold text-primary">Jumlah Perizinan Terbit</h1>

    {{-- FILTER TAHUN --}}
    @if(!empty($years))
    <div class="text-center mb-2">
        <form method="GET" class="d-inline-block">
            <select name="year" class="form-select year-selector shadow-sm" onchange="this.form.submit()">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    {{-- PERIODE DINAMIS (sama seperti Survey) --}}
    <p class="text-center text-success fw-medium mb-4">{{ $periode ?? '' }}</p>

    @if(empty($selectedYear))
        <div class="alert alert-warning text-center">Data perizinan belum tersedia.</div>
    @else

    {{-- 3 CARD PERIZINAN --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="perizinan-card">
                <h5 class="text-light">OSS RBA</h5>
                <div class="number">{{ $total_oss_rba }}</div>
                <div class="label">Perizinan</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="perizinan-card">
                <h5 class="text-light">SiCantik Cloud</h5>
                <div class="number">{{ $total_sicantik }}</div>
                <div class="label">Perizinan</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="perizinan-card">
                <h5 class="text-light">SIMBG</h5>
                <div class="number">{{ $total_simbg }}</div>
                <div class="label">Perizinan</div>
            </div>
        </div>
    </div>

    {{-- BAR CHART --}}
    <div class="card survey-card">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Penerbitan Perizinan Periode {{ $selectedYear }}</h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="perizinanChart"></canvas>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('perizinanChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'OSS RBA',
                    data: @json($chartOSS),
                    backgroundColor: '#0ea5e9',
                    borderColor: '#0ea5e9',
                    borderWidth: 1
                },
                {
                    label: 'SiCantik Cloud',
                    data: @json($chartSicantik),
                    backgroundColor: '#64748b',
                    borderColor: '#64748b',
                    borderWidth: 1
                },
                {
                    label: 'SIMBG',
                    data: @json($chartSIMBG),
                    backgroundColor: '#e2e8f0',
                    borderColor: '#e2e8f0',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { color: '#f1f5f9' } }
            }
        }
    });
});
</script>
@endpush