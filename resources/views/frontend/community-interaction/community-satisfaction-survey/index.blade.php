@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Survey Kepuasan Masyarakat
@endsection

@push('css')
    <style>
        .survey-card {
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
            background: #fff;
        }

        .gender-total {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e2937;
        }

        .gender-ring {
            width: 170px;
            height: 170px;
            margin: 15px auto;
        }

        .grade-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
            font-weight: 700;
            margin: 10px auto 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .indeks-box {
            background: #0ea5e9;
            color: white;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            text-align: center;
        }

        .year-selector {
            max-width: 280px;
            margin: 0 auto;
            font-size: 1.25rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .gender-ring {
                width: 140px;
                height: 140px;
            }

            .grade-circle {
                width: 130px;
                height: 130px;
                font-size: 3.5rem;
            }

            .year-selector {
                font-size: 0.9rem;
                max-width: 200px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">

        <h1 class="text-center mb-1 fw-bold text-primary">Survey Kepuasan Masyarakat</h1>

        @if (!empty($years))
            <div class="text-center mb-2">
                <form method="GET" class="d-inline-block">
                    <select name="year" class="form-select year-selector shadow-sm" onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif

        <p class="text-center text-success fw-medium mb-4">{{ $periode ?? '' }}</p>

        @if (empty($selectedYear))
            <div class="alert alert-warning text-center">Data survey belum tersedia.</div>
        @else
            <div class="card survey-card mb-5">
                <div class="card-body">
                    <div class="row g-0">

                        {{-- KOLOM 1: JENIS KELAMIN --}}
                        <div class="col-lg-6 p-4">
                            <h5 class="mb-3 text-center">Jenis Kelamin</h5>

                            <div class="d-flex justify-content-center">
                                <canvas id="genderChart" class="gender-ring"></canvas>
                            </div>

                            <div class="text-center mb-2">
                                <span class="gender-total">{{ $total_responden }}</span>
                                <span class="text-muted fs-8"> Responden</span>
                            </div>

                            <div class="row text-center mt-3 gx-4">
                                <div class="col-6">
                                    <span class="badge bg-success px-3 py-1 fs-6">Laki-Laki</span><br>
                                    <strong class="fs-4 text-success">{{ $persen_laki }}%</strong><br>
                                    <small class="text-muted">{{ $total_laki }} Orang</small>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-info px-3 py-1 fs-6">Perempuan</span><br>
                                    <strong class="fs-4 text-info">{{ $persen_perempuan }}%</strong><br>
                                    <small class="text-muted">{{ $total_perempuan }} Orang</small>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM 2: GRADE --}}
                        <div class="col-lg-6 p-4">
                            <h5 class="mb-3 text-center">Grade</h5>

                            @php
                                $circleColor = match ($grade_text) {
                                    'A' => '#22c55e',
                                    'B' => '#3b82f6',
                                    'C' => '#eab308',
                                    'D' => '#ef4444',
                                    default => '#64748b',
                                };
                            @endphp

                            <div class="grade-circle" style="background-color: {{ $circleColor }};">
                                {{ $grade_text }}
                            </div>

                            <div class="text-center mt-2">
                                <h4 class="mb-1 fw-light">Indeks <span
                                        class="fw-bold text-primary">{{ $indeks_keseluruhan }}</span></h4>
                                <p class="fw-bold fs-4 mb-0" style="color: {{ $circleColor }};">
                                    {{ $keterangan }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- TABEL INDIKATOR (tetap terpisah di bawah) --}}
            <div class="card survey-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table">
                                <tr>
                                    <th width="60%" class="fw-bold">Indikator</th>
                                    <th class="text-center fw-bold">Indeks</th>
                                    <th class="text-center fw-bold">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indikators as $item)
                                    <tr>
                                        <td>{{ $item['nama'] }}</td>
                                        <td class="text-center">
                                            <div class="indeks-box d-inline-block">{{ $item['nilai'] }}</div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeColor = match ($item['grade']) {
                                                    'A' => 'bg-success',
                                                    'B' => 'bg-primary',
                                                    'C' => 'bg-warning text-dark',
                                                    'D' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span
                                                class="badge {{ $badgeColor }} px-3 py-2">{{ $item['keterangan'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('genderChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Laki-Laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $persen_laki ?? 0 }}, {{ $persen_perempuan ?? 0 }}],
                        backgroundColor: ['#22c55e', '#00aeff'],
                        borderColor: '#ffffff',
                        borderWidth: 8
                    }]
                },
                options: {
                    cutout: '60%',
                    rotation: -90,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
