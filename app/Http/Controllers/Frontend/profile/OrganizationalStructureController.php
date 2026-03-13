<?php

namespace App\Http\Controllers\Frontend\profile;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class OrganizationalStructureController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::with(['strukturOrganisasi' => function ($q) {
                $q->where('is_pejabat', 1);
            }])
            ->orderBy('position')
            ->get();

        return view('frontend.profile.organizational-structure.index', compact('bidangs'));
    }
}
