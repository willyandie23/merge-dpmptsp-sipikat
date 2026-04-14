<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KomoditasUnggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="KomoditasUnggulan",
 *     type="object",
 *     title="Komoditas Unggulan",
 *     description="Model Komoditas Unggulan untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Kopi Arabika Katingan"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Komoditas unggulan Kabupaten Katingan yang terkenal dengan cita rasa khas..."
 *     ),
 *     @OA\Property(property="image", type="string", example="komoditas-unggulan/abc123.jpg"),
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
class KomoditasUnggulanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/komoditas-unggulan",
     *     tags={"Komoditas Unggulan"},
     *     summary="Get list of komoditas unggulan",
     *     description="Retrieve all komoditas unggulan with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/KomoditasUnggulan")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $komoditas = KomoditasUnggulan::latest()->paginate(10);
        return view('backend.komoditas_unggulan.index', compact('komoditas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.komoditas_unggulan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/komoditas-unggulan",
     *     tags={"Komoditas Unggulan"},
     *     summary="Create new komoditas unggulan",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","description","image"},
     *                 @OA\Property(property="title", type="string", example="Kopi Arabika Katingan"),
     *                 @OA\Property(property="description", type="string", example="Deskripsi komoditas unggulan..."),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Komoditas unggulan created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/KomoditasUnggulan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('komoditas-unggulan', 'public');
        }

        KomoditasUnggulan::create($validated);

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomoditasUnggulan $komoditas_unggulan)
    {
        return view('backend.komoditas_unggulan.edit', compact('komoditas_unggulan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/komoditas-unggulan/{komoditas_unggulan}",
     *     tags={"Komoditas Unggulan"},
     *     summary="Update existing komoditas unggulan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="komoditas_unggulan",
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
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Komoditas unggulan updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/KomoditasUnggulan")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, KomoditasUnggulan $komoditas_unggulan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($komoditas_unggulan->image) {
                Storage::disk('public')->delete($komoditas_unggulan->image);
            }
            $validated['image'] = $request->file('image')->store('komoditas-unggulan', 'public');
        }

        $komoditas_unggulan->update($validated);

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/komoditas-unggulan/{komoditas_unggulan}",
     *     tags={"Komoditas Unggulan"},
     *     summary="Delete a komoditas unggulan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="komoditas_unggulan",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Komoditas unggulan deleted successfully")
     * )
     */
    public function destroy(KomoditasUnggulan $komoditas_unggulan)
    {
        if ($komoditas_unggulan->image) {
            Storage::disk('public')->delete($komoditas_unggulan->image);
        }

        $komoditas_unggulan->delete();

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil dihapus!');
    }
}