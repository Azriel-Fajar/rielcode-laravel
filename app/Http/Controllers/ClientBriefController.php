<?php

namespace App\Http\Controllers;

use App\Mail\BriefCompleteMail;
use App\Mail\ClientBriefMail;
use App\Models\Order;
use App\Models\OrderAccessToken;
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

        if ($order->brief_submitted_at !== null) {
            return view('pages.brief-thanks');
        }

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

        if ($order->brief_submitted_at !== null) {
            return redirect()->route('brief.thanks');
        }

        $data = $request->validate([
            'business' => ['required', 'string', 'max:5000'],
            'goals' => ['required', 'string', 'max:5000'],
            'audience' => ['required', 'string', 'max:5000'],
            'success' => ['required', 'string', 'max:5000'],
            'brand_style' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::to('support@rielcode.com')->send(new ClientBriefMail($order, $data));
        } catch (\Throwable $e) {
            AuditLogger::log('CLIENT_BRIEF_MAIL_FAIL', 'error', $order->email, [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('brief.show', ['t' => $token])
                ->withErrors(['brief' => 'Failed to send brief. Please try again.']);
        }

        $accessToken = OrderAccessToken::where('order_id', $order->id)->whereNull('deactivated_at')->first();
        if ($accessToken) {
            $progressUrl = config('app.portal_urls.progress').'/progress?t='.$accessToken->token;
            try {
                Mail::to($order->email, $order->order_name)->send(new BriefCompleteMail($order, $progressUrl));
            } catch (\Throwable $e) {
                AuditLogger::log('BRIEF_COMPLETE_MAIL_FAIL', 'error', $order->email, [
                    'order_id' => $order->id,
                    'err' => $e->getMessage(),
                ]);
            }
        }

        $order->brief_submitted_at = now();
        $order->save();

        AuditLogger::log('CLIENT_BRIEF_SUBMITTED', 'info', $order->email, [
            'order_id' => $order->id,
        ]);

        return redirect()->route('brief.thanks');
    }
}
