<?php

namespace App\Http\Controllers\Frontend\profile;

use App\Http\Controllers\Controller;
use App\Models\TentangDpmptsp;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $tentang = TentangDpmptsp::first();

        return view('frontend.profile.about.index', compact('tentang'));
    }
}
