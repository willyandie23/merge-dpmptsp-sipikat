<?php

namespace App\Http\Controllers\Frontend\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('frontend.profile.about.index');
    }
}
