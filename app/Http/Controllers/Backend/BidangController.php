<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::orderBy('position')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.bidang.index', compact('bidangs'));
    }

    public function create()
    {
        $usedPositions = Bidang::select('id', 'name as title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.bidang.create', compact('usedPositions'));
    }

    public function edit(Bidang $bidang)
    {
        $usedPositions = Bidang::select('id', 'name as title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.bidang.edit', compact('bidang', 'usedPositions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name',
            'position' => 'required|integer|min:1|unique:bidang,position',   // tambahkan unique
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.',
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh bidang lain.'
        ]);

        Bidang::create($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name,' . $bidang->id,
            'position' => 'required|integer|min:1|unique:bidang,position,' . $bidang->id,
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.',
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh bidang lain.'
        ]);

        $bidang->update($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang)
    {
        try {
            // Hapus semua struktur organisasi yang terkait dengan bidang ini
            $bidang->strukturOrganisasi()->delete();

            // Baru hapus bidangnya
            $bidang->delete();

            return redirect()
                ->route('backend.bidang.index')
                ->with('success', 'Bidang beserta semua struktur organisasinya berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('backend.bidang.index')
                ->with('error', 'Terjadi kesalahan saat menghapus bidang: ' . $e->getMessage());
        }
    }
}
