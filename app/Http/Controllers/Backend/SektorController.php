<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Sektor;
use App\Models\ProdukDomestik;
use Illuminate\Http\Request;

class SektorController extends Controller
{
    public function index()
    {
        $sektors = Sektor::with(['kecamatan', 'produkDomestik'])
            ->latest()
            ->paginate(10);

        return view('backend.sektor.index', compact('sektors'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('backend.sektor.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        // Bersihkan format ribuan Indonesia (1.000.000 → 1000000)
        $produkDomestik = collect($request->input('produk_domestik', []))->map(function ($item) {
            if (isset($item['amount'])) {
                // Hapus titik ribuan dan karakter lain
                $cleanAmount = preg_replace('/[^0-9]/', '', $item['amount']);
                $item['amount'] = (float) $cleanAmount;
            }
            return $item;
        })->toArray();

        $request->merge(['produk_domestik' => $produkDomestik]);

        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'name' => 'required|string|max:255|unique:sektor,name,NULL,id,kecamatan_id,' . $request->kecamatan_id,
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ], [
            'name.unique' => 'Nama sektor ini sudah ada di kecamatan yang dipilih.'
        ]);

        $sektor = Sektor::create([
            'name' => $validated['name'],
            'kecamatan_id' => $validated['kecamatan_id'],
        ]);

        foreach ($validated['produk_domestik'] as $pd) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $pd['year'],
                'amount' => $pd['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil ditambahkan dengan data produk domestik!');
    }

    public function update(Request $request, Sektor $sektor)
    {
        // Bersihkan amount sama seperti store
        $produkDomestik = collect($request->input('produk_domestik', []))->map(function ($item) {
            if (isset($item['amount'])) {
                $cleanAmount = preg_replace('/[^0-9]/', '', $item['amount']);
                $item['amount'] = (float) $cleanAmount;
            }
            return $item;
        })->toArray();

        $request->merge(['produk_domestik' => $produkDomestik]);

        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'name' => 'required|string|max:255|unique:sektor,name,' . $sektor->id . ',id,kecamatan_id,' . $request->kecamatan_id,
            'produk_domestik.*.year' => 'required|integer|min:2000|max:2100|distinct',
            'produk_domestik.*.amount' => 'required|numeric|min:0',
        ], [
            'name.unique' => 'Nama sektor ini sudah ada di kecamatan yang dipilih.'
        ]);

        $sektor->update([
            'name' => $validated['name'],
            'kecamatan_id' => $validated['kecamatan_id'],
        ]);

        $sektor->produkDomestik()->delete();

        foreach ($validated['produk_domestik'] as $pd) {
            ProdukDomestik::create([
                'sektor_id' => $sektor->id,
                'year' => $pd['year'],
                'amount' => $pd['amount'],
            ]);
        }

        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil diupdate!');
    }

    public function edit(Sektor $sektor)
    {
        $sektor->load('produkDomestik', 'kecamatan');
        $kecamatans = Kecamatan::orderBy('name')->get();

        return view('backend.sektor.edit', compact('sektor', 'kecamatans'));
    }

    public function destroy(Sektor $sektor)
    {
        $sektor->delete();
        return redirect()->route('backend.sektor.index')
            ->with('success', 'Sektor berhasil dihapus!');
    }
}
