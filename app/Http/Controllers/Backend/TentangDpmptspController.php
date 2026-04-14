<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TentangDpmptsp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="TentangDpmptsp",
 *     type="object",
 *     title="Tentang DPMPTSP",
 *     description="Data profil dan informasi tentang DPMPTSP Kabupaten Katingan (single record)",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="image", type="string", nullable=true, example="tentang-dpmptsp/abc123.jpg"),
 *     @OA\Property(property="dasar_hukum", type="string", nullable=true),
 *     @OA\Property(property="moto_layanan", type="string", nullable=true),
 *     @OA\Property(property="visi", type="string", nullable=true),
 *     @OA\Property(property="misi", type="string", nullable=true),
 *     @OA\Property(property="maklumat_layanan", type="string", nullable=true),
 *     @OA\Property(property="waktu_layanan", type="string", nullable=true),
 *     @OA\Property(property="alamat", type="string", nullable=true),
 *     @OA\Property(property="struktur_organisasi", type="string", nullable=true),
 *     @OA\Property(property="sasaran_layanan", type="string", nullable=true),
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
class TentangDpmptspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/tentang-dpmptsp",
     *     tags={"Tentang DPMPTSP"},
     *     summary="Get tentang DPMPTSP profile",
     *     description="Retrieve the single record of Tentang DPMPTSP (profil organisasi)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TentangDpmptsp")
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $tentang = TentangDpmptsp::first();

        if (!$tentang) {
            $tentang = TentangDpmptsp::create([]); // buat record kosong jika belum ada
        }

        return view('backend.tentang-dpmptsp.index', compact('tentang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tentang = TentangDpmptsp::firstOrCreate([]);

        return view('backend.tentang-dpmptsp.edit', compact('tentang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/tentang-dpmptsp/{tentang_dpmptsp}",
     *     tags={"Tentang DPMPTSP"},
     *     summary="Update Tentang DPMPTSP profile",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="tentang_dpmptsp",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="dasar_hukum", type="string", nullable=true),
     *                 @OA\Property(property="moto_layanan", type="string", nullable=true),
     *                 @OA\Property(property="visi", type="string", nullable=true),
     *                 @OA\Property(property="misi", type="string", nullable=true),
     *                 @OA\Property(property="maklumat_layanan", type="string", nullable=true),
     *                 @OA\Property(property="waktu_layanan", type="string", nullable=true),
     *                 @OA\Property(property="alamat", type="string", nullable=true),
     *                 @OA\Property(property="struktur_organisasi", type="string", nullable=true),
     *                 @OA\Property(property="sasaran_layanan", type="string", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tentang DPMPTSP updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TentangDpmptsp")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, TentangDpmptsp $tentang_dpmptsp)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dasar_hukum' => 'nullable|string',
            'moto_layanan' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'maklumat_layanan' => 'nullable|string',
            'waktu_layanan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'sasaran_layanan' => 'nullable|string',
        ]);

        // Handle Upload Image
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($tentang_dpmptsp->image) {
                Storage::disk('public')->delete($tentang_dpmptsp->image);
            }
            $validated['image'] = $request->file('image')->store('tentang-dpmptsp', 'public');
        }

        $tentang_dpmptsp->update($validated);

        return redirect()
            ->route('backend.tentang-dpmptsp.index')
            ->with('success', 'Data Tentang DPMPTSP berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/tentang-dpmptsp/{tentang_dpmptsp}",
     *     tags={"Tentang DPMPTSP"},
     *     summary="Delete Tentang DPMPTSP data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="tentang_dpmptsp",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Tentang DPMPTSP deleted successfully")
     * )
     */
    public function destroy(TentangDpmptsp $tentang_dpmptsp)
    {
        if ($tentang_dpmptsp->image) {
            Storage::disk('public')->delete($tentang_dpmptsp->image);
        }

        $tentang_dpmptsp->delete();

        return redirect()
            ->route('backend.tentang-dpmptsp.index')
            ->with('success', 'Data Tentang DPMPTSP berhasil dihapus!');
    }
}