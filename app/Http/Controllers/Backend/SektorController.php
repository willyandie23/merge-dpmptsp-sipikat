<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sektor;
use App\Models\ProdukDomestik;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="ProdukDomestik",
 *     type="object",
 *     title="Produk Domestik",
 *     description="Data Produk Domestik Bruto per sektor per tahun",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="sektor_id", type="integer", example=5),
 *     @OA\Property(property="year", type="integer", example=2025),
 *     @OA\Property(property="amount", type="number", format="float", example=12500000000),
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
 *     schema="Sektor",
 *     type="object",
 *     title="Sektor",
 *     description="Model Sektor beserta data Produk Domestik",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Pertanian"),
 *     @OA\Property(
 *         property="produkDomestik",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProdukDomestik")
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
class SektorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/sektor",
     *     tags={"Sektor"},
     *     summary="Get list of sektor with produk domestik",
     *     description="Retrieve all sektor with their produk domestik data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Sektor")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $sektors = Sektor::with('produkDomestik')
            ->latest()
            ->paginate(10);

        return view('backend.sektor.index', compact('sektors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.sektor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/sektor",
     *     tags={"Sektor"},
     *     summary="Create new sektor with produk domestik data",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","produk_domestik"},
     *             @OA\Property(property="name", type="string", example="Pertanian"),
     *             @OA\Property(
     *                 property="produk_domestik",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"year","amount"},
     *                     @OA\Property(property="year", type="integer", example=2025),
     *                     @OA\Property(property="amount", type="number", example=12500000000)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sektor created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Sektor")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        // Bersihkan format ribuan Indonesia (1.000.000 → 1000000)
        $produkDomestik = collect($request->input('produk_domestik', []))->map(function ($item) {
            if (isset($item['amount'])) {
                $cleanAmount = preg_replace('/[^0-9]/', '', $item['amount']);
                $item['amount'] = (float) $cleanAmount;
            }
            return $item;
        })->toArray();

        $request->merge(['produk_domestik' => $produkDomestik]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sektor,name',
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ]);

        $sektor = Sektor::create([
            'name' => $validated['name'],
        ]);

        foreach ($validated['produk_domestik'] as $pd) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $pd['year'],
                'amount' => $pd['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil ditambahkan dengan data produk domestik!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sektor $sektor)
    {
        $sektor->load('produkDomestik');

        return view('backend.sektor.edit', compact('sektor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/sektor/{sektor}",
     *     tags={"Sektor"},
     *     summary="Update existing sektor and its produk domestik data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="sektor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","produk_domestik"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(
     *                 property="produk_domestik",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"year","amount"},
     *                     @OA\Property(property="year", type="integer"),
     *                     @OA\Property(property="amount", type="number")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sektor updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Sektor")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Sektor $sektor)
    {
        // Bersihkan amount sama seperti store
        $produkDomestik = collect($request->input('produk_domestik', []))->map(function ($item) {
            if (isset($item['amount'])) {
                $cleanAmount = preg_replace('/[^0-9]/', '', $item['amount']);
                $item['amount'] = (float) $cleanAmount;
            }
            return $item;
        })->toArray();

        $request->merge(['produk_domestik' => $produkDomestik]);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sektor,name,' . $sektor->id,
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ]);

        $sektor->update([
            'name' => $validated['name'],
        ]);

        // Hapus produk domestik lama dan buat yang baru
        $sektor->produkDomestik()->delete();

        foreach ($validated['produk_domestik'] as $pd) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $pd['year'],
                'amount' => $pd['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/sektor/{sektor}",
     *     tags={"Sektor"},
     *     summary="Delete a sektor",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="sektor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Sektor deleted successfully")
     * )
     */
    public function destroy(Sektor $sektor)
    {
        $sektor->delete();

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil dihapus!');
    }
}