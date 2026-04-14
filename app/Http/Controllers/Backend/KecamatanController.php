<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Populasi;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Populasi",
 *     type="object",
 *     title="Populasi",
 *     description="Data populasi per kecamatan per tahun",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="kecamatan_id", type="integer", example=5),
 *     @OA\Property(property="year", type="integer", example=2025),
 *     @OA\Property(property="amount", type="integer", example=85000),
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
 *     schema="Kecamatan",
 *     type="object",
 *     title="Kecamatan",
 *     description="Data Kecamatan beserta populasi",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Kecamatan Katingan Hulu"),
 *     @OA\Property(
 *         property="populasi",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Populasi")
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
class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/kecamatan",
     *     tags={"Kecamatan"},
     *     summary="Get list of kecamatan with population data",
     *     description="Retrieve all kecamatan with their population data (eager loading)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Kecamatan")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $kecamatans = Kecamatan::with('populasi')
            ->latest('id')
            ->paginate(10);

        return view('backend.kecamatan.index', compact('kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/kecamatan",
     *     tags={"Kecamatan"},
     *     summary="Create new kecamatan with population data",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","populasi"},
     *             @OA\Property(property="name", type="string", example="Kecamatan Katingan Hulu"),
     *             @OA\Property(
     *                 property="populasi",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"year","amount"},
     *                     @OA\Property(property="year", type="integer", example=2025),
     *                     @OA\Property(property="amount", type="integer", example=85000)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kecamatan created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Kecamatan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kecamatan,name',
            'populasi.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'populasi.*.amount' => 'required|integer|min:0',
        ]);

        $kecamatan = Kecamatan::create(['name' => $validated['name']]);

        foreach ($validated['populasi'] as $p) {
            Populasi::create([
                'kecamatan_id' => $kecamatan->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan + data populasi berhasil disimpan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kecamatan $kecamatan)
    {
        $kecamatan->load('populasi');
        return view('backend.kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/kecamatan/{kecamatan}",
     *     tags={"Kecamatan"},
     *     summary="Update kecamatan and its population data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="kecamatan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","populasi"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(
     *                 property="populasi",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"year","amount"},
     *                     @OA\Property(property="year", type="integer"),
     *                     @OA\Property(property="amount", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kecamatan updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Kecamatan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kecamatan,name,' . $kecamatan->id,
            'populasi.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'populasi.*.amount' => 'required|integer|min:0',
        ]);

        $kecamatan->update(['name' => $validated['name']]);

        // Hapus populasi lama, simpan yang baru
        $kecamatan->populasi()->delete();
        foreach ($validated['populasi'] as $p) {
            Populasi::create([
                'kecamatan_id' => $kecamatan->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan dan data populasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/kecamatan/{kecamatan}",
     *     tags={"Kecamatan"},
     *     summary="Delete a kecamatan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="kecamatan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Kecamatan deleted successfully")
     * )
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();
        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan berhasil dihapus!');
    }
}