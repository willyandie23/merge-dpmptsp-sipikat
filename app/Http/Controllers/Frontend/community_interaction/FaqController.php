<?php

namespace App\Http\Controllers\Frontend\community_interaction;

use App\Http\Controllers\Controller;
use App\Models\BannerFaq;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $banners = BannerFaq::active()->latest('id')->get();
        $faqs = Faq::active()->orderBy('id')->get();

        return view('frontend.community-interaction.faq.index', compact('banners', 'faqs'));
    }
}
