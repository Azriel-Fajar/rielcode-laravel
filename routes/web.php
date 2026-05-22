<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/privacy', [PageController::class, 'privacy']);
Route::get('/terms', [PageController::class, 'terms']);

Route::get('/studio', [StudioController::class, 'index']);
Route::get('/services', [ServicesController::class, 'index']);

Route::get('/work', [WorkController::class, 'index']);
Route::get('/work/{slug}', [WorkController::class, 'show']);

Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'submit'])->middleware('throttle:5,1');

Route::redirect('/portfolio', '/work', 301);
Route::redirect('/packages', '/services', 301);
Route::redirect('/faq', '/studio#faq', 301);

Route::get('/sitemap.xml', [PageController::class, 'sitemap']);
