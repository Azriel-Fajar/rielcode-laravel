<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\SiteSetting;

class StudioController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('show_on_studio', true)->where('is_visible', true)->orderBy('sort_order')->get();
        $studioHeroImage = SiteSetting::get('studio.hero_image');
        $studioPortraitImage = SiteSetting::get('studio.portrait_image');

        return view('pages.studio', compact('faqs', 'studioHeroImage', 'studioPortraitImage'));
    }
}
