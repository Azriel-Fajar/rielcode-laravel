<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

        $testimonial = Testimonial::approved()->orderBy('id')->first();

        return view('pages.home', compact('featuredWork', 'testimonial'));
    }
}
