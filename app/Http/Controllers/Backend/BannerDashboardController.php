<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="BannerDashboard",
 *     type="object",
 *     title="Banner Dashboard",
 *     description="Model Banner untuk halaman Dashboard Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Promo Layanan Baru"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         example="Deskripsi promo layanan terbaru"
 *     ),
 *     @OA\Property(property="image", type="string", example="banners/abc123.jpg"),
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
class BannerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/banner-dashboard",
     *     tags={"Banner Dashboard"},
     *     summary="Get list of dashboard banners",
     *     description="Retrieve all dashboard banners with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BannerDashboard")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $banners = BannerDashboard::latest()->paginate(10);
        return view('backend.banner_dashboard.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banner_dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/banner-dashboard",
     *     tags={"Banner Dashboard"},
     *     summary="Create new dashboard banner",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","image"},
     *                 @OA\Property(property="title", type="string", example="Promo Layanan Baru"),
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
            'is_active' => 'nullable|boolean',
        ]);

        // Pastikan is_active selalu ada (default false)
        $validated['is_active'] = $request->boolean('is_active');   // ini paling aman

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        BannerDashboard::create($validated);

        return redirect()->route('backend.banner-dashboard.index')
            ->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerDashboard $banner_dashboard)
    {
        return view('backend.banner_dashboard.edit', compact('banner_dashboard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/banner-dashboard/{banner_dashboard}",
     *     tags={"Banner Dashboard"},
     *     summary="Update existing banner",
     *     @OA\Parameter(name="banner_dashboard", in="path", required=true, @OA\Schema(type="integer")),
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
    public function update(Request $request, BannerDashboard $banner_dashboard)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($banner_dashboard->image) {
                Storage::disk('public')->delete($banner_dashboard->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner_dashboard->update($validated);

        return redirect()->route('backend.banner-dashboard.index')
            ->with('success', 'Banner berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/banner-dashboard/{banner_dashboard}",
     *     tags={"Banner Dashboard"},
     *     summary="Delete a banner",
     *     @OA\Parameter(name="banner_dashboard", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Banner deleted")
     * )
     */
    public function destroy(BannerDashboard $banner_dashboard)
    {
        if ($banner_dashboard->image) {
            Storage::disk('public')->delete($banner_dashboard->image);
        }

        $banner_dashboard->delete();

        return redirect()->route('backend.banner-dashboard.index')
            ->with('success', 'Banner berhasil dihapus!');
    }
}
