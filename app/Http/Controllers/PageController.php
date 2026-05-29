<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function sitemap()
    {
        $projects = Project::visible()->orderBy('sort_order')->get(['slug']);

        return response()
            ->view('pages.sitemap', compact('projects'))
            ->header('Content-Type', 'application/xml');
    }
}
