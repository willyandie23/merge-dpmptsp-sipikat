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
        return view('backend.bidang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name',
            'position' => 'required|integer|min:1',
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.'
        ]);

        Bidang::create($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function edit(Bidang $bidang)
    {
        return view('backend.bidang.edit', compact('bidang'));
    }

    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bidang,name,' . $bidang->id,
            'position' => 'required|integer|min:1',
        ], [
            'name.unique' => 'Nama bidang sudah ada, silakan gunakan nama yang berbeda.'
        ]);

        $bidang->update($validated);

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang)
    {
        // Cek apakah masih ada struktur organisasi di bidang ini
        if ($bidang->strukturOrganisasi()->count() > 0) {
            return redirect()
                ->route('backend.bidang.index')
                ->with('error', 'Bidang tidak dapat dihapus karena masih memiliki data struktur organisasi.');
        }

        $bidang->delete();

        return redirect()
            ->route('backend.bidang.index')
            ->with('success', 'Bidang berhasil dihapus.');
    }
}
