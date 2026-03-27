<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PertumbuhanEkonomi;
use Illuminate\Http\Request;

class PertumbuhanEkonomiController extends Controller
{
    public function index()
    {
        $pertumbuhans = PertumbuhanEkonomi::latest('year')
            ->paginate(10);

        return view('backend.pertumbuhan-ekonomi.index', compact('pertumbuhans'));
    }

    public function create()
    {
        return view('backend.pertumbuhan-ekonomi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:pertumbuhan_ekonomi,year',
            'amount' => 'required|numeric|min:0|max:100', // persentase 0 - 100%
        ], [
            'year.unique' => 'Data pertumbuhan ekonomi untuk tahun ini sudah ada.'
        ]);

        PertumbuhanEkonomi::create($validated);

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil ditambahkan!');
    }

    public function edit(PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        return view('backend.pertumbuhan-ekonomi.edit', compact('pertumbuhan_ekonomi'));
    }

    public function update(Request $request, PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:pertumbuhan_ekonomi,year,' . $pertumbuhan_ekonomi->id,
            'amount' => 'required|numeric|min:0|max:100',
        ], [
            'year.unique' => 'Data pertumbuhan ekonomi untuk tahun ini sudah ada.'
        ]);

        $pertumbuhan_ekonomi->update($validated);

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil diupdate!');
    }

    public function destroy(PertumbuhanEkonomi $pertumbuhan_ekonomi)
    {
        $pertumbuhan_ekonomi->delete();

        return redirect()->route('backend.pertumbuhan-ekonomi.index')
            ->with('success', 'Data pertumbuhan ekonomi berhasil dihapus!');
    }
}
