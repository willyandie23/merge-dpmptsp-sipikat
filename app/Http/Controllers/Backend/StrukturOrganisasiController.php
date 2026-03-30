<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::with(['pejabatUtama', 'staff'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('backend.struktur-organisasi.index', compact('bidangs'));
    }

    public function create()
    {
        $bidangs = Bidang::orderBy('position')->orderBy('name')->get();

        return view('backend.struktur-organisasi.create', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:struktur_organisasi,nip',
            'golongan' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_pejabat' => 'boolean',
            'id_bidang' => 'required|exists:bidang,id',
        ]);

        // VALIDASI KHUSUS: Hanya boleh 1 pejabat utama per bidang
        if ($request->is_pejabat) {
            $alreadyHasPejabat = StrukturOrganisasi::where('id_bidang', $request->id_bidang)
                ->where('is_pejabat', 1)
                ->exists();

            if ($alreadyHasPejabat) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Bidang ini sudah memiliki Pejabat Utama. Tidak diperbolehkan memiliki lebih dari satu Pejabat Utama dalam satu bidang.');
            }
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('struktur-organisasi', 'public');
        }

        StrukturOrganisasi::create($validated);

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $struktur_organisasi)
    {
        $bidangs = Bidang::orderBy('position')->orderBy('name')->get();

        return view('backend.struktur-organisasi.edit', compact('struktur_organisasi', 'bidangs'));
    }

    public function update(Request $request, StrukturOrganisasi $struktur_organisasi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:struktur_organisasi,nip,' . $struktur_organisasi->id,
            'golongan' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_pejabat' => 'boolean',
            'id_bidang' => 'required|exists:bidang,id',
        ]);

        // Pastikan is_pejabat selalu terdefinisi (0 atau 1)
        $validated['is_pejabat'] = $request->boolean('is_pejabat', false);

        // VALIDASI KHUSUS: Jika ingin dijadikan pejabat utama
        if ($validated['is_pejabat']) {
            $alreadyHasPejabat = StrukturOrganisasi::where('id_bidang', $validated['id_bidang'])
                ->where('is_pejabat', 1)
                ->where('id', '!=', $struktur_organisasi->id)   // kecuali data ini sendiri
                ->exists();

            if ($alreadyHasPejabat) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Bidang ini sudah memiliki Pejabat Utama. Tidak diperbolehkan memiliki lebih dari satu Pejabat Utama.');
            }
        }

        if ($request->hasFile('image')) {
            if ($struktur_organisasi->image) {
                Storage::disk('public')->delete($struktur_organisasi->image);
            }
            $validated['image'] = $request->file('image')->store('struktur-organisasi', 'public');
        }

        $struktur_organisasi->update($validated);

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $struktur_organisasi)
    {
        if ($struktur_organisasi->image) {
            Storage::disk('public')->delete($struktur_organisasi->image);
        }

        $struktur_organisasi->delete();

        return redirect()
            ->route('backend.struktur-organisasi.index')
            ->with('success', 'Data struktur organisasi berhasil dihapus.');
    }

    public function checkPejabat(Request $request)
    {
        $bidangId = $request->bidang_id;

        $exists = StrukturOrganisasi::where('id_bidang', $bidangId)
            ->where('is_pejabat', 1)
            ->exists();

        return response()->json([
            'has_pejabat' => $exists
        ]);
    }
}
