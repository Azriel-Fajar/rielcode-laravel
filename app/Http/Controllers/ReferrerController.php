<?php

namespace App\Http\Controllers;

use App\Models\ReferralCommission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferrerController extends Controller
{
    public function show(Request $request): View
    {
        $referrer = $request->attributes->get('token.gate.row');

        $stats = ReferralCommission::where('referrer_id', $referrer->id)
            ->selectRaw('
                COUNT(*) AS total_referrals,
                COALESCE(SUM(CASE WHEN status = ? THEN commission_amount ELSE 0 END), 0) AS total_earned,
                COALESCE(SUM(CASE WHEN status = ? THEN commission_amount ELSE 0 END), 0) AS total_pending
            ', ['paid', 'pending'])
            ->first();

        $commissions = ReferralCommission::where('referrer_id', $referrer->id)
            ->join('orders', 'orders.id', '=', 'referral_commissions.order_id')
            ->select(
                'referral_commissions.commission_amount',
                'referral_commissions.order_amount',
                'referral_commissions.status',
                'referral_commissions.created_at',
                'orders.package as package_name',
                'orders.invoice_number'
            )
            ->orderByDesc('referral_commissions.created_at')
            ->get();

        return view('pages.referrer', [
            'referrer' => $referrer,
            'stats' => $stats,
            'commissions' => $commissions,
        ]);
    }
}
