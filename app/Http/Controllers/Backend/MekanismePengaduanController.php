<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MekanismePengaduan;
use Illuminate\Http\Request;

class MekanismePengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mekanisme = MekanismePengaduan::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.mekanisme-pengaduan.index', compact('mekanisme'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.mekanisme-pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'position' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

        // TODO: Upload image nanti kita tambahkan

        MekanismePengaduan::create($validated);

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MekanismePengaduan $mekanisme_pengaduan)
    {
        return view('backend.mekanisme-pengaduan.edit', compact('mekanisme_pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MekanismePengaduan $mekanisme_pengaduan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url|max:255',
            'position' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

        $mekanisme_pengaduan->update($validated);

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MekanismePengaduan $mekanisme_pengaduan)
    {
        $mekanisme_pengaduan->delete();

        return redirect()
            ->route('backend.mekanisme-pengaduan.index')
            ->with('success', 'Mekanisme Pengaduan berhasil dihapus!');
    }
}
