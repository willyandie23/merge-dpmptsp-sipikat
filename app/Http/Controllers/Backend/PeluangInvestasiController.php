<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Sektor;
use App\Models\PeluangInvestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PeluangInvestasiController extends Controller
{
    public function index()
    {
        $peluangs = PeluangInvestasi::with(['kecamatan', 'sektor'])
            ->latest()
            ->paginate(10);

        return view('backend.peluang-investasi.index', compact('peluangs'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        return view('backend.peluang-investasi.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'sektor_id' => 'required|exists:sektor,id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        // Upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('peluang-investasi', 'public');
            $validated['image'] = $imagePath;
        }

        // Mapping ke nama kolom tabel
        PeluangInvestasi::create([
            'title' => $validated['title'],
            'image' => $validated['image'],
            'description' => $validated['description'],
            'id_kecamatan' => $validated['kecamatan_id'],   // ← mapping
            'id_sektor' => $validated['sektor_id'],      // ← mapping
        ]);

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil ditambahkan!');
    }

    public function edit(PeluangInvestasi $peluang_investasi)
    {
        $peluang_investasi->load('kecamatan', 'sektor');
        $kecamatans = Kecamatan::orderBy('name')->get();
        $sektors = Sektor::where('kecamatan_id', $peluang_investasi->id_kecamatan)->get();  // pakai id_kecamatan

        return view('backend.peluang-investasi.edit', compact('peluang_investasi', 'kecamatans', 'sektors'));
    }

    public function update(Request $request, PeluangInvestasi $peluang_investasi)
    {
        $validated = $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'sektor_id' => 'required|exists:sektor,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'id_kecamatan' => $validated['kecamatan_id'],
            'id_sektor' => $validated['sektor_id'],
        ];

        if ($request->hasFile('image')) {
            if ($peluang_investasi->image) {
                Storage::disk('public')->delete($peluang_investasi->image);
            }
            $imagePath = $request->file('image')->store('peluang-investasi', 'public');
            $data['image'] = $imagePath;
        }

        $peluang_investasi->update($data);

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil diupdate!');
    }

    public function destroy(PeluangInvestasi $peluang_investasi)
    {
        if ($peluang_investasi->image) {
            Storage::disk('public')->delete($peluang_investasi->image);
        }
        $peluang_investasi->delete();

        return redirect()->route('backend.peluang-investasi.index')
            ->with('success', 'Peluang investasi berhasil dihapus!');
    }

    public function getSektorsByKecamatan(Request $request)
    {
        try {
            $kecamatanId = $request->query('kecamatan_id');   // lebih aman

            if (empty($kecamatanId)) {
                return response()->json([]);
            }

            $sektors = Sektor::where('kecamatan_id', $kecamatanId)
                ->orderBy('name')
                ->get(['id', 'name']);

            return response()->json($sektors);

        } catch (\Exception $e) {
            Log::error('AJAX getSektorsByKecamatan Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
