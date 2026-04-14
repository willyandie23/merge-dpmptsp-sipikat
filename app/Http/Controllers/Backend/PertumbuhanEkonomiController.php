<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PertumbuhanEkonomi;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="PertumbuhanEkonomi",
 *     type="object",
 *     title="Pertumbuhan Ekonomi",
 *     description="Model Data Pertumbuhan Ekonomi per Tahun",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="year", type="integer", example=2025),
 *     @OA\Property(property="amount", type="number", format="float", example=5.8),
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
class PertumbuhanEkonomiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/pertumbuhan-ekonomi",
     *     tags={"Pertumbuhan Ekonomi"},
     *     summary="Get list of pertumbuhan ekonomi",
     *     description="Retrieve all pertumbuhan ekonomi data with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PertumbuhanEkonomi")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $pertumbuhans = PertumbuhanEkonomi::latest('year')
            ->paginate(10);

        return view('backend.pertumbuhan-ekonomi.index', compact('pertumbuhans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pertumbuhan-ekonomi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/pertumbuhan-ekonomi",
     *     tags={"Pertumbuhan Ekonomi"},
     *     summary="Create new pertumbuhan ekonomi data",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","amount"},
     *             @OA\Property(property="year", type="integer", example=2025),
     *             @OA\Property(property="amount", type="number", format="float", example=5.8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pertumbuhan ekonomi created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PertumbuhanEkonomi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:pertumbuhan_ekonomi,year',
            'amount' => 'required|numeric|min:0|max:100',
        ], [
            'year.unique' => 'Data pertumbuhan ekonomi untuk tahun ini sudah ada.'
        ]);

        PertumbuhanEkonomi::create($validated);

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        return view('backend.pertumbuhan-ekonomi.edit', compact('pertumbuhan_ekonomi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/pertumbuhan-ekonomi/{pertumbuhan_ekonomi}",
     *     tags={"Pertumbuhan Ekonomi"},
     *     summary="Update existing pertumbuhan ekonomi data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pertumbuhan_ekonomi",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","amount"},
     *             @OA\Property(property="year", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pertumbuhan ekonomi updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PertumbuhanEkonomi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:pertumbuhan_ekonomi,year,' . $pertumbuhan_ekonomi->id,
            'amount' => 'required|numeric|min:0|max:100',
        ], [
            'year.unique' => 'Data pertumbuhan ekonomi untuk tahun ini sudah ada.'
        ]);

        $pertumbuhan_ekonomi->update($validated);

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/pertumbuhan-ekonomi/{pertumbuhan_ekonomi}",
     *     tags={"Pertumbuhan Ekonomi"},
     *     summary="Delete pertumbuhan ekonomi data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pertumbuhan_ekonomi",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Pertumbuhan ekonomi deleted successfully")
     * )
     */
    public function destroy(PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        $pertumbuhan_ekonomi->delete();

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil dihapus!');
    }
}