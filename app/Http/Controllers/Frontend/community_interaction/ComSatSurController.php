<?php

namespace App\Http\Controllers\Frontend\community_interaction;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class ComSatSurController extends Controller
{
    public function index(Request $request)
    {
        $years = Survey::select('year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year');

        $selectedYear = $request->get('year') ?? $years->first();

        if (!$selectedYear || $years->isEmpty()) {
            return view('frontend.community-interaction.community-satisfaction-survey.index', [
                'survey' => null,
                'message' => 'Data survey belum tersedia.',
                'years' => $years,
                'selectedYear' => null,
            ]);
        }

        // Ambil semua data di tahun yang dipilih
        $surveys = Survey::where('year', $selectedYear)
                        ->orderBy('month')
                        ->get();

        $maxMonth = $surveys->max('month');

        // Total responden kumulatif
        $total_laki = $surveys->sum('jumlah_laki');
        $total_perempuan = $surveys->sum('jumlah_perempuan');
        $total_responden = $total_laki + $total_perempuan;

        $persen_laki = $total_responden > 0 
            ? round(($total_laki / $total_responden) * 100, 2) : 0;
        $persen_perempuan = $total_responden > 0 
            ? round(($total_perempuan / $total_responden) * 100, 2) : 0;

        // Indikator rata-rata + grade
        $indikatorNames = [
            1 => 'Persyaratan',
            2 => 'Sistem, Mekanisme dan Prosedur',
            3 => 'Waktu Penyelesaian',
            4 => 'Biaya/Tarif',
            5 => 'Produk Spesifikasi Jenis Pelayanan',
            6 => 'Kompetensi Pelaksana',
            7 => 'Perilaku Pelaksana',
            8 => 'Penanganan Pengaduan, Saran dan Masukan',
            9 => 'Sarana dan Prasarana',
        ];

        $indikators = [];
        for ($i = 1; $i <= 9; $i++) {
            $avg = $surveys->avg("indikator{$i}") ?? 0;
            $gradeData = $this->getGrade($avg);

            $indikators[] = [
                'nama'       => $indikatorNames[$i],
                'nilai'      => round($avg, 2),
                'grade'      => $gradeData['grade'],
                'keterangan' => $gradeData['keterangan'],
            ];
        }

        $indeks_keseluruhan = round(collect($indikators)->avg('nilai'), 2);
        $grade = $this->getGrade($indeks_keseluruhan);
        $grade_text = $grade['grade'];
        $keterangan = $grade['keterangan'];

        // Logika periode (Januari saja atau Januari–Desember)
        $bulanNames = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        if ($maxMonth == 1) {
            $periode = "Januari " . $selectedYear;
        } else {
            $periode = "Januari – " . $bulanNames[$maxMonth] . " " . $selectedYear;
        }

        return view('frontend.community-interaction.community-satisfaction-survey.index',
            compact(
                'years',
                'selectedYear',
                'periode',
                'total_responden',
                'total_laki',
                'total_perempuan',
                'persen_laki',
                'persen_perempuan',
                'indikators',
                'indeks_keseluruhan',
                'grade_text',
                'keterangan'
            )
        );
    }

    private function getGrade($nilai)
    {
        if ($nilai >= 3.25) return ['grade' => 'A', 'keterangan' => 'Sangat Baik'];
        elseif ($nilai >= 2.60) return ['grade' => 'B', 'keterangan' => 'Baik'];
        elseif ($nilai >= 1.75) return ['grade' => 'C', 'keterangan' => 'Cukup Baik'];
        else return ['grade' => 'D', 'keterangan' => 'Kurang Baik'];
    }
}