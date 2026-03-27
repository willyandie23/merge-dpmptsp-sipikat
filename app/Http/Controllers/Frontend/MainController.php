<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BannerDashboard;

class MainController extends Controller
{
    public function index()
    {
        $banners = BannerDashboard::where('is_active', 1)->get();

        return view('frontend.main.index', compact('banners'));
    }
}
