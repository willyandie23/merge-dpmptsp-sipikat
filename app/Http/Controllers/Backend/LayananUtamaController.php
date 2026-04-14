<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LayananUtama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="LayananUtama",
 *     type="object",
 *     title="Layanan Utama",
 *     description="Model Layanan Utama untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Pelayanan Perizinan Terpadu"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         example="Layanan utama DPMPTSP Kabupaten Katingan"
 *     ),
 *     @OA\Property(property="image", type="string", example="layanan_utama/abc123.jpg"),
 *     @OA\Property(property="icon", type="string", nullable=true),
 *     @OA\Property(property="link", type="string", nullable=true, example="https://example.com"),
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
class LayananUtamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/layanan-utama",
     *     tags={"Layanan Utama"},
     *     summary="Get list of layanan utama",
     *     description="Retrieve all layanan utama ordered by position",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/LayananUtama")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $layanan = LayananUtama::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.layanan-utama.index', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentCount = LayananUtama::count();           // jumlah data saat ini
        $usedPositions = LayananUtama::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-utama.create', compact('usedPositions', 'currentCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayananUtama $layanan_utama)
    {
        $currentCount = LayananUtama::count();
        $usedPositions = LayananUtama::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-utama.edit', compact('layanan_utama', 'usedPositions', 'currentCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/layanan-utama",
     *     tags={"Layanan Utama"},
     *     summary="Create new layanan utama",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","position"},
     *                 @OA\Property(property="title", type="string", example="Pelayanan Perizinan Terpadu"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="link", type="string", nullable=true, example="https://example.com"),
     *                 @OA\Property(property="position", type="integer", example=3),
     *                 @OA\Property(property="is_active", type="boolean", default=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Layanan utama created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LayananUtama")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        // ==================== KONDISI MAX 3 DATA ====================
        if (LayananUtama::count() >= 3) {
            return redirect()->route('backend.layanan-utama.create')
                ->with('error', 'Maksimal hanya boleh 3 Layanan Utama. Tidak dapat menambahkan lagi.')
                ->withInput();
        }
        // ============================================================

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url|max:255',           // tambahan link
            'position' => 'required|integer|min:1|unique:layanan_utama,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('layanan_utama', $filename, 'public');
        }

        LayananUtama::create($validated);

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/layanan-utama/{layanan_utama}",
     *     tags={"Layanan Utama"},
     *     summary="Update existing layanan utama",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="layanan_utama",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="link", type="string", nullable=true),
     *                 @OA\Property(property="position", type="integer"),
     *                 @OA\Property(property="is_active", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Layanan utama updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LayananUtama")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, LayananUtama $layanan_utama)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url|max:255',           // tambahan link
            'position' => 'required|integer|min:1|unique:layanan_utama,position,' . $layanan_utama->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($layanan_utama->image) {
                Storage::disk('public')->delete($layanan_utama->image);
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('layanan_utama', $filename, 'public');
        }

        $layanan_utama->update($validated);

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/layanan-utama/{layanan_utama}",
     *     tags={"Layanan Utama"},
     *     summary="Delete a layanan utama",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="layanan_utama",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Layanan utama deleted successfully")
     * )
     */
    public function destroy(LayananUtama $layanan_utama)
    {
        if ($layanan_utama->image) {
            Storage::disk('public')->delete($layanan_utama->image);
        }

        $layanan_utama->delete();

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil dihapus!');
    }
}