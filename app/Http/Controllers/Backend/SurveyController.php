<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys = Survey::orderBy('year', 'desc')->get();

        $availableYears = $surveys->pluck('year')->unique()->sortDesc()->values();

        $grouped = [];
        foreach ($surveys as $survey) {
            $grouped[$survey->year][$survey->month] = $survey->toArray(); // ubah ke array agar lebih aman di JS
        }

        return view('backend.survey.index', compact('availableYears', 'grouped'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil tahun-tahun yang sudah ada untuk membantu user
        $existingYears = Survey::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('backend.survey.create', compact('existingYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|between:1,12',
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'indikator1' => 'nullable|numeric|min:0|max:4',
            'indikator2' => 'nullable|numeric|min:0|max:4',
            'indikator3' => 'nullable|numeric|min:0|max:4',
            'indikator4' => 'nullable|numeric|min:0|max:4',
            'indikator5' => 'nullable|numeric|min:0|max:4',
            'indikator6' => 'nullable|numeric|min:0|max:4',
            'indikator7' => 'nullable|numeric|min:0|max:4',
            'indikator8' => 'nullable|numeric|min:0|max:4',
            'indikator9' => 'nullable|numeric|min:0|max:4',
        ]);

        // Cek apakah data untuk tahun + bulan tersebut sudah ada
        $exists = Survey::where('year', $validated['year'])
            ->where('month', $validated['month'])
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Data survey untuk Tahun {$validated['year']} Bulan {$validated['month']} sudah ada. Silakan edit data yang sudah ada.");
        }

        // Jika belum ada, baru simpan
        Survey::create([
            'year' => $validated['year'],
            'month' => $validated['month'],
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
            ->with('success', 'Data survey berhasil disimpan.');
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
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'indikator1' => 'nullable|numeric|min:0',
            'indikator2' => 'nullable|numeric|min:0',
            'indikator3' => 'nullable|numeric|min:0',
            'indikator4' => 'nullable|numeric|min:0',
            'indikator5' => 'nullable|numeric|min:0',
            'indikator6' => 'nullable|numeric|min:0',
            'indikator7' => 'nullable|numeric|min:0',
            'indikator8' => 'nullable|numeric|min:0',
            'indikator9' => 'nullable|numeric|min:0',
        ]);

        $survey->update($validated);

        return redirect()
            ->route('backend.survey.index')
            ->with('success', 'Data survey berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        // Kembalikan response JSON agar JS bisa menangani dengan benar
        return response()->json([
            'success' => true,
            'message' => 'Data survey berhasil dihapus.'
        ]);
    }
}
