<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InvestmentTarget;
use App\Models\InvestmentRealization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="InvestmentTarget",
 *     type="object",
 *     title="Investment Target",
 *     description="Target investasi per tahun dan jenis (PMA/PMDN)",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="year", type="integer", example=2026),
 *     @OA\Property(property="type", type="string", enum={"PMA", "PMDN"}, example="PMA"),
 *     @OA\Property(property="target_amount", type="number", format="float", example=150000000000),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-13T10:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-13T10:00:00.000000Z"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="InvestmentRealization",
 *     type="object",
 *     title="Investment Realization",
 *     description="Realisasi investasi per triwulan dan jenis (PMA/PMDN)",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="year", type="integer", example=2026),
 *     @OA\Property(property="quarter", type="integer", example=1),
 *     @OA\Property(property="type", type="string", enum={"PMA", "PMDN"}, example="PMA"),
 *     @OA\Property(property="realized_amount", type="number", format="float", example=14250000000),
 *     @OA\Property(property="labor_absorbed", type="integer", example=245),
 *     @OA\Property(
 *         property="target",
 *         ref="#/components/schemas/InvestmentTarget",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-13T10:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-13T10:00:00.000000Z"
 *     )
 * )
 */
class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/investment",
     *     tags={"Investment"},
     *     summary="Get investment data (target & realization)",
     *     description="Retrieve investment realization and target data by year",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="Filter by year (optional)",
     *         required=false,
     *         @OA\Schema(type="integer", example=2026)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/InvestmentRealization")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index(Request $request)
    {
        $currentYear = date('Y');

        $years = InvestmentRealization::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->input('year') ?? $years->first() ?? $currentYear;   // diperbaiki (bukan ->get)

        // Ambil Target Tahunan (hanya 1 record)
        $target = InvestmentTarget::where('year', $selectedYear)->first();

        // Ambil Realisasi
        $realizations = InvestmentRealization::where('year', $selectedYear)
            ->orderBy('quarter')
            ->orderBy('type')
            ->get();

        // Attach target ke setiap realization
        $realizations->each(function ($realization) use ($target) {
            $realization->target = $target;
        });

        return view('backend.investment.index', compact(
            'target',
            'realizations',
            'years',
            'selectedYear',
            'currentYear'
        ));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $data = $this->prepareFormData();
        return view('backend.investment.create', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($year)
    {
        $target = InvestmentTarget::where('year', $year)->first();
        $realizations = InvestmentRealization::where('year', $year)->get();

        $data = $this->prepareFormData($target, $realizations);

        return view('backend.investment.edit', compact('year', 'data', 'target'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/investment",
     *     tags={"Investment"},
     *     summary="Create new investment data for a year",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","data"},
     *             @OA\Property(property="year", type="integer", example=2026),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="quarter", type="integer", example=1),
     *                     @OA\Property(property="type", type="string", enum={"PMA","PMDN"}, example="PMA"),
     *                     @OA\Property(property="target_amount", type="number", example=150000000000),
     *                     @OA\Property(property="realized_amount", type="number", example=14250000000),
     *                     @OA\Property(property="labor_absorbed", type="integer", example=245)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Investment data created successfully"
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'target_amount' => 'required|string|min:1',           // ubah jadi string dulu
            'data.*.quarter' => 'required|integer|between:1,4',
            'data.*.type' => 'required|in:PMA,PMDN',
            'data.*.realized_amount' => 'required|string|min:1',  // ubah jadi string
            'data.*.labor_absorbed' => 'required|integer|min:0',
        ]);

        // === CLEANING SETELAH VALIDASI ===
        $targetAmount = (int) str_replace(['.', ','], '', $request->target_amount);

        $data = [];
        foreach ($request->input('data') as $key => $item) {
            $data[$key] = [
                'quarter' => (int) $item['quarter'],
                'type' => $item['type'],
                'realized_amount' => (int) str_replace(['.', ','], '', $item['realized_amount'] ?? 0),
                'labor_absorbed' => (int) ($item['labor_absorbed'] ?? 0),
            ];
        }

        $year = (int) $request->year;

        if (InvestmentRealization::where('year', $year)->exists()) {
            return redirect()->route('backend.investment.edit', $year)
                ->with('warning', 'Data untuk tahun ' . $year . ' sudah ada.');
        }

        try {
            DB::beginTransaction();

            InvestmentTarget::updateOrCreate(
                ['year' => $year],
                ['target_amount' => $targetAmount]
            );

            foreach ($data as $item) {
                InvestmentRealization::updateOrCreate(
                    [
                        'year' => $year,
                        'quarter' => $item['quarter'],
                        'type' => $item['type']
                    ],
                    [
                        'realized_amount' => $item['realized_amount'],
                        'labor_absorbed' => $item['labor_absorbed'],
                    ]
                );
            }

            DB::commit();

            return redirect()->route('backend.investment.index', ['year' => $year])
                ->with('success', 'Data realisasi investasi tahun ' . $year . ' berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/investment/{year}",
     *     tags={"Investment"},
     *     summary="Update investment data for a specific year",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="year",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=2026)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","data"},
     *             @OA\Property(property="year", type="integer", example=2026),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="quarter", type="integer", example=1),
     *                     @OA\Property(property="type", type="string", enum={"PMA","PMDN"}, example="PMA"),
     *                     @OA\Property(property="target_amount", type="number", example=150000000000),
     *                     @OA\Property(property="realized_amount", type="number", example=14250000000),
     *                     @OA\Property(property="labor_absorbed", type="integer", example=245)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Investment data updated successfully"
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $year)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'target_amount' => 'required|string|min:1',
            'data.*.quarter' => 'required|integer|between:1,4',
            'data.*.type' => 'required|in:PMA,PMDN',
            'data.*.realized_amount' => 'required|string|min:1',
            'data.*.labor_absorbed' => 'required|integer|min:0',
        ]);

        $targetAmount = (int) str_replace(['.', ','], '', $request->target_amount);

        $data = [];
        foreach ($request->input('data') as $key => $item) {
            $data[$key] = [
                'quarter' => (int) $item['quarter'],
                'type' => $item['type'],
                'realized_amount' => (int) str_replace(['.', ','], '', $item['realized_amount'] ?? 0),
                'labor_absorbed' => (int) ($item['labor_absorbed'] ?? 0),
            ];
        }

        try {
            DB::beginTransaction();

            InvestmentTarget::updateOrCreate(
                ['year' => $year],
                ['target_amount' => $targetAmount]
            );

            foreach ($data as $item) {
                InvestmentRealization::updateOrCreate(
                    [
                        'year' => $year,
                        'quarter' => $item['quarter'],
                        'type' => $item['type']
                    ],
                    [
                        'realized_amount' => $item['realized_amount'],
                        'labor_absorbed' => $item['labor_absorbed'],
                    ]
                );
            }

            DB::commit();

            return redirect()->route('backend.investment.index', ['year' => $year])
                ->with('success', 'Data tahun ' . $year . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/investment/{year}",
     *     tags={"Investment"},
     *     summary="Delete all investment data for a specific year",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="year",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=2026)
     *     ),
     *     @OA\Response(response=204, description="Investment data deleted successfully")
     * )
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
     * Target sekarang hanya 1 nilai yang sama untuk semua baris
     */
    private function prepareFormData($target = null, $realizations = null)
    {
        $data = [];
        $quarters = [1, 2, 3, 4];
        $types = ['PMA', 'PMDN'];

        $targetAmount = $target?->target_amount ?? 0;

        foreach ($quarters as $q) {
            foreach ($types as $t) {
                $real = $realizations?->where('quarter', $q)->where('type', $t)->first();

                $data[] = [
                    'quarter' => $q,
                    'type' => $t,
                    'target_amount' => $targetAmount,
                    'realized_amount' => $real?->realized_amount ?? 0,
                    'labor_absorbed' => $real?->labor_absorbed ?? 0,
                ];
            }
        }

        return $data;
    }
}