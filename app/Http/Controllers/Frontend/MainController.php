<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BannerDashboard;
use App\Models\Gallery;
use App\Models\InvestmentRealization;
use App\Models\InvestmentTarget;
use App\Models\Kecamatan;
use App\Models\KomoditasUnggulan;
use App\Models\LayananPerizinan;
use App\Models\LayananUtama;
use App\Models\News;
use App\Models\PeluangInvestasi;
use App\Models\PertumbuhanEkonomi;
use App\Models\Populasi;
use App\Models\ProdukDomestik;
use App\Models\Sektor;

class MainController extends Controller
{
    public function index()
    {
        $banners = BannerDashboard::where('is_active', 1)->get();

        $layananUtama = LayananUtama::active()->ordered()->get();
        $layananPerizinan = LayananPerizinan::active()->ordered()->get();

        // === REALISASI INVESTASI (pakai variabel sendiri) ===
        $realisasiYear = request('year', 2026);

        $realisasiPerTahun = InvestmentRealization::selectRaw('year, SUM(realized_amount) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $realisasiTahunIni = InvestmentRealization::where('year', $realisasiYear)
            ->whereIn('quarter', [1, 2, 3])
            ->get();

        $targetTahunIni = InvestmentTarget::where('year', $realisasiYear)
            ->whereIn('quarter', [1, 2, 3])
            ->get();

        $totalRealisasi = $realisasiTahunIni->sum('realized_amount');
        $totalTarget    = $targetTahunIni->sum('target_amount');
        $totalTenagaKerja = $realisasiTahunIni->sum('labor_absorbed');
        $pma = $realisasiTahunIni->where('type', 'PMA')->sum('realized_amount');
        $pmdn = $realisasiTahunIni->where('type', 'PMDN')->sum('realized_amount');

        $realisasiYears = InvestmentRealization::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // === BERITA & GALERI ===
        $latestNews = News::active()->latest()->take(3)->get();
        $latestGallery = Gallery::active()->latest()->take(3)->get();

        // === KOMODITAS UNGGULAN ===
        $komoditasUnggulan = KomoditasUnggulan::latest()->paginate(4);

        // === PELUANG INVESTASI FILTER ===
        $kecamatanId = request('kecamatan_id');
        $sektorId    = request('sektor_id');
        $keyword     = request('keyword');
        $selectedYear = request('year', date('Y'));   // tetap untuk Peluang Investasi

        $kecamatans = Kecamatan::orderBy('name')->get();
        $sektors    = Sektor::orderBy('name')->get();
        $peluangYears = PertumbuhanEkonomi::pluck('year')->unique()->sort()->values();

        // === STATISTIK DINAMIS PELUANG INVESTASI ===
        $populasiQuery = Populasi::where('year', $selectedYear);
        if ($kecamatanId) $populasiQuery->where('kecamatan_id', $kecamatanId);
        $totalPopulasi = $populasiQuery->sum('amount');

        $pdrbQuery = ProdukDomestik::where('year', $selectedYear);
        if ($sektorId) $pdrbQuery->where('sektor_id', $sektorId);
        $totalPDRB = $pdrbQuery->sum('amount');

        $pertumbuhan = PertumbuhanEkonomi::where('year', $selectedYear)->first();
        $pertumbuhanEkonomi = $pertumbuhan ? $pertumbuhan->amount : 0;

        $peluangInvestasi = PeluangInvestasi::query()
            ->when($kecamatanId, fn($q) => $q->where('id_kecamatan', $kecamatanId))
            ->when($sektorId, fn($q) => $q->where('id_sektor', $sektorId))
            ->when($keyword, fn($q) => $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%"))
            ->with(['kecamatan', 'sektor'])
            ->latest()
            ->get();

        return view('frontend.main.index', compact(
            'banners', 'layananUtama', 'layananPerizinan',
            'realisasiPerTahun', 'totalRealisasi', 'totalTarget',
            'totalTenagaKerja', 'pma', 'pmdn', 'realisasiYear', 'realisasiYears',
            'latestNews', 'latestGallery',
            'komoditasUnggulan',
            'kecamatans', 'sektors', 'peluangYears', 'selectedYear',
            'totalPopulasi', 'totalPDRB', 'pertumbuhanEkonomi',
            'peluangInvestasi',
            'kecamatanId', 'sektorId', 'keyword'
        ));
    }
}
