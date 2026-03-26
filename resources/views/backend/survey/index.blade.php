@extends('backend.layouts.master')

@section('title', 'Manajemen Survey Kepuasan Masyarakat')

@push('css')
    <style>
        /* CSS Dasar dari Template Admin Anda */
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

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }

        /* Style Tambahan untuk Tampilan Survey Interaktif */
        .month-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .month-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(85, 110, 230, 0.25) !important;
        }

        .month-card.active {
            border-color: #556ee6;
            background-color: #f8f9ff;
        }

        .indikator-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #364574;
        }

        .grade-badge {
            font-size: 0.95rem;
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 500;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9ff, #eef2ff);
            border-left: 5px solid #556ee6;
            border-radius: 8px;
        }

        /* Tombol Tambah Data */
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

        /* Responsive & Aesthetic Improvement */
        .month-card .card-body {
            padding: 1.25rem !important;
        }

        .detail-panel {
            animation: fadeIn 0.4s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .text-muted {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Manajemen Survey Kepuasan Masyarakat</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Data Survey Kepuasan Masyarakat</h4>
                    <a href="{{ route('backend.survey.create') }}" class="btn btn-light">
                        <i class="mdi mdi-plus me-1"></i> Tambah Data Baru
                    </a>
                </div>

                <div class="card-body p-4">
                    <!-- Pilih Tahun -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih Tahun</label>
                        <select id="select-year" class="form-select form-select-lg">
                            <option value="">-- Pilih Tahun --</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="year-summary" class="row g-3 mb-4" style="display: none;">
                        <!-- Akan di-generate via JavaScript -->
                    </div>

                    <!-- Daftar Bulan -->
                    <div id="month-list" class="row g-3" style="display: none;">
                        <!-- Bulan cards akan di-generate via JavaScript -->
                    </div>

                    <!-- Detail Data Bulan -->
                    <div id="detail-panel" class="mt-4" style="display: none;">
                        <div class="info-box p-4 rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 id="detail-title" class="mb-0"></h5>
                                <div>
                                    <a id="btn-edit" href="#" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <button id="btn-delete" class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <strong>Jumlah Laki-laki</strong><br>
                                        <span id="jumlah-laki" class="fs-4"></span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Jumlah Perempuan</strong><br>
                                        <span id="jumlah-perempuan" class="fs-4"></span>
                                    </div>
                                    <div>
                                        <strong>Total Responden</strong><br>
                                        <span id="total-responden" class="fs-4 fw-bold text-primary"></span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h6 class="mb-3">Nilai 9 Indikator</h6>
                                    <div id="indikator-list" class="row g-2"></div>

                                    <div class="mt-4 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Indeks Kepuasan Masyarakat (IKM)</strong><br>
                                                <span id="rata-rata" class="fs-3 fw-bold text-success"></span>
                                            </div>
                                            <div>
                                                <span id="grade-badge" class="grade-badge"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Data dari Controller
        let surveyData = @json($grouped);

        let currentYear = null;
        let currentMonth = null;
        let currentSurveyId = null;

        const bulanList = [
            { num: 1, nama: 'Januari' }, { num: 2, nama: 'Februari' }, { num: 3, nama: 'Maret' },
            { num: 4, nama: 'April' }, { num: 5, nama: 'Mei' }, { num: 6, nama: 'Juni' },
            { num: 7, nama: 'Juli' }, { num: 8, nama: 'Agustus' }, { num: 9, nama: 'September' },
            { num: 10, nama: 'Oktober' }, { num: 11, nama: 'November' }, { num: 12, nama: 'Desember' }
        ];

        function getGrade(nilai) {
            if (nilai >= 3.53) return { text: 'Sangat Baik', color: 'bg-success' };
            if (nilai >= 3.06) return { text: 'Baik', color: 'bg-primary' };
            if (nilai >= 2.60) return { text: 'Kurang Baik', color: 'bg-warning' };
            return { text: 'Tidak Baik', color: 'bg-danger' };
        }

        function renderMonthCards(year) {
            const container = document.getElementById('month-list');
            container.innerHTML = '';

            bulanList.forEach(bulan => {
                const hasData = surveyData[year] && surveyData[year][bulan.num] !== undefined;

                const cardHTML = `
                                    <div class="col-md-3 col-lg-2">
                                        <div class="card month-card h-100 text-center ${hasData ? 'border-primary' : ''}"
                                             style="cursor:pointer;" data-month="${bulan.num}">
                                            <div class="card-body py-4">
                                                <h5 class="mb-1">${bulan.num}</h5>
                                                <p class="mb-0 text-muted">${bulan.nama}</p>
                                                ${hasData ?
                        `<span class="badge bg-success mt-2">Ada Data</span>` :
                        `<span class="badge bg-secondary mt-2">Belum Ada</span>`
                    }
                                            </div>
                                        </div>
                                    </div>
                                `;
                container.insertAdjacentHTML('beforeend', cardHTML);
            });

            container.style.display = 'flex';

            // Event klik bulan
            container.querySelectorAll('.month-card').forEach(card => {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.month-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    currentMonth = parseInt(this.dataset.month);
                    showDetail(currentMonth);
                });
            });
        }

        function showDetail(month) {
            const yearData = surveyData[currentYear];
            const data = yearData ? yearData[month] : null;
            const panel = document.getElementById('detail-panel');

            if (!data) {
                Swal.fire({
                    title: 'Data belum tersedia',
                    text: 'Apakah Anda ingin menambahkan data untuk bulan ini?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Tambah Sekarang'
                }).then(res => {
                    if (res.isConfirmed) {
                        window.location.href = `{{ route('backend.survey.create') }}?year=${currentYear}&month=${month}`;
                    }
                });
                return;
            }

            currentSurveyId = data.id;

            // Hitung rata-rata dan grade
            let sum = 0;
            let indikatorHtml = '';
            const indikators = ['indikator1', 'indikator2', 'indikator3', 'indikator4', 'indikator5', 'indikator6', 'indikator7', 'indikator8', 'indikator9'];
            const labels = ['Persyaratan', 'Sistem, Mekanisme & Prosedur', 'Waktu Penyelesaian', 'Biaya/Tarif', 'Produk/Spesifikasi', 'Kompetensi Pelaksana', 'Perilaku Pelaksana', 'Penanganan Pengaduan', 'Sarana & Prasarana'];

            indikators.forEach((key, i) => {
                const val = parseFloat(data[key]) || 0;
                sum += val;
                indikatorHtml += `
                                    <div class="col-6 col-sm-4 mb-2">
                                        <small class="text-muted">${labels[i]}</small><br>
                                        <span class="indikator-value">${val.toFixed(2)}</span>
                                    </div>`;
            });

            const rataRata = (sum / 9).toFixed(2);
            const grade = getGrade(parseFloat(rataRata));

            // Isi konten
            document.getElementById('detail-title').innerHTML = `Tahun <strong>${currentYear}</strong> — ${bulanList.find(b => b.num === month).nama}`;
            document.getElementById('jumlah-laki').textContent = Number(data.jumlah_laki || 0).toLocaleString('id-ID');
            document.getElementById('jumlah-perempuan').textContent = Number(data.jumlah_perempuan || 0).toLocaleString('id-ID');
            document.getElementById('total-responden').textContent = (Number(data.jumlah_laki || 0) + Number(data.jumlah_perempuan || 0)).toLocaleString('id-ID');

            document.getElementById('indikator-list').innerHTML = indikatorHtml;
            document.getElementById('rata-rata').textContent = rataRata;
            document.getElementById('grade-badge').innerHTML = `<span class="badge ${grade.color} grade-badge">${grade.text}</span>`;

            // === PERBAIKAN UTAMA ===
            document.getElementById('btn-edit').href = "{{ route('backend.survey.edit', ':id') }}".replace(':id', data.id);

            panel.style.display = 'block';
        }

        function renderYearSummary(year) {
            const yearData = surveyData[year];
            if (!yearData) return;

            let totalLaki = 0, totalPerempuan = 0, totalIndikator = 0, totalDataPoints = 0;
            let monthCount = 0;

            Object.keys(yearData).forEach(month => {
                const data = yearData[month];
                totalLaki += Number(data.jumlah_laki || 0);
                totalPerempuan += Number(data.jumlah_perempuan || 0);

                // Hitung semua 9 indikator
                for (let i = 1; i <= 9; i++) {
                    const val = parseFloat(data[`indikator${i}`]) || 0;
                    totalIndikator += val;
                    totalDataPoints++;
                }
                monthCount++;
            });

            const totalResponden = totalLaki + totalPerempuan;
            const rataRataIKM = totalDataPoints > 0 ? (totalIndikator / totalDataPoints).toFixed(2) : '0.00';
            const grade = getGrade(parseFloat(rataRataIKM));

            const html = `
                    <div class="col-md-3">
                        <div class="card summary-card text-center p-3">
                            <i class="mdi mdi-account-male fs-1 text-primary mb-2"></i>
                            <h6 class="text-muted">Laki-laki</h6>
                            <span class="summary-number">${totalLaki.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card text-center p-3">
                            <i class="mdi mdi-account-female fs-1 text-danger mb-2"></i>
                            <h6 class="text-muted">Perempuan</h6>
                            <span class="summary-number">${totalPerempuan.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card text-center p-3">
                            <i class="mdi mdi-account-group fs-1 text-success mb-2"></i>
                            <h6 class="text-muted">Total Responden</h6>
                            <span class="summary-number">${totalResponden.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card text-center p-3">
                            <h6 class="text-muted mb-1">IKM Tahun ${year}</h6>
                            <span class="summary-number text-success">${rataRataIKM}</span>
                            <br>
                            <span class="grade-badge badge ${grade.color} mt-2">${grade.text}</span>
                        </div>
                    </div>
                `;

            document.getElementById('year-summary').innerHTML = html;
            document.getElementById('year-summary').style.display = 'flex';
        }

        // Event ketika tahun dipilih
        document.getElementById('select-year').addEventListener('change', function () {
            currentYear = this.value;
            const monthList = document.getElementById('month-list');
            const detailPanel = document.getElementById('detail-panel');

            detailPanel.style.display = 'none';

            if (!currentYear) {
                document.getElementById('year-summary').style.display = 'none';
                monthList.style.display = 'none';
                return;
            }

            renderYearSummary(currentYear);        // ← Ringkasan Tahunan
            renderMonthCards(currentYear);         // ← Daftar Bulan
        });
    </script>
@endpush
