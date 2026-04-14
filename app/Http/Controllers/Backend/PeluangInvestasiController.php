<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Sektor;
use App\Models\PeluangInvestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="PeluangInvestasi",
 *     type="object",
 *     title="Peluang Investasi",
 *     description="Model Peluang Investasi",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Investasi Pabrik Pengolahan Kopi"),
 *     @OA\Property(property="description", type="string", example="Deskripsi peluang investasi..."),
 *     @OA\Property(property="image", type="string", example="peluang-investasi/abc123.jpg"),
 *     @OA\Property(
 *         property="kecamatan",
 *         ref="#/components/schemas/Kecamatan"
 *     ),
 *     @OA\Property(
 *         property="sektor",
 *         ref="#/components/schemas/Sektor"
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
class PeluangInvestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/peluang-investasi",
     *     tags={"Peluang Investasi"},
     *     summary="Get list of peluang investasi",
     *     description="Retrieve all peluang investasi with kecamatan and sektor relation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PeluangInvestasi")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $peluangs = PeluangInvestasi::with(['kecamatan', 'sektor'])
            ->latest()
            ->paginate(10);

        return view('backend.peluang-investasi.index', compact('peluangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        $sektors = Sektor::orderBy('name')->get();   // Semua sektor (independent)

        return view('backend.peluang-investasi.create', compact('kecamatans', 'sektors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/peluang-investasi",
     *     tags={"Peluang Investasi"},
     *     summary="Create new peluang investasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"kecamatan_id","sektor_id","title","description","image"},
     *                 @OA\Property(property="kecamatan_id", type="integer", example=5),
     *                 @OA\Property(property="sektor_id", type="integer", example=3),
     *                 @OA\Property(property="title", type="string", example="Investasi Pabrik Pengolahan Kopi"),
     *                 @OA\Property(property="description", type="string", example="Deskripsi peluang investasi..."),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Peluang investasi created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PeluangInvestasi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'sektor_id' => 'required|exists:sektor,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('peluang-investasi', 'public');
            $validated['image'] = $imagePath;
        }

        PeluangInvestasi::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'id_kecamatan' => $validated['kecamatan_id'],
            'id_sektor' => $validated['sektor_id'],
        ]);

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeluangInvestasi $peluang_investasi)
    {
        $peluang_investasi->load('kecamatan', 'sektor');

        $kecamatans = Kecamatan::orderBy('name')->get();
        $sektors = Sektor::orderBy('name')->get();   // Semua sektor (independent)

        return view('backend.peluang-investasi.edit', compact('peluang_investasi', 'kecamatans', 'sektors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/peluang-investasi/{peluang_investasi}",
     *     tags={"Peluang Investasi"},
     *     summary="Update existing peluang investasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="peluang_investasi",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"kecamatan_id","sektor_id","title","description"},
     *                 @OA\Property(property="kecamatan_id", type="integer"),
     *                 @OA\Property(property="sektor_id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Peluang investasi updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PeluangInvestasi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, PeluangInvestasi $peluang_investasi)
    {
        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'sektor_id' => 'required|exists:sektor,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'id_kecamatan' => $validated['kecamatan_id'],
            'id_sektor' => $validated['sektor_id'],
        ];

        if ($request->hasFile('image')) {
            if ($peluang_investasi->image) {
                Storage::disk('public')->delete($peluang_investasi->image);
            }
            $imagePath = $request->file('image')->store('peluang-investasi', 'public');
            $data['image'] = $imagePath;
        }

        $peluang_investasi->update($data);

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/peluang-investasi/{peluang_investasi}",
     *     tags={"Peluang Investasi"},
     *     summary="Delete a peluang investasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="peluang_investasi",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Peluang investasi deleted successfully")
     * )
     */
    public function destroy(PeluangInvestasi $peluang_investasi)
    {
        if ($peluang_investasi->image) {
            Storage::disk('public')->delete($peluang_investasi->image);
        }

        $peluang_investasi->delete();

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil dihapus!');
    }
}