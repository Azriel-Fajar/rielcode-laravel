<?php

namespace App\Http\Controllers;

use App\Mail\TestimonialThankYouMail;
use App\Models\Testimonial;
use App\Models\TestimonialInvite;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function show(Request $request): View
    {
        $invite = $request->attributes->get('token.gate.row');

        return view('pages.testimonial-submit', [
            'token'  => $request->query('t'),
            'invite' => $invite,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $token  = $request->input('t', '');
        $invite = $request->attributes->get('token.gate.row');

        // Honeypot
        if ($request->input('website', '') !== '') {
            abort(400);
        }

        $data = $request->validate([
            'client_name'    => ['required', 'string', 'max:80'],
            'business_name'  => ['required', 'string', 'max:100'],
            'role_title'     => ['required', 'string', 'max:80'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'project_url'    => ['required', 'url', 'max:255'],
            'problem_before' => ['required', 'string', 'min:40', 'max:300'],
            'solution_after' => ['required', 'string', 'min:50', 'max:500'],
            'recommendation' => ['required', 'string', 'min:40', 'max:300'],
            'headline'       => ['nullable', 'string', 'max:120'],
            'client_email'   => ['nullable', 'email', 'max:120'],
            'consent_given'  => ['accepted'],
        ]);

        $testimonial = Testimonial::create([
            'client_name'    => $data['client_name'],
            'business_name'  => $data['business_name'],
            'role_title'     => $data['role_title'],
            'rating'         => (int) $data['rating'],
            'project_url'    => $data['project_url'],
            'problem_before' => $data['problem_before'],
            'solution_after' => $data['solution_after'],
            'recommendation' => $data['recommendation'],
            'headline'       => $data['headline'] ?? null,
            'client_email'   => $data['client_email'] ?? null,
            'consent_given'  => 1,
            'status'         => 'pending',
            'ip_address'     => $request->ip(),
            'submitted_at'   => now(),
        ]);

        TestimonialInvite::where('id', $invite->id)->update([
            'used_at'         => now(),
            'testimonial_id'  => $testimonial->id,
        ]);

        AuditLogger::log('TESTIMONIAL_SUBMITTED', 'info', $data['client_name'], [
            'testimonial_id' => $testimonial->id,
        ]);

        if (!empty($data['client_email'])) {
            try {
                Mail::to($data['client_email'])->send(new TestimonialThankYouMail($data));
            } catch (\Throwable) {
                // silent — submission already saved
            }
        }

        return redirect()->route('testimonial.thanks');
    }
}
