<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredWork = Project::visible()
            ->where('layout', 'featured')
            ->orderBy('sort_order')
            ->limit(2)
            ->get();

        $testimonials = Testimonial::approved()->orderBy('reviewed_at', 'desc')->get();
        $studioPortraitImage = SiteSetting::get('studio.portrait_image');

        return view('pages.home', compact('featuredWork', 'testimonials', 'studioPortraitImage'));
    }
}
