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
        return view('backend.layanan-perizinan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

        LayananPerizinan::create($validated);

        return redirect()->route('backend.layanan-perizinan.index')
            ->with('success', 'Layanan Perizinan Usaha berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayananPerizinan $layanan_perizinan)
    {
        return view('backend.layanan-perizinan.edit', compact('layanan_perizinan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LayananPerizinan $layanan_perizinan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

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
