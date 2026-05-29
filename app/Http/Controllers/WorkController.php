<?php

namespace App\Http\Controllers;

use App\Models\Project;

class WorkController extends Controller
{
    public function index()
    {
        $projects = Project::visible()->orderBy('sort_order')->get();

        return view('pages.work.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::visible()->where('slug', $slug)->firstOrFail();

        return view('pages.work.show', compact('project'));
    }
}
