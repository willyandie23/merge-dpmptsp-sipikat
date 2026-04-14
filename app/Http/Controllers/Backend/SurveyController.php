<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Survey",
 *     type="object",
 *     title="Survey",
 *     description="Model Data Survey Kepuasan Masyarakat",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="year", type="integer", example=2026),
 *     @OA\Property(property="triwulan", type="integer", example=1),
 *     @OA\Property(property="jumlah_laki", type="integer", example=1250),
 *     @OA\Property(property="jumlah_perempuan", type="integer", example=1380),
 *     @OA\Property(property="indikator1", type="number", format="float", nullable=true, example=3.8),
 *     @OA\Property(property="indikator2", type="number", format="float", nullable=true, example=4.0),
 *     @OA\Property(property="indikator3", type="number", format="float", nullable=true, example=3.5),
 *     @OA\Property(property="indikator4", type="number", format="float", nullable=true, example=4.2),
 *     @OA\Property(property="indikator5", type="number", format="float", nullable=true, example=3.9),
 *     @OA\Property(property="indikator6", type="number", format="float", nullable=true, example=4.1),
 *     @OA\Property(property="indikator7", type="number", format="float", nullable=true, example=3.7),
 *     @OA\Property(property="indikator8", type="number", format="float", nullable=true, example=4.0),
 *     @OA\Property(property="indikator9", type="number", format="float", nullable=true, example=3.6),
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
class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/backend/survey",
     *     tags={"Survey"},
     *     summary="Get list of survey data",
     *     description="Retrieve all survey data grouped by year and triwulan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Survey")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $surveys = Survey::orderBy('year', 'desc')
            ->orderBy('triwulan', 'asc')
            ->get();

        $availableYears = $surveys->pluck('year')->unique()->sortDesc()->values();

        $grouped = [];
        foreach ($surveys as $survey) {
            $grouped[$survey->year][$survey->triwulan] = $survey->toArray();
        }

        return view('backend.survey.index', compact('availableYears', 'grouped'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $existingYears = Survey::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('backend.survey.create', compact('existingYears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/backend/survey",
     *     tags={"Survey"},
     *     summary="Create new survey data",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"year","triwulan","jumlah_laki","jumlah_perempuan"},
     *             @OA\Property(property="year", type="integer", example=2026),
     *             @OA\Property(property="triwulan", type="integer", example=1),
     *             @OA\Property(property="jumlah_laki", type="integer", example=1250),
     *             @OA\Property(property="jumlah_perempuan", type="integer", example=1380),
     *             @OA\Property(property="indikator1", type="number", nullable=true, example=3.8),
     *             @OA\Property(property="indikator2", type="number", nullable=true, example=4.0),
     *             @OA\Property(property="indikator3", type="number", nullable=true, example=3.5),
     *             @OA\Property(property="indikator4", type="number", nullable=true, example=4.2),
     *             @OA\Property(property="indikator5", type="number", nullable=true, example=3.9),
     *             @OA\Property(property="indikator6", type="number", nullable=true, example=4.1),
     *             @OA\Property(property="indikator7", type="number", nullable=true, example=3.7),
     *             @OA\Property(property="indikator8", type="number", nullable=true, example=4.0),
     *             @OA\Property(property="indikator9", type="number", nullable=true, example=3.6)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Survey created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'triwulan' => 'required|integer|between:1,4',
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'indikator1' => 'nullable|numeric|min:0|max:5',
            'indikator2' => 'nullable|numeric|min:0|max:5',
            'indikator3' => 'nullable|numeric|min:0|max:5',
            'indikator4' => 'nullable|numeric|min:0|max:5',
            'indikator5' => 'nullable|numeric|min:0|max:5',
            'indikator6' => 'nullable|numeric|min:0|max:5',
            'indikator7' => 'nullable|numeric|min:0|max:5',
            'indikator8' => 'nullable|numeric|min:0|max:5',
            'indikator9' => 'nullable|numeric|min:0|max:5',
        ]);

        // Cek apakah data untuk tahun + triwulan tersebut sudah ada
        $exists = Survey::where('year', $validated['year'])
            ->where('triwulan', $validated['triwulan'])
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Data survey untuk Tahun {$validated['year']} Triwulan {$validated['triwulan']} sudah ada. Silakan edit data yang sudah ada.");
        }

        Survey::create([
            'year' => $validated['year'],
            'triwulan' => $validated['triwulan'],
            'jumlah_laki' => $validated['jumlah_laki'],
            'jumlah_perempuan' => $validated['jumlah_perempuan'],
            'indikator1' => $validated['indikator1'] ?? 0,
            'indikator2' => $validated['indikator2'] ?? 0,
            'indikator3' => $validated['indikator3'] ?? 0,
            'indikator4' => $validated['indikator4'] ?? 0,
            'indikator5' => $validated['indikator5'] ?? 0,
            'indikator6' => $validated['indikator6'] ?? 0,
            'indikator7' => $validated['indikator7'] ?? 0,
            'indikator8' => $validated['indikator8'] ?? 0,
            'indikator9' => $validated['indikator9'] ?? 0,
        ]);

        return redirect()
            ->route('backend.survey.index')
            ->with('success', 'Data survey triwulan berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        return view('backend.survey.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/backend/survey/{survey}",
     *     tags={"Survey"},
     *     summary="Update existing survey data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="jumlah_laki", type="integer"),
     *             @OA\Property(property="jumlah_perempuan", type="integer"),
     *             @OA\Property(property="indikator1", type="number", nullable=true),
     *             @OA\Property(property="indikator2", type="number", nullable=true),
     *             @OA\Property(property="indikator3", type="number", nullable=true),
     *             @OA\Property(property="indikator4", type="number", nullable=true),
     *             @OA\Property(property="indikator5", type="number", nullable=true),
     *             @OA\Property(property="indikator6", type="number", nullable=true),
     *             @OA\Property(property="indikator7", type="number", nullable=true),
     *             @OA\Property(property="indikator8", type="number", nullable=true),
     *             @OA\Property(property="indikator9", type="number", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Survey updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'indikator1' => 'nullable|numeric|min:0|max:5',
            'indikator2' => 'nullable|numeric|min:0|max:5',
            'indikator3' => 'nullable|numeric|min:0|max:5',
            'indikator4' => 'nullable|numeric|min:0|max:5',
            'indikator5' => 'nullable|numeric|min:0|max:5',
            'indikator6' => 'nullable|numeric|min:0|max:5',
            'indikator7' => 'nullable|numeric|min:0|max:5',
            'indikator8' => 'nullable|numeric|min:0|max:5',
            'indikator9' => 'nullable|numeric|min:0|max:5',
        ]);

        $survey->update($validated);

        return redirect()
            ->route('backend.survey.index')
            ->with('success', 'Data survey berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/backend/survey/{survey}",
     *     tags={"Survey"},
     *     summary="Delete survey data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Survey deleted successfully"
     *     )
     * )
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return redirect()
            ->route('backend.survey.index')
            ->with('success', 'Data survey berhasil dihapus.');
    }
}