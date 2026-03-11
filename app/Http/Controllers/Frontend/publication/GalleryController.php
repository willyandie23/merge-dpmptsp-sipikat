<?php

namespace App\Http\Controllers\Frontend\publication;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $gallerys    = Gallery::active()->latest()->paginate(18);

        return view('frontend.publication.gallery.index', compact('gallerys'));
    }
}
