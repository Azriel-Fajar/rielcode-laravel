<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PublicInvoiceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientBriefController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ReferrerController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

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

// Order flow
Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/order/resume', [OrderController::class, 'resume'])->name('order.resume');

Route::get('/custom-plan', [CustomPlanController::class, 'create'])->name('custom-plan.create');
Route::post('/custom-plan/resume', [CustomPlanController::class, 'resume'])->name('custom-plan.resume');
Route::post('/custom-plan', [CustomPlanController::class, 'store'])->name('custom-plan.store');

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

Route::redirect('/terms-and-conditions', '/terms', 301);

// Phase 2.3 — Token-gated portals
Route::get('/brief', [ClientBriefController::class, 'show'])->middleware('token.gate:order')->name('brief.show');
Route::post('/brief', [ClientBriefController::class, 'store'])->middleware('token.gate:order')->name('brief.store');
Route::get('/brief/thanks', fn() => view('pages.brief-thanks'))->name('brief.thanks');

Route::get('/progress', [ProgressController::class, 'show'])->middleware('token.gate:order')->name('progress.show');

Route::get('/testimonial', [TestimonialController::class, 'show'])->middleware('token.gate:testimonial')->name('testimonial.show');
Route::post('/testimonial', [TestimonialController::class, 'store'])->middleware('token.gate:testimonial')->name('testimonial.store');
Route::get('/testimonial/thanks', fn() => view('pages.testimonial-thanks'))->name('testimonial.thanks');

Route::get('/referrer', [ReferrerController::class, 'show'])->middleware('token.gate:referrer')->name('referrer.show');

// Public invoice (no auth)
Route::get('/i/{invoiceNumber}', [PublicInvoiceController::class, 'show'])->name('invoice.show');
Route::get('/i/{invoiceNumber}/pdf', [PublicInvoiceController::class, 'pdf'])->name('invoice.pdf');

// Chatbot API
Route::middleware('rate.chat')->group(function () {
    Route::post('/api/chat',         [ChatController::class, 'send'])->name('chat.send');
    Route::post('/api/chat/stream',  [ChatController::class, 'stream'])->name('chat.stream');
});
