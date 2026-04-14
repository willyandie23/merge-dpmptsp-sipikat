<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="StrukturOrganisasi",
 *     type="object",
 *     title="Struktur Organisasi",
 *     description="Model Struktur Organisasi (Pejabat & Staff)",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Dr. John Doe, M.Si"),
 *     @OA\Property(property="nip", type="string", nullable=true, example="198501012006041001"),
 *     @OA\Property(property="golongan", type="string", nullable=true, example="IV/b"),
 *     @OA\Property(property="image", type="string", nullable=true, example="struktur-organisasi/abc123.jpg"),
 *     @OA\Property(property="is_pejabat", type="boolean", example=true),
 *     @OA\Property(property="id_bidang", type="integer", example=3),
 *     @OA\Property(
 *         property="bidang",
 *         ref="#/components/schemas/Bidang"
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
class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/struktur-organisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Get list of struktur organisasi",
     *     description="Retrieve all struktur organisasi with bidang relation (pejabat utama & staff)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/StrukturOrganisasi")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $bidangs = Bidang::with(['pejabatUtama', 'staff'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('backend.struktur-organisasi.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangs = Bidang::orderBy('position')->orderBy('name')->get();

        return view('backend.struktur-organisasi.create', compact('bidangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/struktur-organisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Create new struktur organisasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","id_bidang"},
     *                 @OA\Property(property="name", type="string", example="Dr. John Doe, M.Si"),
     *                 @OA\Property(property="nip", type="string", nullable=true),
     *                 @OA\Property(property="golongan", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="is_pejabat", type="boolean", default=false),
     *                 @OA\Property(property="id_bidang", type="integer", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Struktur organisasi created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StrukturOrganisasi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:struktur_organisasi,nip',
            'golongan' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_pejabat' => 'boolean',
            'id_bidang' => 'required|exists:bidang,id',
        ]);

        // VALIDASI KHUSUS: Hanya boleh 1 pejabat utama per bidang
        if ($request->is_pejabat) {
            $alreadyHasPejabat = StrukturOrganisasi::where('id_bidang', $request->id_bidang)
                ->where('is_pejabat', 1)
                ->exists();

            if ($alreadyHasPejabat) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Bidang ini sudah memiliki Pejabat Utama. Tidak diperbolehkan memiliki lebih dari satu Pejabat Utama dalam satu bidang.');
            }
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('struktur-organisasi', 'public');
        }

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturOrganisasi $struktur_organisasi)
    {
        $bidangs = Bidang::orderBy('position')->orderBy('name')->get();

        return view('backend.struktur-organisasi.edit', compact('struktur_organisasi', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/struktur-organisasi/{struktur_organisasi}",
     *     tags={"Struktur Organisasi"},
     *     summary="Update existing struktur organisasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="struktur_organisasi",
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
     *                 @OA\Property(property="nip", type="string", nullable=true),
     *                 @OA\Property(property="golongan", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="is_pejabat", type="boolean"),
     *                 @OA\Property(property="id_bidang", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Struktur organisasi updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StrukturOrganisasi")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, StrukturOrganisasi $struktur_organisasi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:struktur_organisasi,nip,' . $struktur_organisasi->id,
            'golongan' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_pejabat' => 'boolean',
            'id_bidang' => 'required|exists:bidang,id',
        ]);

        $validated['is_pejabat'] = $request->boolean('is_pejabat', false);

        // VALIDASI KHUSUS: Jika ingin dijadikan pejabat utama
        if ($validated['is_pejabat']) {
            $alreadyHasPejabat = StrukturOrganisasi::where('id_bidang', $validated['id_bidang'])
                ->where('is_pejabat', 1)
                ->where('id', '!=', $struktur_organisasi->id)
                ->exists();

            if ($alreadyHasPejabat) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Bidang ini sudah memiliki Pejabat Utama. Tidak diperbolehkan memiliki lebih dari satu Pejabat Utama.');
            }
        }

        if ($request->hasFile('image')) {
            if ($struktur_organisasi->image) {
                Storage::disk('public')->delete($struktur_organisasi->image);
            }
            $validated['image'] = $request->file('image')->store('struktur-organisasi', 'public');
        }

        $struktur_organisasi->update($validated);

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/struktur-organisasi/{struktur_organisasi}",
     *     tags={"Struktur Organisasi"},
     *     summary="Delete a struktur organisasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="struktur_organisasi",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Struktur organisasi deleted successfully")
     * )
     */
    public function destroy(StrukturOrganisasi $struktur_organisasi)
    {
        if ($struktur_organisasi->image) {
            Storage::disk('public')->delete($struktur_organisasi->image);
        }

        $struktur_organisasi->delete();

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil dihapus.');
    }

    /**
     * Check if bidang already has pejabat utama (AJAX)
     *
     * @OA\Get(
     *     path="/backend/struktur-organisasi/check-pejabat",
     *     tags={"Struktur Organisasi"},
     *     summary="Check if bidang already has pejabat utama",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="bidang_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Check result",
     *         @OA\JsonContent(
     *             @OA\Property(property="has_pejabat", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function checkPejabat(Request $request)
    {
        $bidangId = $request->bidang_id;

        $exists = StrukturOrganisasi::where('id_bidang', $bidangId)
            ->where('is_pejabat', 1)
            ->exists();

        return response()->json([
            'has_pejabat' => $exists
        ]);
    }
}