<?php

namespace App\Http\Controllers\Frontend\profile;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::with(['strukturOrganisasi' => function ($q) {
                $q->orderBy('is_pejabat', 'desc')->orderBy('id');
            }])
            ->where('name', '!=', 'Kepala Dinas')
            ->orderBy('position')
            ->get();

        return view('frontend.profile.field.index', compact('bidangs'));
    }
}
