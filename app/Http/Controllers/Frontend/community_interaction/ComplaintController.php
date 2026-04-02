<?php

namespace App\Http\Controllers\Frontend\community_interaction;

use App\Http\Controllers\Controller;
use App\Models\BannerIntegritas;
use App\Models\MekanismePengaduan;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $banners = BannerIntegritas::active()->latest('id')->get();

        $mekanismes = MekanismePengaduan::active()
            ->orderBy('position')
            ->get();

        return view('frontend.community-interaction.complaint.index', compact('banners', 'mekanismes'));
    }
}
