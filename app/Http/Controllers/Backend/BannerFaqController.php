<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BannerFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = BannerFaq::latest()->paginate(10);
        return view('backend.banner_faq.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banner_faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Ini yang paling penting
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banner-faq', 'public');
        }

        BannerFaq::create($validated);

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerFaq $banner_faq)
    {
        return view('backend.banner_faq.edit', compact('banner_faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerFaq $banner_faq)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Ini yang paling penting
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($banner_faq->image) {
                Storage::disk('public')->delete($banner_faq->image);
            }
            $validated['image'] = $request->file('image')->store('banner-faq', 'public');
        }

        $banner_faq->update($validated);

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil diupdate!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerFaq $banner_faq)
    {
        if ($banner_faq->image) {
            Storage::disk('public')->delete($banner_faq->image);
        }

        $banner_faq->delete();

        return redirect()->route('backend.banner-faq.index')
            ->with('success', 'Banner FAQ berhasil dihapus!');
    }
}
