<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Video",
 *     type="object",
 *     title="Video",
 *     description="Model Video untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Video Profil DPMPTSP Kab. Katingan"),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         example="Penjelasan singkat mengenai layanan terpadu satu pintu"
 *     ),
 *     @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=abc123"),
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
class AdminVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/video",
     *     tags={"Video"},
     *     summary="Get list of videos",
     *     description="Retrieve all videos with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Video")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('backend.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/video",
     *     tags={"Video"},
     *     summary="Create new video",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","url"},
     *             @OA\Property(property="title", type="string", example="Video Profil DPMPTSP Kab. Katingan"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=abc123"),
     *             @OA\Property(property="is_active", type="boolean", default=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Video created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Video")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        Video::create($validated);

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('backend.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/video/{video}",
     *     tags={"Video"},
     *     summary="Update existing video",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="video",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="url", type="string", format="url"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Video updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Video")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $video->update($validated);

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/video/{video}",
     *     tags={"Video"},
     *     summary="Delete a video",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="video",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Video deleted successfully")
     * )
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil dihapus!');
    }
}