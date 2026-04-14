<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="BannerFaq",
 *     type="object",
 *     title="Banner FAQ",
 *     description="Model Banner untuk halaman FAQ (Admin)",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="FAQ Pelayanan Terpadu Satu Pintu"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         example="Banner penjelasan singkat tentang FAQ DPMPTSP"
 *     ),
 *     @OA\Property(property="image", type="string", example="banner-faq/abc123.jpg"),
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
class BannerFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/banner-faq",
     *     tags={"Banner FAQ"},
     *     summary="Get list of FAQ banners",
     *     description="Retrieve all FAQ banners with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BannerFaq")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $banners = BannerFaq::latest()->paginate(10);
        return view('backend.banner_faq.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banner_faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/banner-faq",
     *     tags={"Banner FAQ"},
     *     summary="Create new FAQ banner",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","image"},
     *                 @OA\Property(property="title", type="string", example="FAQ Pelayanan Terpadu Satu Pintu"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="is_active", type="boolean", default=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Banner created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BannerFaq")
     *     ),
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

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banner-faq', 'public');
        }

        BannerFaq::create($validated);

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerFaq $banner_faq)
    {
        return view('backend.banner_faq.edit', compact('banner_faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/banner-faq/{banner_faq}",
     *     tags={"Banner FAQ"},
     *     summary="Update existing FAQ banner",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="banner_faq",
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
     *                 @OA\Property(property="is_active", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Banner updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BannerFaq")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, BannerFaq $banner_faq)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($banner_faq->image) {
                Storage::disk('public')->delete($banner_faq->image);
            }
            $validated['image'] = $request->file('image')->store('banner-faq', 'public');
        }

        $banner_faq->update($validated);

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/banner-faq/{banner_faq}",
     *     tags={"Banner FAQ"},
     *     summary="Delete a FAQ banner",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="banner_faq",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Banner deleted successfully")
     * )
     */
    public function destroy(BannerFaq $banner_faq)
    {
        if ($banner_faq->image) {
            Storage::disk('public')->delete($banner_faq->image);
        }

        $banner_faq->delete();

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil dihapus!');
    }
}