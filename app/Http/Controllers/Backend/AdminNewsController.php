<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="News",
 *     type="object",
 *     title="News",
 *     description="Model Berita untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Pembukaan Pelayanan Terpadu Satu Pintu Tahun 2026"),
 *     @OA\Property(property="author", type="string", nullable=true, example="Admin DPMPTSP"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Berita mengenai pembukaan layanan baru di DPMPTSP Kab. Katingan..."
 *     ),
 *     @OA\Property(property="image", type="string", example="news/xyz789.jpg"),
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
class AdminNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/news",
     *     tags={"News"},
     *     summary="Get list of news",
     *     description="Retrieve all news with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/News")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('backend.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/news",
     *     tags={"News"},
     *     summary="Create new news",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title","description","image"},
     *                 @OA\Property(property="title", type="string", example="Pembukaan Pelayanan Terpadu Satu Pintu Tahun 2026"),
     *                 @OA\Property(property="author", type="string", nullable=true, example="Admin DPMPTSP"),
     *                 @OA\Property(property="description", type="string", example="Deskripsi lengkap berita..."),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="is_active", type="boolean", default=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="News created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/News")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('backend.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('backend.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/news/{news}",
     *     tags={"News"},
     *     summary="Update existing news",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="news",
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
     *                 @OA\Property(property="author", type="string", nullable=true),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="is_active", type="boolean")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/News")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('backend.news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/news/{news}",
     *     tags={"News"},
     *     summary="Delete a news",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="news",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="News deleted successfully")
     * )
     */
    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('backend.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}