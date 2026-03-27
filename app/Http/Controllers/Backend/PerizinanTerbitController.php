<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PerizinanTerbit;
use Illuminate\Http\Request;

class PerizinanTerbitController extends Controller
{
    public function index()
    {
        $perizinans = PerizinanTerbit::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();   // Gunakan get() dulu untuk summary & grouping

        $availableYears = $perizinans->pluck('year')
            ->unique()
            ->sortDesc()
            ->values();

        // Grouping untuk JavaScript
        $grouped = [];
        foreach ($perizinans as $item) {
            $grouped[$item->year][$item->month] = $item->toArray();
        }

        return view('backend.perizinan-terbit.index', compact('availableYears', 'grouped'));
    }

    public function create()
    {
        return view('backend.perizinan-terbit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|between:1,12',
            'oss_rba' => 'required|integer|min:0',
            'sicantik_cloud' => 'required|integer|min:0',
            'simbg' => 'required|integer|min:0',
        ]);

        $total_terbit = $validated['oss_rba'] + $validated['sicantik_cloud'] + $validated['simbg'];

        PerizinanTerbit::updateOrCreate(
            [
                'year' => $validated['year'],
                'month' => $validated['month'],
            ],
            [
                'oss_rba' => $validated['oss_rba'],
                'sicantik_cloud' => $validated['sicantik_cloud'],
                'simbg' => $validated['simbg'],
                'total_terbit' => $total_terbit,
            ]
        );

        return redirect()
            ->route('backend.perizinan-terbit.index')
            ->with('success', 'Data Perizinan Terbit berhasil disimpan.');
    }

    public function edit(PerizinanTerbit $perizinan_terbit)
    {
        return view('backend.perizinan-terbit.edit', compact('perizinan_terbit'));
    }

    public function update(Request $request, PerizinanTerbit $perizinan_terbit)
    {
        $validated = $request->validate([
            'oss_rba' => 'required|integer|min:0',
            'sicantik_cloud' => 'required|integer|min:0',
            'simbg' => 'required|integer|min:0',
        ]);

        $total_terbit = $validated['oss_rba'] + $validated['sicantik_cloud'] + $validated['simbg'];

        $perizinan_terbit->update([
            'oss_rba' => $validated['oss_rba'],
            'sicantik_cloud' => $validated['sicantik_cloud'],
            'simbg' => $validated['simbg'],
            'total_terbit' => $total_terbit,
        ]);

        return redirect()
            ->route('backend.perizinan-terbit.index')
            ->with('success', 'Data Perizinan Terbit berhasil diperbarui.');
    }

    public function destroy(PerizinanTerbit $perizinan_terbit)
    {
        $perizinan_terbit->delete();

        return redirect()
            ->route('backend.perizinan-terbit.index')
            ->with('success', 'Data Perizinan Terbit berhasil dihapus.');
    }
}
