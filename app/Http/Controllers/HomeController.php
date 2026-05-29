<?php

namespace App\Http\Controllers;

use App\Models\Package;
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
        $packages = Package::visible()
            ->whereIn('slug', ['starter', 'pro', 'business'])
            ->orderBy('sort_order')
            ->get();

        return view('pages.home', compact('featuredWork', 'testimonials', 'studioPortraitImage', 'packages'));
    }
}
