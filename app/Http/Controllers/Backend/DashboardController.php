<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InvestmentTarget;
use App\Models\InvestmentRealization;
use App\Models\LayananUtama;
use App\Models\LayananPerizinan;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Video;
use App\Models\Populasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Data Layanan
        $layananUtama = LayananUtama::active()->ordered()->take(6)->get();
        $layananPerizinan = LayananPerizinan::active()->ordered()->take(8)->get();

        $currentYear = date('Y');
        $selectedQuarter = $request->get('quarter');

        // Tahun yang tersedia untuk filter
        $availableYears = InvestmentRealization::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->get('year') ?? $availableYears->first() ?? $currentYear;

        // Data Realisasi Investasi per Triwulan
        $realizations = InvestmentRealization::where('year', $selectedYear)
            ->orderBy('quarter')
            ->orderBy('type')
            ->get();

        // Attach target ke setiap record
        $realizations->each(function ($realization) {
            $realization->target = InvestmentTarget::where('year', $realization->year)
                ->where('quarter', $realization->quarter)
                ->where('type', $realization->type)
                ->first();
        });

        // Ringkasan total per tahun
        $investmentSummary = InvestmentRealization::selectRaw('
            year,
            SUM(realized_amount) as total_realized,
            SUM(labor_absorbed) as total_labor
        ')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // === DATA BAR CHART ===
        $chartQuery = InvestmentRealization::selectRaw('
            investment_realizations.year,
            COALESCE(SUM(investment_targets.target_amount), 0) as total_target,
            COALESCE(SUM(investment_realizations.realized_amount), 0) as total_realized
        ')
            ->leftJoin('investment_targets', function ($join) {
                $join->on('investment_targets.year', '=', 'investment_realizations.year')
                    ->on('investment_targets.quarter', '=', 'investment_realizations.quarter')
                    ->on('investment_targets.type', '=', 'investment_realizations.type');
            })
            ->groupBy('investment_realizations.year')
            ->orderBy('investment_realizations.year', 'asc');

        if ($selectedQuarter) {
            $chartQuery->where('investment_realizations.quarter', $selectedQuarter);
        }

        $chartDataRaw = $chartQuery->get();

        $chartData = [
            'years' => $chartDataRaw->pluck('year')->values(),
            'target' => $chartDataRaw->pluck('total_target')->values(),
            'realized' => $chartDataRaw->pluck('total_realized')->values(),
        ];

        // === DONUT TARGET VS REALISASI ===
        $totalTarget = InvestmentTarget::where('year', $selectedYear)->sum('target_amount');
        $totalRealized = InvestmentRealization::where('year', $selectedYear)->sum('realized_amount');

        $donutTargetRealized = [
            'target' => $totalTarget ?: 100,
            'realized' => $totalRealized,
        ];

        // === DONUT PMA vs PMDN ===
        $pmaRealized = InvestmentRealization::where('year', $selectedYear)->where('type', 'PMA')->sum('realized_amount');
        $pmdnRealized = InvestmentRealization::where('year', $selectedYear)->where('type', 'PMDN')->sum('realized_amount');

        $totalAll = $pmaRealized + $pmdnRealized;
        $pmaPercent = $totalAll > 0 ? round(($pmaRealized / $totalAll) * 100, 1) : 50;
        $pmdnPercent = $totalAll > 0 ? round(($pmdnRealized / $totalAll) * 100, 1) : 50;

        $donutPmaPmdn = [
            'pma_percent' => $pmaPercent,
            'pmdn_percent' => $pmdnPercent,
        ];

        // === RINGKASAN UMUM ===
        $summary = $investmentSummary->where('year', $selectedYear)->first();

        $totalRealizedYear = $summary?->total_realized ?? 0;
        $totalLaborYear = $summary?->total_labor ?? 0;

        $capaianOverall = $totalTarget > 0
            ? round(($totalRealizedYear / $totalTarget) * 100, 2)
            : 0;

        // === BREAKDOWN PMA ===
        $pmaTarget = InvestmentTarget::where('year', $selectedYear)
            ->where('type', 'PMA')
            ->sum('target_amount');

        $pmaLabor = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMA')
            ->sum('labor_absorbed');

        $pmaCapaian = $pmaTarget > 0
            ? round(($pmaRealized / $pmaTarget) * 100, 2)
            : 0;

        // === BREAKDOWN PMDN ===
        $pmdnTarget = InvestmentTarget::where('year', $selectedYear)
            ->where('type', 'PMDN')
            ->sum('target_amount');

        $pmdnLabor = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMDN')
            ->sum('labor_absorbed');

        $pmdnCapaian = $pmdnTarget > 0
            ? round(($pmdnRealized / $pmdnTarget) * 100, 2)
            : 0;

        // === TOTAL STATISTIK TAMBAHAN ===
        $totalNews = News::count();
        $totalGallery = Gallery::count();
        $totalVideo = Video::count();
        $totalPopulasi = Populasi::sum('amount');   // total jumlah populasi

        // === TOTAL POPULASI KABUPATEN PER TAHUN (SUM SEMUA KECAMATAN) ===
        $populasiPerTahun = Populasi::selectRaw('year, SUM(amount) as total_amount')
            ->groupBy('year')
            ->orderBy('year', 'desc')           // tahun terbaru di atas
            ->get();

        return view('backend.index', compact(
            'layananUtama',
            'layananPerizinan',
            'realizations',
            'investmentSummary',
            'currentYear',
            'selectedYear',
            'availableYears',
            'selectedQuarter',
            'chartData',
            'donutTargetRealized',
            'donutPmaPmdn',
            // Ringkasan Umum
            'totalRealizedYear',
            'totalLaborYear',
            'totalTarget',
            'capaianOverall',
            // Breakdown PMA
            'pmaRealized',
            'pmaTarget',
            'pmaLabor',
            'pmaCapaian',
            // Breakdown PMDN
            'pmdnRealized',
            'pmdnTarget',
            'pmdnLabor',
            'pmdnCapaian',
            // Statistik Tambahan
            'totalNews',
            'totalGallery',
            'totalVideo',
            'totalPopulasi',
            'populasiPerTahun'
        ));
    }
}
