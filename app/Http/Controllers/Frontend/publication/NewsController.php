<?php

namespace App\Http\Controllers\Frontend\publication;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // $perPage = request()->get('page', 1) == 1 ? 9 : 9;
        $news    = News::active()->latest()->paginate(9);

        return view('frontend.publication.news.index', compact('news'));
    }

    public function show($id)
    {
        $newsItem = News::active()->findOrFail($id);

        $latestNews = News::active()
                        ->where('id', '!=', $id)
                        ->latest()
                        ->take(5)
                        ->get();

        return view('frontend.publication.news.show', compact('newsItem', 'latestNews'));
    }
}
