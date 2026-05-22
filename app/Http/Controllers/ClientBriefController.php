<?php

namespace App\Http\Controllers;

use App\Mail\ClientBriefMail;
use App\Models\Order;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ClientBriefController extends Controller
{
    public function show(Request $request): View
    {
        $row = $request->attributes->get('token.gate.row');
        $order = Order::findOrFail($row->order_id);

        return view('pages.brief', [
            'order' => $order,
            'token' => $request->query('t'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $token = $request->input('t', '');
        $row = $request->attributes->get('token.gate.row');
        $order = Order::findOrFail($row->order_id);

        $data = $request->validate([
            'business'    => ['required', 'string', 'max:5000'],
            'goals'       => ['required', 'string', 'max:5000'],
            'audience'    => ['required', 'string', 'max:5000'],
            'success'     => ['required', 'string', 'max:5000'],
            'brand_style' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::to(config('mail.from.address'))->send(new ClientBriefMail($order, $data));
        } catch (\Throwable $e) {
            AuditLogger::log('CLIENT_BRIEF_MAIL_FAIL', 'error', $order->email, [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return redirect()->route('brief.show', ['t' => $token])
                ->withErrors(['brief' => 'Failed to send brief. Please try again.']);
        }

        AuditLogger::log('CLIENT_BRIEF_SUBMITTED', 'info', $order->email, [
            'order_id' => $order->id,
        ]);

        return redirect()->route('brief.thanks');
    }
}
