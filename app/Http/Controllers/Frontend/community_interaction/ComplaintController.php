<?php

namespace App\Http\Controllers\Frontend\community_interaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return view('frontend.community-interaction.complaint.index');
    }
}
