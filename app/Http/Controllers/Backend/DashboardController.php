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
        $selectedYear = $request->get('year') ?? $currentYear;

        // Tahun yang tersedia
        $availableYears = InvestmentRealization::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$currentYear]);
        }

        $selectedYear = $availableYears->contains($selectedYear) ? $selectedYear : $availableYears->first();

        // === DATA REALISASI ===
        $realizations = InvestmentRealization::where('year', $selectedYear)
            ->orderBy('quarter')
            ->orderBy('type')
            ->get();

        // Target Tahunan (hanya 1 record)
        $target = InvestmentTarget::where('year', $selectedYear)->first();

        // Attach target ke setiap realization
        $realizations->each(function ($realization) use ($target) {
            $realization->target = $target;
        });

        // === RINGKASAN TOTAL ===
        $totalRealizedYear = InvestmentRealization::where('year', $selectedYear)->sum('realized_amount');
        $totalLaborYear = InvestmentRealization::where('year', $selectedYear)->sum('labor_absorbed');
        $totalTarget = $target?->target_amount ?? 0;

        $capaianOverall = $totalTarget > 0
            ? round(($totalRealizedYear / $totalTarget) * 100, 2)
            : 0;

        // === BREAKDOWN PMA ===
        $pmaRealized = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMA')->sum('realized_amount');

        $pmaLabor = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMA')->sum('labor_absorbed');

        $pmaCapaian = $totalTarget > 0
            ? round(($pmaRealized / $totalTarget) * 100, 2)
            : 0;

        // === BREAKDOWN PMDN ===
        $pmdnRealized = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMDN')->sum('realized_amount');

        $pmdnLabor = InvestmentRealization::where('year', $selectedYear)
            ->where('type', 'PMDN')->sum('labor_absorbed');

        $pmdnCapaian = $totalTarget > 0
            ? round(($pmdnRealized / $totalTarget) * 100, 2)
            : 0;

        // === CHART DATA (per tahun) ===
        $chartDataRaw = InvestmentRealization::selectRaw('
                year,
                SUM(realized_amount) as total_realized
            ')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $chartData = [
            'years' => $chartDataRaw->pluck('year'),
            'target' => $chartDataRaw->pluck('year')->map(fn($y) => InvestmentTarget::where('year', $y)->value('target_amount') ?? 0),
            'realized' => $chartDataRaw->pluck('total_realized'),
        ];

        // === DONUT TARGET VS REALISASI ===
        $donutTargetRealized = [
            'target' => $totalTarget,
            'realized' => $totalRealizedYear,
        ];

        // === DONUT PMA vs PMDN ===
        $totalAll = $pmaRealized + $pmdnRealized;
        $pmaPercent = $totalAll > 0 ? round(($pmaRealized / $totalAll) * 100, 1) : 50;
        $pmdnPercent = $totalAll > 0 ? round(($pmdnRealized / $totalAll) * 100, 1) : 50;

        $donutPmaPmdn = [
            'pma_percent' => $pmaPercent,
            'pmdn_percent' => $pmdnPercent,
        ];

        // Statistik Tambahan
        $totalNews = News::count();
        $totalGallery = Gallery::count();
        $totalVideo = Video::count();

        $populasiPerTahun = Populasi::selectRaw('year, SUM(amount) as total_amount')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return view('backend.index', compact(
            'layananUtama',
            'layananPerizinan',
            'realizations',
            'target',
            'selectedYear',
            'availableYears',
            'chartData',
            'donutTargetRealized',
            'donutPmaPmdn',
            'totalRealizedYear',
            'totalLaborYear',
            'totalTarget',
            'capaianOverall',
            'pmaRealized',
            'pmaLabor',
            'pmaCapaian',
            'pmdnRealized',
            'pmdnLabor',
            'pmdnCapaian',
            'totalNews',
            'totalGallery',
            'totalVideo',
            'populasiPerTahun'
        ));
    }
}