<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Bidang",
 *     type="object",
 *     title="Bidang",
 *     description="Model Bidang / Unit Kerja untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Bidang Penanaman Modal"),
 *     @OA\Property(property="position", type="integer", example=1),
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
class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/bidang",
     *     tags={"Bidang"},
     *     summary="Get list of bidang",
     *     description="Retrieve all bidang with pagination and ordered by position",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Bidang")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $bidangs = Bidang::orderBy('position')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usedPositions = Bidang::select('id', 'name as title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.bidang.create', compact('usedPositions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/bidang",
     *     tags={"Bidang"},
     *     summary="Create new bidang",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","position"},
     *             @OA\Property(property="name", type="string", example="Bidang Penanaman Modal"),
     *             @OA\Property(property="position", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bidang created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Bidang")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name',
            'position' => 'required|integer|min:1|unique:bidang,position',
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.',
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh bidang lain.'
        ]);

        Bidang::create($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $usedPositions = Bidang::select('id', 'name as title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.bidang.edit', compact('bidang', 'usedPositions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/bidang/{bidang}",
     *     tags={"Bidang"},
     *     summary="Update existing bidang",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="bidang",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="position", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bidang updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Bidang")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name,' . $bidang->id,
            'position' => 'required|integer|min:1|unique:bidang,position,' . $bidang->id,
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.',
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh bidang lain.'
        ]);

        $bidang->update($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/bidang/{bidang}",
     *     tags={"Bidang"},
     *     summary="Delete a bidang and its related struktur organisasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="bidang",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Bidang deleted successfully")
     * )
     */
    public function destroy(Bidang $bidang)
    {
        try {
            // Hapus semua struktur organisasi yang terkait dengan bidang ini
            $bidang->strukturOrganisasi()->delete();

            // Baru hapus bidangnya
            $bidang->delete();

            return redirect()
                ->route('backend.bidang.index')
                ->with('success', 'Bidang beserta semua struktur organisasinya berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('backend.bidang.index')
                ->with('error', 'Terjadi kesalahan saat menghapus bidang: ' . $e->getMessage());
        }
    }
}