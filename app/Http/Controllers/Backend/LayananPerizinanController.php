<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LayananPerizinan;
use Illuminate\Http\Request;

class LayananPerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanan = LayananPerizinan::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.layanan-perizinan.index', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usedPositions = LayananPerizinan::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-perizinan.create', compact('usedPositions'));
    }

    public function edit(LayananPerizinan $layanan_perizinan)
    {
        $usedPositions = LayananPerizinan::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-perizinan.edit', compact('layanan_perizinan', 'usedPositions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'position' => 'required|integer|min:1|unique:layanan_perizinan,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        LayananPerizinan::create($validated);

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil ditambahkan!');
    }

    // Update method juga perlu diperbaiki (sama logikanya)
    public function update(Request $request, LayananPerizinan $layanan_perizinan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'position' => 'required|integer|min:1|unique:layanan_perizinan,position,' . $layanan_perizinan->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $layanan_perizinan->update($validated);

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LayananPerizinan $layanan_perizinan)
    {
        $layanan_perizinan->delete();

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil dihapus!');
    }
}
