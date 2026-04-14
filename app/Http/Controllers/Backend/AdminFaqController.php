<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Faq",
 *     type="object",
 *     title="FAQ",
 *     description="Model FAQ untuk halaman Admin",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Apa itu DPMPTSP?"),
 *     @OA\Property(
 *         property="answer",
 *         type="string",
 *         example="DPMPTSP adalah Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu..."
 *     ),
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
class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/faq",
     *     tags={"FAQ"},
     *     summary="Get list of FAQs",
     *     description="Retrieve all FAQs with pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Faq")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $faqs = Faq::latest()->paginate(15);

        return view('backend.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/faq",
     *     tags={"FAQ"},
     *     summary="Create new FAQ",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","answer"},
     *             @OA\Property(property="title", type="string", example="Apa itu DPMPTSP?"),
     *             @OA\Property(property="answer", type="string", example="DPMPTSP adalah ..."),
     *             @OA\Property(property="is_active", type="boolean", default=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="FAQ created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Faq")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);

        return redirect()->route('backend.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('backend.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/faq/{faq}",
     *     tags={"FAQ"},
     *     summary="Update existing FAQ",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="faq",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="answer", type="string"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="FAQ updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Faq")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('backend.faq.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/faq/{faq}",
     *     tags={"FAQ"},
     *     summary="Delete a FAQ",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="faq",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="FAQ deleted successfully")
     * )
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('backend.faq.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}