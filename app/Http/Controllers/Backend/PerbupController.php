<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Perbup;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Perbup",
 *     type="object",
 *     title="Perbup",
 *     description="Model Peraturan Bupati untuk ditampilkan di dashboard website",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="teks_perbup", type="string", example="Berdasarkan Peraturan Bupati Katingan Nomor 38 Tahun 2022 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi dan Tata Kerja Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Katingan"),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-14T10:00:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2026-04-14T10:00:00.000000Z"
 *     )
 * )
 */
class PerbupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/perbup",
     *     tags={"Perbup"},
     *     summary="Get Perbup data",
     *     description="Retrieve the Perbup regulation text",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Perbup")
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $perbup = Perbup::first();   // Karena biasanya hanya 1 data

        return view('backend.perbup.index', compact('perbup'));
    }

    /**
     * Show the form for creating / editing (karena biasanya hanya 1 record)
     */
    public function create()
    {
        $perbup = Perbup::first();
        return view('backend.perbup.create', compact('perbup'));
    }

    /**
     * Store or Update (Single Record)
     *
     * @OA\Post(
     *     path="/backend/perbup",
     *     tags={"Perbup"},
     *     summary="Save or update Perbup text",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"teks_perbup"},
     *             @OA\Property(property="teks_perbup", type="string"),
     *             @OA\Property(property="is_active", type="boolean", default=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Perbup saved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Perbup")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teks_perbup' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // Karena hanya 1 data, kita gunakan firstOrCreate / updateOrCreate
        $perbup = Perbup::first();

        if ($perbup) {
            $perbup->update($validated);
        } else {
            Perbup::create($validated);
        }

        return redirect()
            ->route('backend.perbup.index')
            ->with('success', 'Teks Peraturan Bupati berhasil disimpan.');
    }

    /**
     * Remove the resource (opsional, jarang dipakai)
     */
    public function destroy(Perbup $perbup)
    {
        $perbup->delete();

        return redirect()
            ->route('backend.perbup.index')
            ->with('success', 'Data Perbup berhasil dihapus.');
    }
}