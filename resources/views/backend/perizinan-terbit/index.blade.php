@extends('backend.layouts.master')

@section('title', 'Manajemen Perizinan Terbit')

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
            margin-bottom: 2rem !important;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .summary-card {
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .month-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .month-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(85, 110, 230, 0.25) !important;
        }

        .month-card.active {
            border-color: #556ee6;
            background-color: #f8f9ff;
        }

        .summary-number {
            font-size: 1.9rem;
            font-weight: 700;
            color: #364574;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9ff, #eef2ff);
            border-left: 5px solid #556ee6;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Manajemen Perizinan Terbit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Perizinan Terbit</li>
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
                    <h4 class="card-title mb-0 text-white">Data Perizinan Terbit</h4>
                    <a href="{{ route('backend.perizinan-terbit.create') }}" class="btn btn-light">
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

                    <!-- Ringkasan Tahunan -->
                    <div id="year-summary" class="row g-3 mb-4" style="display: none;"></div>

                    <!-- Daftar Bulan -->
                    <div id="month-list" class="row g-3" style="display: none;"></div>

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
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <strong>OSS RBA</strong><br>
                                            <span id="oss_rba" class="fs-4 fw-bold text-primary"></span>
                                        </div>
                                        <div class="col-4">
                                            <strong>SiCantik Cloud</strong><br>
                                            <span id="sicantik_cloud" class="fs-4 fw-bold text-info"></span>
                                        </div>
                                        <div class="col-4">
                                            <strong>SIMBG</strong><br>
                                            <span id="simbg" class="fs-4 fw-bold text-success"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <strong class="text-muted">Total Perizinan Terbit</strong><br>
                                    <span id="total_terbit" class="fs-3 fw-bold text-danger"></span>
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
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        @endif
    </script>
    <script>
        let surveyData = @json($grouped);   // Note: kita reuse variabel surveyData meski ini perizinan

        let currentYear = null;
        let currentMonth = null;

        const bulanList = [
            { num: 1, nama: 'Januari' }, { num: 2, nama: 'Februari' }, { num: 3, nama: 'Maret' },
            { num: 4, nama: 'April' }, { num: 5, nama: 'Mei' }, { num: 6, nama: 'Juni' },
            { num: 7, nama: 'Juli' }, { num: 8, nama: 'Agustus' }, { num: 9, nama: 'September' },
            { num: 10, nama: 'Oktober' }, { num: 11, nama: 'November' }, { num: 12, nama: 'Desember' }
        ];

        function renderYearSummary(year) {
            const yearData = surveyData[year];
            if (!yearData) return;

            let totalOSS = 0, totalSicantik = 0, totalSIMBG = 0, totalTerbit = 0;

            Object.values(yearData).forEach(data => {
                totalOSS += Number(data.oss_rba || 0);
                totalSicantik += Number(data.sicantik_cloud || 0);
                totalSIMBG += Number(data.simbg || 0);
                totalTerbit += Number(data.total_terbit || 0);
            });

            const html = `
                        <div class="col-md-3">
                            <div class="card summary-card p-3 text-center">
                                <h6 class="text-muted mb-1">OSS RBA</h6>
                                <span class="summary-number text-primary">${totalOSS.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card p-3 text-center">
                                <h6 class="text-muted mb-1">SiCantik Cloud</h6>
                                <span class="summary-number text-info">${totalSicantik.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card p-3 text-center">
                                <h6 class="text-muted mb-1">SIMBG</h6>
                                <span class="summary-number text-success">${totalSIMBG.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card summary-card p-3 text-center border-primary">
                                <h6 class="text-muted mb-1">Total Terbit Tahun ${year}</h6>
                                <span class="summary-number text-danger">${totalTerbit.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    `;

            document.getElementById('year-summary').innerHTML = html;
            document.getElementById('year-summary').style.display = 'flex';
        }

        function renderMonthCards(year) {
            const container = document.getElementById('month-list');
            container.innerHTML = '';

            bulanList.forEach(bulan => {
                const hasData = surveyData[year] && surveyData[year][bulan.num] !== undefined;

                const cardHTML = `
                            <div class="col-md-3 col-lg-2">
                                <div class="card month-card h-100 text-center ${hasData ? 'border-primary' : ''}"
                                     data-month="${bulan.num}">
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
                    text: 'Tambahkan data perizinan untuk bulan ini?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Tambah Sekarang'
                }).then(res => {
                    if (res.isConfirmed) {
                        window.location.href = `{{ route('backend.perizinan-terbit.create') }}?year=${currentYear}&month=${month}`;
                    }
                });
                return;
            }
            currentSurveyId = data.id;

            document.getElementById('detail-title').innerHTML = `Tahun <strong>${currentYear}</strong> — ${bulanList.find(b => b.num === month).nama}`;
            document.getElementById('oss_rba').textContent = Number(data.oss_rba || 0).toLocaleString('id-ID');
            document.getElementById('sicantik_cloud').textContent = Number(data.sicantik_cloud || 0).toLocaleString('id-ID');
            document.getElementById('simbg').textContent = Number(data.simbg || 0).toLocaleString('id-ID');
            document.getElementById('total_terbit').textContent = Number(data.total_terbit || 0).toLocaleString('id-ID');

            document.getElementById('btn-edit').href = `{{ route('backend.perizinan-terbit.edit', ':id') }}`.replace(':id', data.id);

            panel.style.display = 'block';
        }

        // Event Year Change
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

            renderYearSummary(currentYear);
            renderMonthCards(currentYear);
        });

        // === TOMBOL DELETE PERIZINAN TERBIT ===
        document.addEventListener('click', function (e) {
            if (e.target && e.target.id === 'btn-delete') {
                if (!currentSurveyId) {   // note: kamu pakai currentSurveyId meski ini perizinan
                    Swal.fire('Error', 'ID data tidak ditemukan', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data perizinan terbit ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('backend.perizinan-terbit.destroy', ':id') }}`.replace(':id', currentSurveyId), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => {
                                if (response.ok) {
                                    return response.json().catch(() => ({}));
                                }
                                throw new Error('Delete failed');
                            })
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    timer: 1800,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Delete Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                });
                            });
                    }
                });
            }
        });
    </script>
@endpush
