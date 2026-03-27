<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LayananUtama;
use App\Models\LayananPerizinan;

class DashboardController extends Controller
{
    public function index()
    {
        $layananUtama = LayananUtama::active()
            ->ordered()
            ->take(6)           // tampilkan maksimal 6 di dashboard
            ->get();

        $layananPerizinan = LayananPerizinan::active()
            ->ordered()
            ->take(8)           // tampilkan maksimal 8 di dashboard
            ->get();

        return view('backend.index', compact('layananUtama', 'layananPerizinan'));
    }
}
