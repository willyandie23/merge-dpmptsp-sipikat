<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MekanismePengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $usedPositions = MekanismePengaduan::select('id', 'name', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.mekanisme-pengaduan.create', compact('usedPositions'));
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
            'position' => 'required|integer|min:1|unique:mekanisme_pengaduan,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan. Silakan pilih nomor urutan yang lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('mekanisme-pengaduan', $filename, 'public');
        }

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
        $usedPositions = MekanismePengaduan::select('id', 'name', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.mekanisme-pengaduan.edit', compact('mekanisme_pengaduan', 'usedPositions'));
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
            'position' => 'required|integer|min:1|unique:mekanisme_pengaduan,position,' . $mekanisme_pengaduan->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh mekanisme lain. Silakan pilih nomor yang berbeda.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($mekanisme_pengaduan->image) {
                Storage::disk('public')->delete($mekanisme_pengaduan->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('mekanisme-pengaduan', $filename, 'public');
        }

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
