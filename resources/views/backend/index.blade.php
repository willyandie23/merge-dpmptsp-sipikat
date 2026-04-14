@extends('backend/layouts.master')

@section('title', 'Dashboard')

@push('css')
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .main-content { padding-top: 90px !important; }
        .page-content { margin-top: -4rem !important; }

        .section-header {
            border-bottom: 3px solid #556ee6;
            padding-bottom: 12px;
            margin-bottom: 1.8rem;
        }

        .service-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            overflow: hidden;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12) !important;
        }

        .layanan-utama-img {
            height: 180px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .service-card:hover .layanan-utama-img {
            transform: scale(1.05);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            background: linear-gradient(135deg, #556ee6, #364574);
            color: white;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(85, 110, 230, 0.3);
        }

        .status-badge {
            font-size: 0.82rem;
            padding: 0.4em 0.85em;
        }

        .empty-state {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 3rem 2rem;
        }

        .horizontal-scroll {
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 1rem;
            scrollbar-width: thin;
        }

        .services-wrapper {
            display: flex;
            gap: 1.5rem;
            flex-wrap: nowrap;
            min-width: max-content;
        }

        #investmentChart, #donutTargetRealized, #donutPmaPmdn {
            min-height: 380px;
        }
    </style>
@endpush

@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Dashboard Admin</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Selamat Datang Kembali</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Section -->
    <div class="row">
        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Layanan Utama</h5>
                    <p class="text-muted mb-0">Layanan unggulan di halaman depan</p>
                </div>
                <a href="{{ route('backend.layanan-utama.index') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-cog-outline me-1"></i> Kelola
                </a>
            </div>

            <div class="horizontal-scroll">
                <div class="services-wrapper">
                    @forelse ($layananUtama as $item)
                        <div class="col-12" style="width: 320px;">
                            <div class="card service-card h-100">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="layanan-utama-img w-100" alt="{{ $item->title }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                        <i class="mdi mdi-image-off font-size-48 text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">{{ $item->title }}</h5>
                                    <p class="card-text text-muted flex-grow-1 small">
                                        {{ Str::limit(strip_tags($item->description ?? '-'), 95) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                    <span class="status-badge badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                    <small class="text-muted">Posisi: {{ $item->position }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center w-100">
                            <i class="mdi mdi-image-multiple font-size-48 text-muted mb-3"></i>
                            <h5>Belum ada Layanan Utama</h5>
                        </div>
                    @endempty
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Layanan Perizinan Usaha</h5>
                    <p class="text-muted mb-0">Daftar layanan perizinan</p>
                </div>
                <a href="{{ route('backend.layanan-perizinan.index') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-cog-outline me-1"></i> Kelola
                </a>
            </div>

            <div class="horizontal-scroll">
                <div class="services-wrapper">
                    @forelse ($layananPerizinan as $item)
                        <div class="col-12" style="width: 280px;">
                            <div class="card service-card h-100 text-center">
                                <div class="card-body pt-4 pb-2">
                                    <div class="icon-box mx-auto mb-3">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h5 class="card-title mb-3">{{ $item->title }}</h5>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <span class="status-badge badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center w-100">
                            <i class="mdi mdi-file-document-multiple font-size-48 text-muted mb-3"></i>
                            <h5>Belum ada Layanan Perizinan</h5>
                        </div>
                    @endempty
                </div>
            </div>

            <!-- === TOTAL STATISTIK (News, Gallery, Video, Populasi) === -->
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <h5 class="mb-0 text-dark">Total Konten & Data</h5>
                </div>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="card stat-card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="mdi mdi-newspaper font-size-32 text-primary mb-2"></i>
                                <h5 class="fw-bold mb-1">{{ number_format($totalNews ?? 0) }}</h5>
                                <small class="text-muted">Berita</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card stat-card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="mdi mdi-image-multiple font-size-32 text-success mb-2"></i>
                                <h5 class="fw-bold mb-1">{{ number_format($totalGallery ?? 0) }}</h5>
                                <small class="text-muted">Galeri</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card stat-card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="mdi mdi-video font-size-32 text-warning mb-2"></i>
                                <h5 class="fw-bold mb-1">{{ number_format($totalVideo ?? 0) }}</h5>
                                <small class="text-muted">Video</small>
                            </div>
                        </div>
                    </div>
                    <!-- POPULASI (SLIDESHOW PER TAHUN) - Tetap Pakai Style yang Sama -->
<div class="col-6 col-md-3">
    <div class="card stat-card h-100 border-0 shadow-sm">
        <div class="card-body text-center">

            <i class="mdi mdi-account-group font-size-32 text-info mb-2"></i>

            <div id="populasiCarousel" class="carousel slide carousel-fade"
                 data-bs-ride="carousel"
                 data-bs-interval="3500">

                <div class="carousel-inner">
                    @forelse($populasiPerTahun as $index => $pop)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <h5 class="fw-bold mb-1 text-dark">
                                {{ number_format($pop->total_amount ?? 0) }}
                            </h5>
                            <small class="text-muted">
                                Populasi Tahun {{ $pop->year }}
                            </small>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <h5 class="fw-bold mb-1 text-dark">0</h5>
                            <small class="text-muted">Populasi</small>
                        </div>
                    @endforelse
                </div>
            </div>
{{--
            <!-- Indikator kecil (opsional, biar tetap rapi) -->
            @if($populasiPerTahun->count() > 1)
            <div class="mt-2">
                <div class="carousel-indicators position-relative" style="bottom: auto; margin: 0 auto; width: 50px;">
                    @foreach($populasiPerTahun as $index => $pop)
                        <button type="button"
                                data-bs-target="#populasiCarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}"
                                style="background-color: #6c757d; width: 6px; height: 6px; border-radius: 50%; opacity: 0.6;">
                        </button>
                    @endforeach
                </div>
            </div>
            @endif --}}

        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

        <!-- Grafik Bar -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Grafik Realisasi Investasi</h5>
                    <p class="text-muted mb-0">Perbandingan Target dan Realisasi per Tahun</p>
                </div>
                <a href="{{ route('backend.investment.index') }}" class="btn btn-primary">
                    <i class="mdi mdi-chart-line me-1"></i> Kelola Data Investasi
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div id="investmentChart"></div>
                </div>
            </div>
        </div>
    </div>

  <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Ringkasan Realisasi Investasi {{ $selectedYear }}</h5>
                    <p class="text-muted mb-0">Perbandingan PMA & PMDN (Target, Realisasi, dan Tenaga Kerja)</p>
                </div>

                <form method="GET" class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0 text-muted">Tahun:</label>
                    <select name="year" class="form-select w-auto" onchange="this.form.submit()">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Total Keseluruhan -->
        <div class="col-xl-12">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-cash-multiple font-size-36 text-primary me-3"></i>
                                <div>
                                    <h6 class="text-muted mb-1">Total Realisasi</h6>
                                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalRealizedYear ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-target font-size-36 text-warning me-3"></i>
                                <div>
                                    <h6 class="text-muted mb-1">Total Target</h6>
                                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalTarget ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-chart-line font-size-36 text-{{ ($capaianOverall ?? 0) >= 90 ? 'success' : (($capaianOverall ?? 0) >= 70 ? 'warning' : 'danger') }} me-3"></i>
                                <div>
                                    <h6 class="text-muted mb-1">Capaian Keseluruhan</h6>
                                    <h4 class="fw-bold mb-0 {{ ($capaianOverall ?? 0) >= 90 ? 'text-success' : (($capaianOverall ?? 0) >= 70 ? 'text-warning' : 'text-danger') }}">
                                        {{ $capaianOverall ?? 0 }}%
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-account-multiple font-size-36 text-success me-3"></i>
                                <div>
                                    <h6 class="text-muted mb-1">Total Tenaga Kerja</h6>
                                    <h4 class="fw-bold mb-0">{{ number_format($totalLaborYear ?? 0, 0, ',', '.') }}</h4>
                                    <small class="text-muted">orang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breakdown PMA -->
        <div class="col-xl-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-success"><i class="mdi mdi-arrow-up-bold"></i> PMA</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Realisasi PMA</span>
                        <span class="fw-bold text-success">Rp {{ number_format($pmaRealized ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Capaian PMA</span>
                        <span class="fw-bold {{ ($pmaCapaian ?? 0) >= 90 ? 'text-success' : 'text-warning' }}">
                            {{ $pmaCapaian ?? 0 }}%
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tenaga Kerja PMA</span>
                        <span class="fw-bold">{{ number_format($pmaLabor ?? 0, 0, ',', '.') }} orang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breakdown PMDN -->
        <div class="col-xl-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-primary"><i class="mdi mdi-arrow-up-bold"></i> PMDN</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Realisasi PMDN</span>
                        <span class="fw-bold text-success">Rp {{ number_format($pmdnRealized ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Capaian PMDN</span>
                        <span class="fw-bold {{ ($pmdnCapaian ?? 0) >= 90 ? 'text-success' : 'text-warning' }}">
                            {{ $pmdnCapaian ?? 0 }}%
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tenaga Kerja PMDN</span>
                        <span class="fw-bold">{{ number_format($pmdnLabor ?? 0, 0, ',', '.') }} orang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail per Triwulan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Detail Realisasi per Triwulan {{ $selectedYear }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Triwulan</th>
                                    <th>Jenis</th>
                                    <th class="text-end">Target (Rp)</th>
                                    <th class="text-end">Realisasi (Rp)</th>
                                    <th class="text-end">% Capaian</th>
                                    <th class="text-end">Tenaga Kerja</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($realizations as $item)
                                    @php
                                        $target = $item->target?->target_amount ?? 0;
                                        $persentase = $target > 0 ? round(($item->realized_amount / $target) * 100, 2) : 0;
                                    @endphp
                                    <tr>
                                        <td>Triwulan {{ $item->quarter }}</td>
                                        <td><span class="badge bg-{{ $item->type == 'PMA' ? 'primary' : 'success' }}">{{ $item->type }}</span></td>
                                        <td class="text-end">Rp {{ number_format($target, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <span class="badge bg-{{ $persentase >= 100 ? 'success' : ($persentase >= 80 ? 'warning' : 'danger') }}">
                                                {{ $persentase }}%
                                            </span>
                                        </td>
                                        <td class="text-end">{{ number_format($item->labor_absorbed, 0, ',', '.') }} orang</td>
                                        <td>
                                            <a href="{{ route('backend.investment.edit', $item->year) }}" class="btn btn-sm btn-warning">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Belum ada data realisasi investasi untuk tahun {{ $selectedYear }}
                                        </td>
                                    </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penyerapan Tenaga Kerja -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-end mb-4 section-header">
                <div>
                    <h5 class="mb-1 text-dark">Penyerapan Tenaga Kerja {{ $selectedYear }}</h5>
                    <p class="text-muted mb-0">Total tenaga kerja yang terserap dari realisasi investasi</p>
                </div>
                <a href="{{ route('backend.investment.index') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-chart-line me-1"></i> Kelola Data
                </a>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="icon-box mx-auto mb-4" style="width: 90px; height: 90px; font-size: 42px; background: linear-gradient(135deg, #10b981, #0f766e);">
                        <i class="mdi mdi-account-multiple"></i>
                    </div>
                    <h4 class="text-muted mb-2">Total Penyerapan</h4>
                    <h2 class="fw-bold text-success mb-0">
                        {{ number_format($totalLaborYear ?? 0, 0, ',', '.') }}
                    </h2>
                    <p class="text-muted mt-1">orang</p>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Penyerapan Tenaga Kerja per Triwulan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Triwulan</th>
                                    <th>Jenis Investasi</th>
                                    <th class="text-end">Tenaga Kerja</th>
                                    <th class="text-end">% dari Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($realizations as $item)
                                    @php
                                        $persenLabor = $totalLaborYear > 0
                                            ? round(($item->labor_absorbed / $totalLaborYear) * 100, 1)
                                            : 0;
                                    @endphp
                                    <tr>
                                        <td>Triwulan {{ $item->quarter }}</td>
                                        <td><span class="badge bg-{{ $item->type == 'PMA' ? 'primary' : 'success' }}">{{ $item->type }}</span></td>
                                        <td class="text-end fw-bold">{{ number_format($item->labor_absorbed, 0, ',', '.') }} orang</td>
                                        <td class="text-end"><span class="badge bg-info">{{ $persenLabor }}%</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Belum ada data penyerapan tenaga kerja untuk tahun {{ $selectedYear }}
                                        </td>
                                    </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dua Donut Chart -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Target vs Realisasi {{ $selectedYear }}</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative" style="min-height: 380px;">
                    <div id="donutTargetRealized"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Kontribusi PMA & PMDN {{ $selectedYear }}</h5>
                </div>
                <div class="card-body position-relative d-flex align-items-center justify-content-center" style="min-height: 380px;">
                    <div id="donutPmaPmdn"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Load ApexCharts dari CDN (lebih stabil untuk kasus ini) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        if (!window.chartsRendered) {
            window.chartsRendered = true;

            window.addEventListener('load', function() {

                setTimeout(() => {

                    // BAR CHART
                    const barEl = document.getElementById('investmentChart');
                    if (barEl) {
                        if (window.investmentBarChart) try { window.investmentBarChart.destroy(); } catch(e) {}
                        try {
                            window.investmentBarChart = new ApexCharts(barEl, {
                                series: [
                                    { name: 'Target', data: @json($chartData['target'] ?? []) },
                                    { name: 'Realisasi', data: @json($chartData['realized'] ?? []) }
                                ],
                                chart: { height: 400, type: 'bar', toolbar: { show: true } },
                                plotOptions: { bar: { horizontal: false, columnWidth: '55%', endingShape: 'rounded' } },
                                dataLabels: { enabled: false },
                                stroke: { show: true, width: 2, colors: ['transparent'] },
                                xaxis: { categories: @json($chartData['years'] ?? []), title: { text: 'Tahun' }, labels: { rotate: -45 } },
                                yaxis: { title: { text: 'Nilai Investasi (Rp)' }, labels: { formatter: val => "Rp " + (val || 0).toLocaleString('id-ID') } },
                                tooltip: { y: { formatter: val => "Rp " + (val || 0).toLocaleString('id-ID') } },
                                colors: ['#556ee6', '#10b981'],
                                legend: { position: 'top', horizontalAlign: 'left' }
                            });
                            window.investmentBarChart.render();
                        } catch (e) { console.error('Bar Chart Error:', e); }
                    }

                    // DONUT 1: Target vs Realisasi
                    setTimeout(() => {
                        const donutTargetEl = document.getElementById('donutTargetRealized');
                        if (donutTargetEl) {
                            if (window.donutTargetChart) try { window.donutTargetChart.destroy(); } catch(e) {}
                            try {
                                let targetVal = parseFloat(@json($donutTargetRealized['target'] ?? 0));
                                let realizedVal = parseFloat(@json($donutTargetRealized['realized'] ?? 0));
                                if (targetVal <= 0 && realizedVal <= 0) { targetVal = 100; realizedVal = 0; }
                                const sisaTarget = Math.max(0, targetVal - realizedVal);
                                const capaian = targetVal > 0 ? Math.round((realizedVal / targetVal) * 100) : 0;

                                window.donutTargetChart = new ApexCharts(donutTargetEl, {
                                    series: [realizedVal, sisaTarget],
                                    chart: { height: 340, type: 'donut' },
                                    labels: ['Realisasi', 'Sisa Target'],
                                    colors: ['#556ee6', '#6c757d'],
                                    tooltip: { y: { formatter: val => "Rp " + (val || 0).toLocaleString('id-ID') } },
                                    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Capaian', formatter: () => capaian + '%' } } } } },
                                    legend: { position: 'bottom' },
                                    dataLabels: { enabled: false }
                                });
                                window.donutTargetChart.render();
                            } catch (e) { console.error('Donut Target Error:', e); }
                        }
                    }, 400);

                    // DONUT 2: PMA vs PMDN
                    setTimeout(() => {
                        const donutPmaEl = document.getElementById('donutPmaPmdn');
                        if (donutPmaEl) {
                            if (window.donutPmaChart) try { window.donutPmaChart.destroy(); } catch(e) {}
                            try {
                                const pmaPercent = parseFloat(@json($donutPmaPmdn['pma_percent'] ?? 50));
                                const pmdnPercent = parseFloat(@json($donutPmaPmdn['pmdn_percent'] ?? 50));
                                const totalPercent = (pmaPercent + pmdnPercent).toFixed(1);

                                window.donutPmaChart = new ApexCharts(donutPmaEl, {
                                    series: [pmaPercent, pmdnPercent],
                                    chart: { height: 340, type: 'donut' },
                                    labels: ['PMA', 'PMDN'],
                                    colors: ['#10b981', '#556ee6'],
                                    tooltip: { y: { formatter: val => val.toFixed(1) + ' %' } },
                                    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', formatter: () => totalPercent + '%' } } } } },
                                    legend: { position: 'bottom' },
                                    dataLabels: { enabled: true, formatter: val => val.toFixed(1) + '%' }
                                });
                                window.donutPmaChart.render();
                            } catch (e) { console.error('Donut PMA/PMDN Error:', e); }
                        }
                    }, 900);

                }, 800);

            });
        }
    </script>
@endpush