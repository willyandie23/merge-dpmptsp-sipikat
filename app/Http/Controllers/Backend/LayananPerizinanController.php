<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LayananPerizinan;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="LayananPerizinan",
 *     type="object",
 *     title="Layanan Perizinan",
 *     description="Model Layanan Perizinan Usaha untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Izin Usaha Mikro Kecil"),
 *     @OA\Property(property="icon", type="string", example="fas fa-file-alt"),
 *     @OA\Property(property="link", type="string", nullable=true, example="https://example.com/izin-usaha"),
 *     @OA\Property(property="position", type="integer", example=1),
 *     @OA\Property(property="is_active", type="boolean", example=true),
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
class LayananPerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/layanan-perizinan",
     *     tags={"Layanan Perizinan"},
     *     summary="Get list of layanan perizinan",
     *     description="Retrieve all layanan perizinan ordered by position",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/LayananPerizinan")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $layanan = LayananPerizinan::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.layanan-perizinan.index', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentCount = LayananPerizinan::count();   // untuk batas maksimal 3
        $usedPositions = LayananPerizinan::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-perizinan.create', compact('usedPositions', 'currentCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayananPerizinan $layanan_perizinan)
    {
        $currentCount = LayananPerizinan::count();
        $usedPositions = LayananPerizinan::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-perizinan.edit', compact('layanan_perizinan', 'usedPositions', 'currentCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/layanan-perizinan",
     *     tags={"Layanan Perizinan"},
     *     summary="Create new layanan perizinan",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","icon","position"},
     *             @OA\Property(property="title", type="string", example="Izin Usaha Mikro Kecil"),
     *             @OA\Property(property="icon", type="string", example="fas fa-file-alt"),
     *             @OA\Property(property="link", type="string", nullable=true, example="https://example.com/izin-usaha"),
     *             @OA\Property(property="position", type="integer", example=5),
     *             @OA\Property(property="is_active", type="boolean", default=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Layanan perizinan created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LayananPerizinan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        // ==================== KONDISI MAX 3 DATA ====================
        if (LayananPerizinan::count() >= 3) {
            return redirect()->route('backend.layanan-perizinan.create')
                ->with('error', 'Maksimal hanya boleh 3 Layanan Perizinan Usaha. Tidak dapat menambahkan lagi.')
                ->withInput();
        }
        // ============================================================

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'link' => 'nullable|url|max:255',
            'position' => 'required|integer|min:1|unique:layanan_perizinan,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        LayananPerizinan::create($validated);

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/layanan-perizinan/{layanan_perizinan}",
     *     tags={"Layanan Perizinan"},
     *     summary="Update existing layanan perizinan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="layanan_perizinan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="icon", type="string"),
     *             @OA\Property(property="link", type="string", nullable=true),
     *             @OA\Property(property="position", type="integer"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Layanan perizinan updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LayananPerizinan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, LayananPerizinan $layanan_perizinan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'link' => 'nullable|url|max:255',
            'position' => 'required|integer|min:1|unique:layanan_perizinan,position,' . $layanan_perizinan->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $layanan_perizinan->update($validated);

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/layanan-perizinan/{layanan_perizinan}",
     *     tags={"Layanan Perizinan"},
     *     summary="Delete a layanan perizinan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="layanan_perizinan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Layanan perizinan deleted successfully")
     * )
     */
    public function destroy(LayananPerizinan $layanan_perizinan)
    {
        $layanan_perizinan->delete();

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil dihapus!');
    }
}