<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TentangDpmptsp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangDpmptspController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang = TentangDpmptsp::first();

        if (!$tentang) {
            $tentang = TentangDpmptsp::create([]); // buat record kosong jika belum ada
        }

        return view('backend.tentang-dpmptsp.index', compact('tentang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tentang = TentangDpmptsp::firstOrCreate([]);

        return view('backend.tentang-dpmptsp.edit', compact('tentang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TentangDpmptsp $tentang_dpmptsp)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dasar_hukum' => 'nullable|string',
            'moto_layanan' => 'nullable|string',           // diubah jadi string (bukan max:255)
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'maklumat_layanan' => 'nullable|string',
            'waktu_layanan' => 'nullable|string',           // diubah jadi string
            'alamat' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'sasaran_layanan' => 'nullable|string',
        ]);

        // Handle Upload Image
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($tentang_dpmptsp->image) {
                Storage::disk('public')->delete($tentang_dpmptsp->image);
            }
            $validated['image'] = $request->file('image')->store('tentang-dpmptsp', 'public');
        }

        $tentang_dpmptsp->update($validated);

        return redirect()
            ->route('backend.tentang-dpmptsp.index')
            ->with('success', 'Data Tentang DPMPTSP berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TentangDpmptsp $tentang_dpmptsp)
    {
        if ($tentang_dpmptsp->image) {
            Storage::disk('public')->delete($tentang_dpmptsp->image);
        }

        $tentang_dpmptsp->delete();

        return redirect()
            ->route('backend.tentang-dpmptsp.index')
            ->with('success', 'Data Tentang DPMPTSP berhasil dihapus!');
    }
}
