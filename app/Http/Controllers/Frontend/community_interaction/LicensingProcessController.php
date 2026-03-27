<?php

namespace App\Http\Controllers\Frontend\community_interaction;

use App\Http\Controllers\Controller;
use App\Models\PerizinanTerbit;
use Illuminate\Http\Request;

class LicensingProcessController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua tahun yang tersedia
        $years = PerizinanTerbit::select('year')
                                ->distinct()
                                ->orderBy('year', 'desc')
                                ->pluck('year');

        $selectedYear = $request->get('year') ?? $years->first();

        if (!$selectedYear || $years->isEmpty()) {
            return view('frontend.community-interaction.licensing-process.index', [
                'years' => $years,
                'selectedYear' => null,
                'message' => 'Data perizinan belum tersedia.'
            ]);
        }

        // Ambil semua data di tahun yang dipilih
        $data = PerizinanTerbit::where('year', $selectedYear)
                               ->orderBy('month')
                               ->get();

        // Total keseluruhan untuk 3 card atas
        $total_oss_rba     = $data->sum('oss_rba');
        $total_sicantik    = $data->sum('sicantik_cloud');
        $total_simbg       = $data->sum('simbg');

        // Data per triwulan untuk bar chart
        $quarters = [
            'TW I'  => ['oss' => 0, 'sicantik' => 0, 'simbg' => 0],
            'TW II' => ['oss' => 0, 'sicantik' => 0, 'simbg' => 0],
            'TW III'=> ['oss' => 0, 'sicantik' => 0, 'simbg' => 0],
            'TW IV' => ['oss' => 0, 'sicantik' => 0, 'simbg' => 0],
        ];

        foreach ($data as $row) {
            $tw = match(true) {
                $row->month <= 3  => 'TW I',
                $row->month <= 6  => 'TW II',
                $row->month <= 9  => 'TW III',
                default           => 'TW IV',
            };

            $quarters[$tw]['oss']      += $row->oss_rba;
            $quarters[$tw]['sicantik'] += $row->sicantik_cloud;
            $quarters[$tw]['simbg']    += $row->simbg;
        }

        $chartLabels   = array_keys($quarters);
        $chartOSS      = array_column($quarters, 'oss');
        $chartSicantik = array_column($quarters, 'sicantik');
        $chartSIMBG    = array_column($quarters, 'simbg');

        // === LOGIKA PERIODE DINAMIS (sama persis seperti di Survey) ===
        $maxMonth = $data->max('month') ?? 0;
        $bulanNames = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        if ($maxMonth == 1) {
            $periode = "Januari " . $selectedYear;
        } else {
            $periode = "Januari – " . $bulanNames[$maxMonth] . " " . $selectedYear;
        }

        return view('frontend.community-interaction.licensing-process.index', compact(
            'years',
            'selectedYear',
            'periode',
            'total_oss_rba',
            'total_sicantik',
            'total_simbg',
            'chartLabels',
            'chartOSS',
            'chartSicantik',
            'chartSIMBG'
        ));
    }
}