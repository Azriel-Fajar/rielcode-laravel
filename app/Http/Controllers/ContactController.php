<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmission as ContactMail;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(Request $request)
    {
        $sent = $request->query('sent') === '1';

        return view('pages.contact', compact('sent'));
    }

    public function submit(Request $request)
    {
        // honeypot
        if ($request->filled('website')) {
            return redirect('/contact');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'project_type' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $data = array_merge($validated, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        ContactSubmission::create($data);

        try {
            Mail::to('support@rielcode.com')
                ->send(new ContactMail($data));
        } catch (\Throwable) {
            // DB is source of truth; mail failure is non-fatal
        }

        return redirect('/contact?sent=1');
    }
}
