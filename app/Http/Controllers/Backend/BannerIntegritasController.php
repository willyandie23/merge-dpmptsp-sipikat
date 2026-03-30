<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerIntegritas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerIntegritasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/banner-integritas",
     *     tags={"Banner Integritas (Admin)"},
     *     summary="Get list of integritas banners",
     *     description="Retrieve all integritas banners with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BannerIntegritas")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $banners = BannerIntegritas::latest()->paginate(10);
        return view('backend.banner_integritas.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banner_integritas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/banner-integritas",
     *     tags={"Banner Integritas (Admin)"},
     *     summary="Create new integritas banner",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","image"},
     *                 @OA\Property(property="title", type="string", example="Integritas Pelayanan Publik"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="is_active", type="boolean", default=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Banner created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',   // boleh null
        ]);

        // Pakai request->boolean() agar aman
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banner-integritas', 'public');
        }

        BannerIntegritas::create($validated);

        return redirect()->route('backend.banner-integritas.index')
            ->with('success', 'Banner Integritas berhasil ditambahkan!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerIntegritas $banner_integritas)
    {
        return view('backend.banner_integritas.edit', compact('banner_integritas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/banner-integritas/{banner_integritas}",
     *     tags={"Banner Integritas (Admin)"},
     *     summary="Update existing integritas banner",
     *     @OA\Parameter(name="banner_integritas", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="is_active", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Banner updated")
     * )
     */
    public function update(Request $request, BannerIntegritas $banner_integritas)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($banner_integritas->image) {
                Storage::disk('public')->delete($banner_integritas->image);
            }
            $validated['image'] = $request->file('image')->store('banner-integritas', 'public');
        }

        $banner_integritas->update($validated);

        return redirect()->route('backend.banner-integritas.index')
            ->with('success', 'Banner Integritas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/banner-integritas/{banner_integritas}",
     *     tags={"Banner Integritas (Admin)"},
     *     summary="Delete an integritas banner",
     *     @OA\Parameter(name="banner_integritas", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Banner deleted")
     * )
     */
    public function destroy(BannerIntegritas $banner_integritas)
    {
        if ($banner_integritas->image) {
            Storage::disk('public')->delete($banner_integritas->image);
        }

        $banner_integritas->delete();

        return redirect()->route('backend.banner-integritas.index')
            ->with('success', 'Banner Integritas berhasil dihapus!');
    }
}
