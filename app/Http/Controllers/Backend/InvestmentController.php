<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InvestmentTarget;
use App\Models\InvestmentRealization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = date('Y');

        $years = InvestmentRealization::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->get('year') ?? $years->first() ?? $currentYear;

        // Ambil data realisasi
        $data = InvestmentRealization::where('year', $selectedYear)
            ->orderBy('quarter')
            ->orderBy('type')
            ->get();

        // Load target secara manual (ini yang paling penting)
        $data->each(function ($realization) {
            $realization->target = InvestmentTarget::where('year', $realization->year)
                ->where('quarter', $realization->quarter)
                ->where('type', $realization->type)
                ->first();
        });

        return view('backend.investment.index', compact('data', 'years', 'selectedYear', 'currentYear'));
    }

    /**
     * Show the form for creating a new resource
     */
    // CREATE (tetap sama, tapi pastikan helper ada)
    public function create()
    {
        $data = $this->prepareFormData();

        return view('backend.investment.create', compact('data'));
    }

    public function edit($year)
    {
        $targets = InvestmentTarget::where('year', $year)->get();
        $realizations = InvestmentRealization::where('year', $year)->get();

        $data = $this->prepareFormData($targets, $realizations);

        return view('backend.investment.edit', compact('year', 'data'));
    }

    /**
     * Store a newly created resource in storage. (Hanya untuk Create)
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'data.*.quarter' => 'required|integer|between:1,4',
            'data.*.type' => 'required|in:PMA,PMDN',
            'data.*.target_amount' => 'required|numeric|min:0',
            'data.*.realized_amount' => 'required|numeric|min:0',
            'data.*.labor_absorbed' => 'required|integer|min:0',
        ]);

        // Bersihkan titik ribuan dari input currency
        if ($request->has('data') && is_array($request->data)) {
            foreach ($request->data as $key => $item) {
                if (isset($item['target_amount'])) {
                    $request->merge(["data.{$key}.target_amount" => str_replace('.', '', $item['target_amount'])]);
                }
                if (isset($item['realized_amount'])) {
                    $request->merge(["data.{$key}.realized_amount" => str_replace('.', '', $item['realized_amount'])]);
                }
            }
        }

        $year = $request->year;

        // Cek apakah tahun sudah ada (Hanya untuk Create)
        $existing = InvestmentRealization::where('year', $year)->exists();

        if ($existing) {
            return redirect()
                ->route('backend.investment.edit', $year)
                ->with('warning', 'Data untuk tahun ' . $year . ' sudah ada. Silakan edit data yang ada.');
        }

        try {
            DB::beginTransaction();

            foreach ($request->data as $item) {
                InvestmentTarget::updateOrCreate(
                    ['year' => $year, 'quarter' => $item['quarter'], 'type' => $item['type']],
                    ['target_amount' => $item['target_amount']]
                );

                InvestmentRealization::updateOrCreate(
                    ['year' => $year, 'quarter' => $item['quarter'], 'type' => $item['type']],
                    [
                        'realized_amount' => $item['realized_amount'],
                        'labor_absorbed' => $item['labor_absorbed'],
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('backend.investment.index', ['year' => $year])
                ->with('success', 'Data realisasi investasi tahun ' . $year . ' berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $year)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'data.*.quarter' => 'required|integer|between:1,4',
            'data.*.type' => 'required|in:PMA,PMDN',
            'data.*.target_amount' => 'required|numeric|min:0',
            'data.*.realized_amount' => 'required|numeric|min:0',
            'data.*.labor_absorbed' => 'required|integer|min:0',
        ]);

        // Bersihkan titik ribuan (sama seperti store)
        if ($request->has('data') && is_array($request->data)) {
            foreach ($request->data as $key => $item) {
                if (isset($item['target_amount'])) {
                    $request->merge(["data.{$key}.target_amount" => str_replace('.', '', $item['target_amount'])]);
                }
                if (isset($item['realized_amount'])) {
                    $request->merge(["data.{$key}.realized_amount" => str_replace('.', '', $item['realized_amount'])]);
                }
            }
        }

        $year = $request->year;   // gunakan year dari form (bisa diubah)

        try {
            DB::beginTransaction();

            foreach ($request->data as $item) {
                InvestmentTarget::updateOrCreate(
                    ['year' => $year, 'quarter' => $item['quarter'], 'type' => $item['type']],
                    ['target_amount' => $item['target_amount']]
                );

                InvestmentRealization::updateOrCreate(
                    ['year' => $year, 'quarter' => $item['quarter'], 'type' => $item['type']],
                    [
                        'realized_amount' => $item['realized_amount'],
                        'labor_absorbed' => $item['labor_absorbed'],
                    ]
                );
            }

            DB::commit();

            return redirect()
                ->route('backend.investment.index', ['year' => $year])
                ->with('success', 'Data realisasi investasi tahun ' . $year . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($year)
    {
        try {
            DB::beginTransaction();

            InvestmentTarget::where('year', $year)->delete();
            InvestmentRealization::where('year', $year)->delete();

            DB::commit();

            return redirect()
                ->route('backend.investment.index')
                ->with('success', 'Data tahun ' . $year . ' berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Helper untuk menyiapkan data form (8 baris: 4 triwulan x 2 jenis)
     */
    private function prepareFormData($targets = null, $realizations = null)
    {
        $data = [];
        $quarters = [1, 2, 3, 4];
        $types = ['PMA', 'PMDN'];

        foreach ($quarters as $q) {
            foreach ($types as $t) {
                $target = $targets?->where('quarter', $q)->where('type', $t)->first();
                $real = $realizations?->where('quarter', $q)->where('type', $t)->first();

                $data[] = [
                    'quarter' => $q,
                    'type' => $t,
                    'target_amount' => $target?->target_amount ?? 0,
                    'realized_amount' => $real?->realized_amount ?? 0,
                    'labor_absorbed' => $real?->labor_absorbed ?? 0,
                ];
            }
        }

        return $data;
    }
}
