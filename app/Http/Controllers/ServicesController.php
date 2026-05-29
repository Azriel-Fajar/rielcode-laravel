<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Package;
use App\Models\PackageAddon;

class ServicesController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_visible', true)->orderBy('sort_order')->get();
        $addons = PackageAddon::where('is_visible', true)->orderBy('sort_order')->get();
        $faqs = Faq::where('show_on_services', true)->where('is_visible', true)->orderBy('sort_order')->get();

        return view('pages.services', compact('packages', 'addons', 'faqs'));
    }
}
