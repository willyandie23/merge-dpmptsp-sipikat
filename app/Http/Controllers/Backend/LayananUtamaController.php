<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LayananUtama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananUtamaController extends Controller
{
    public function index()
    {
        $layanan = LayananUtama::orderBy('position')
            ->latest()
            ->paginate(15);

        return view('backend.layanan-utama.index', compact('layanan'));
    }

    public function create()
    {
        $usedPositions = LayananUtama::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-utama.create', compact('usedPositions'));
    }

    public function edit(LayananUtama $layanan_utama)
    {
        $usedPositions = LayananUtama::select('id', 'title', 'position')
            ->orderBy('position')
            ->get();

        return view('backend.layanan-utama.edit', compact('layanan_utama', 'usedPositions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'position' => 'required|integer|min:1|unique:layanan_utama,position',
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('layanan_utama', $filename, 'public');
        }

        LayananUtama::create($validated);

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil ditambahkan!');
    }

    public function update(Request $request, LayananUtama $layanan_utama)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'position' => 'required|integer|min:1|unique:layanan_utama,position,' . $layanan_utama->id,
            'is_active' => 'nullable|boolean',
        ], [
            'position.unique' => 'Posisi urutan :input sudah digunakan oleh layanan lain.'
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($layanan_utama->image) {
                Storage::disk('public')->delete($layanan_utama->image);
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('layanan_utama', $filename, 'public');
        }

        $layanan_utama->update($validated);

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil diperbarui!');
    }

    public function destroy(LayananUtama $layanan_utama)
    {
        if ($layanan_utama->image) {
            Storage::disk('public')->delete($layanan_utama->image);
        }

        $layanan_utama->delete();

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil dihapus!');
    }
}
