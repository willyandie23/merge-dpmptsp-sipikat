<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Populasi;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::with('populasi')   // eager loading
            ->latest('id')
            ->paginate(10);

        return view('backend.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('backend.kecamatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kecamatan,name',
            'populasi.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'populasi.*.amount' => 'required|integer|min:0',
        ]);

        $kecamatan = Kecamatan::create(['name' => $validated['name']]);

        foreach ($validated['populasi'] as $p) {
            Populasi::create([
                'kecamatan_id' => $kecamatan->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan + data populasi berhasil disimpan!');
    }

    public function edit(Kecamatan $kecamatan)
    {
        $kecamatan->load('populasi');
        return view('backend.kecamatan.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kecamatan,name,' . $kecamatan->id,
            'populasi.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'populasi.*.amount' => 'required|integer|min:0',
        ]);

        $kecamatan->update(['name' => $validated['name']]);

        // Hapus populasi lama, simpan yang baru
        $kecamatan->populasi()->delete();
        foreach ($validated['populasi'] as $p) {
            Populasi::create([
                'kecamatan_id' => $kecamatan->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan dan data populasi berhasil diupdate!');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();
        return redirect()->route('backend.kecamatan.index')
            ->with('success', 'Kecamatan berhasil dihapus!');
    }
}
