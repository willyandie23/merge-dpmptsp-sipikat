<?php

namespace App\Http\Controllers\Frontend\publication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('frontend.publication.news.index');
    }

    public function show($slug)
    {
        return view('frontend.publication.news.show');
    }
}
