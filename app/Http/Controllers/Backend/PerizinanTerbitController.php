<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PerizinanTerbit;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PerizinanTerbit",
 *     type="object",
 *     title="Perizinan Terbit",
 *     description="Model Data Perizinan Terbit per Triwulan",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="year", type="integer", example=2026),
 *     @OA\Property(property="triwulan", type="integer", example=1),
 *     @OA\Property(property="oss_rba", type="integer", example=45),
 *     @OA\Property(property="sicantik_cloud", type="integer", example=32),
 *     @OA\Property(property="simbg", type="integer", example=18),
 *     @OA\Property(property="total_terbit", type="integer", example=95),
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
class PerizinanTerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/perizinan-terbit",
     *     tags={"Perizinan Terbit"},
     *     summary="Get list of perizinan terbit",
     *     description="Retrieve all perizinan terbit data grouped by year and triwulan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PerizinanTerbit")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $perizinans = PerizinanTerbit::orderBy('year', 'desc')
            ->orderBy('triwulan', 'asc')
            ->get();

        $availableYears = $perizinans->pluck('year')
            ->unique()
            ->sortDesc()
            ->values();

        // Grouping untuk JavaScript (key triwulan)
        $grouped = [];
        foreach ($perizinans as $item) {
            $grouped[$item->year][$item->triwulan] = $item->toArray();
        }

        return view('backend.perizinan-terbit.index', compact('availableYears', 'grouped'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.perizinan-terbit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/perizinan-terbit",
     *     tags={"Perizinan Terbit"},
     *     summary="Create new perizinan terbit data",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","triwulan","oss_rba","sicantik_cloud","simbg"},
     *             @OA\Property(property="year", type="integer", example=2026),
     *             @OA\Property(property="triwulan", type="integer", example=1),
     *             @OA\Property(property="oss_rba", type="integer", example=45),
     *             @OA\Property(property="sicantik_cloud", type="integer", example=32),
     *             @OA\Property(property="simbg", type="integer", example=18)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Perizinan terbit created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PerizinanTerbit")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'triwulan' => 'required|integer|between:1,4',
            'oss_rba' => 'required|integer|min:0',
            'sicantik_cloud' => 'required|integer|min:0',
            'simbg' => 'required|integer|min:0',
        ]);

        // Cek apakah data untuk tahun + triwulan ini sudah ada
        $exists = PerizinanTerbit::where('year', $validated['year'])
            ->where('triwulan', $validated['triwulan'])
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Data Perizinan Terbit untuk Tahun {$validated['year']} Triwulan {$validated['triwulan']} sudah ada. Silakan edit data yang sudah ada.");
        }

        $total_terbit = $validated['oss_rba'] + $validated['sicantik_cloud'] + $validated['simbg'];

        PerizinanTerbit::create([
            'year' => $validated['year'],
            'triwulan' => $validated['triwulan'],
            'oss_rba' => $validated['oss_rba'],
            'sicantik_cloud' => $validated['sicantik_cloud'],
            'simbg' => $validated['simbg'],
            'total_terbit' => $total_terbit,
        ]);

        return redirect()
            ->route('backend.perizinan-terbit.index')
            ->with('success', 'Data Perizinan Terbit berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerizinanTerbit $perizinan_terbit)
    {
        return view('backend.perizinan-terbit.edit', compact('perizinan_terbit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/perizinan-terbit/{perizinan_terbit}",
     *     tags={"Perizinan Terbit"},
     *     summary="Update existing perizinan terbit data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="perizinan_terbit",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"oss_rba","sicantik_cloud","simbg"},
     *             @OA\Property(property="oss_rba", type="integer", example=50),
     *             @OA\Property(property="sicantik_cloud", type="integer", example=35),
     *             @OA\Property(property="simbg", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Perizinan terbit updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PerizinanTerbit")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, PerizinanTerbit $perizinan_terbit)
    {
        $validated = $request->validate([
            'oss_rba' => 'required|integer|min:0',
            'sicantik_cloud' => 'required|integer|min:0',
            'simbg' => 'required|integer|min:0',
        ]);

        $total_terbit = $validated['oss_rba'] + $validated['sicantik_cloud'] + $validated['simbg'];

        $perizinan_terbit->update([
            'oss_rba' => $validated['oss_rba'],
            'sicantik_cloud' => $validated['sicantik_cloud'],
            'simbg' => $validated['simbg'],
            'total_terbit' => $total_terbit,
        ]);

        return redirect()
            ->route('backend.perizinan-terbit.index')
            ->with('success', 'Data Perizinan Terbit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/perizinan-terbit/{perizinan_terbit}",
     *     tags={"Perizinan Terbit"},
     *     summary="Delete perizinan terbit data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="perizinan_terbit",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Perizinan terbit deleted successfully"
     *     )
     * )
     */
    public function destroy(PerizinanTerbit $perizinan_terbit)
    {
        $perizinan_terbit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Perizinan Terbit berhasil dihapus.'
        ]);
    }
}