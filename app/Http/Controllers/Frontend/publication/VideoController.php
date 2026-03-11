<?php

namespace App\Http\Controllers\Frontend\publication;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::active()->latest()->paginate(9);

        return view('frontend.publication.video.index', compact('videos'));
    }
}
