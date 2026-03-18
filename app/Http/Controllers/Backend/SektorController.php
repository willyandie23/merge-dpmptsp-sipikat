<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sektor;
use App\Models\ProdukDomestik;
use Illuminate\Http\Request;

class SektorController extends Controller
{
    public function index()
    {
        $sektors = Sektor::with('produkDomestik')
            ->latest()
            ->paginate(10);

        return view('backend.sektor.index', compact('sektors'));
    }

    public function create()
    {
        return view('backend.sektor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sektor,name',
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ]);

        $sektor = Sektor::create(['name' => $validated['name']]);

        foreach ($validated['produk_domestik'] as $p) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil ditambahkan beserta data produk domestik!');
    }

    public function edit(Sektor $sektor)
    {
        $sektor->load('produkDomestik');
        return view('backend.sektor.edit', compact('sektor'));
    }

    public function update(Request $request, Sektor $sektor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sektor,name,' . $sektor->id,
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ]);

        $sektor->update(['name' => $validated['name']]);

        // Hapus data lama, simpan yang baru
        $sektor->produkDomestik()->delete();

        foreach ($validated['produk_domestik'] as $p) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $p['year'],
                'amount' => $p['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor dan data produk domestik berhasil diupdate!');
    }

    public function destroy(Sektor $sektor)
    {
        $sektor->delete();
        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil dihapus!');
    }
}
