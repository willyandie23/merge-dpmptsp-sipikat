<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('backend.video.index', compact('videos'));
    }

    public function create()
    {
        return view('backend.video.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:500',
            'is_active' => 'boolean',
        ]);

        Video::create($validated);

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil ditambahkan!');
    }

    public function edit(Video $video)
    {
        return view('backend.video.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:500',
            'is_active' => 'boolean',
        ]);

        $video->update($validated);

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil diupdate!');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('backend.video.index')
            ->with('success', 'Video berhasil dihapus!');
    }
}
