<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MekanismePengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="MekanismePengaduan",
 *     type="object",
 *     title="Mekanisme Pengaduan",
 *     description="Model Mekanisme Pengaduan untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Pengaduan Layanan Perizinan"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         example="Prosedur pengaduan pelayanan terpadu satu pintu"
 *     ),
 *     @OA\Property(property="image", type="string", example="mekanisme-pengaduan/abc123.jpg"),
 *     @OA\Property(property="url", type="string", format="url", nullable=true, example="https://example.com/pengaduan"),
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
class MekanismePengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/mekanisme-pengaduan",
     *     tags={"Mekanisme Pengaduan"},
     *     summary="Get list of mekanisme pengaduan",
     *     description="Retrieve all mekanisme pengaduan ordered by position",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MekanismePengaduan")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $mekanisme = MekanismePengaduan::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.mekanisme-pengaduan.index', compact('mekanisme'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usedPositions = MekanismePengaduan::select('id', 'name', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.mekanisme-pengaduan.create', compact('usedPositions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/mekanisme-pengaduan",
     *     tags={"Mekanisme Pengaduan"},
     *     summary="Create new mekanisme pengaduan",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","position"},
     *                 @OA\Property(property="name", type="string", example="Pengaduan Layanan Perizinan"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="url", type="string", format="url", nullable=true),
     *                 @OA\Property(property="position", type="integer", example=3),
     *                 @OA\Property(property="is_active", type="boolean", default=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mekanisme pengaduan created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MekanismePengaduan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'position' => 'required|integer|min:1|unique:mekanisme_pengaduan,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan. Silakan pilih nomor urutan yang lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('mekanisme-pengaduan', $filename, 'public');
        }

        MekanismePengaduan::create($validated);

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MekanismePengaduan $mekanisme_pengaduan)
    {
        $usedPositions = MekanismePengaduan::select('id', 'name', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.mekanisme-pengaduan.edit', compact('mekanisme_pengaduan', 'usedPositions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/mekanisme-pengaduan/{mekanisme_pengaduan}",
     *     tags={"Mekanisme Pengaduan"},
     *     summary="Update existing mekanisme pengaduan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="mekanisme_pengaduan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="url", type="string", format="url", nullable=true),
     *                 @OA\Property(property="position", type="integer"),
     *                 @OA\Property(property="is_active", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mekanisme pengaduan updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MekanismePengaduan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, MekanismePengaduan $mekanisme_pengaduan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'position' => 'required|integer|min:1|unique:mekanisme_pengaduan,position,' . $mekanisme_pengaduan->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh mekanisme lain. Silakan pilih nomor yang berbeda.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($mekanisme_pengaduan->image) {
                Storage::disk('public')->delete($mekanisme_pengaduan->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('mekanisme-pengaduan', $filename, 'public');
        }

        $mekanisme_pengaduan->update($validated);

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/mekanisme-pengaduan/{mekanisme_pengaduan}",
     *     tags={"Mekanisme Pengaduan"},
     *     summary="Delete a mekanisme pengaduan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="mekanisme_pengaduan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Mekanisme pengaduan deleted successfully")
     * )
     */
    public function destroy(MekanismePengaduan $mekanisme_pengaduan)
    {
        $mekanisme_pengaduan->delete();

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil dihapus!');
    }
}