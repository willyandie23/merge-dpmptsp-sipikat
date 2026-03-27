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
        return view('backend.layanan-utama.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('layanan_utama', $filename, 'public');
            $validated['image'] = $path;
        }

        LayananUtama::create($validated);

        return redirect()->route('backend.layanan-utama.index')
            ->with('success', 'Layanan Utama berhasil ditambahkan!');
    }

    public function edit(LayananUtama $layanan_utama)
    {
        return view('backend.layanan-utama.edit', compact('layanan_utama'));
    }

    public function update(Request $request, LayananUtama $layanan_utama)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['position'] = $validated['position'] ?? 99;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($layanan_utama->image) {
                Storage::disk('public')->delete($layanan_utama->image);
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('layanan_utama', $filename, 'public');
            $validated['image'] = $path;
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
