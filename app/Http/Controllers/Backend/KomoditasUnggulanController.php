<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KomoditasUnggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KomoditasUnggulanController extends Controller
{
    public function index()
    {
        $komoditas = KomoditasUnggulan::latest()->paginate(10);
        return view('backend.komoditas_unggulan.index', compact('komoditas'));
    }

    public function create()
    {
        return view('backend.komoditas_unggulan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('komoditas-unggulan', 'public');
        }

        KomoditasUnggulan::create($validated);

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil ditambahkan!');
    }

    public function edit(KomoditasUnggulan $komoditas_unggulan)
    {
        return view('backend.komoditas_unggulan.edit', compact('komoditas_unggulan'));
    }

    public function update(Request $request, KomoditasUnggulan $komoditas_unggulan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($komoditas_unggulan->image) {
                Storage::disk('public')->delete($komoditas_unggulan->image);
            }
            $validated['image'] = $request->file('image')->store('komoditas-unggulan', 'public');
        }

        $komoditas_unggulan->update($validated);

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil diupdate!');
    }

    public function destroy(KomoditasUnggulan $komoditas_unggulan)
    {
        if ($komoditas_unggulan->image) {
            Storage::disk('public')->delete($komoditas_unggulan->image);
        }

        $komoditas_unggulan->delete();

        return redirect()->route('backend.komoditas-unggulan.index')
            ->with('success', 'Komoditas Unggulan berhasil dihapus!');
    }
}
