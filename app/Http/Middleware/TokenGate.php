<?php

namespace App\Http\Middleware;

use App\Services\AuditLogger;
use App\Support\ErrorCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards token-gated portals.
 *
 * Usage in routes:
 *   ->middleware('token.gate:order')   → validates ?t= against order_access_tokens
 *   ->middleware('token.gate:testimonial') → validates ?t= against testimonial_invites
 *   ->middleware('token.gate:referrer')    → validates ?code= against referrers
 *
 * Sets request attributes for downstream controllers:
 *   - token.gate.row  : the resolved DB row
 *   - token.gate.type : the gate type string
 */
class TokenGate
{
    public function handle(Request $request, Closure $next, string $type = 'order'): Response
    {
        $result = match ($type) {
            'order' => $this->checkOrderToken($request),
            'testimonial' => $this->checkTestimonialToken($request),
            'referrer' => $this->checkReferrerCode($request),
            default => null,
        };

        if ($result === null) {
            AuditLogger::log('TOKEN_GATE_FAIL', 'warn', null, [
                'type' => $type,
                'token' => $request->query('t') ?? $request->query('code') ?? '',
            ]);
            abort(403, ErrorCodes::userMsg('RC-TOKEN-001'));
        }

        $request->attributes->set('token.gate.row', $result);
        $request->attributes->set('token.gate.type', $type);

        return $next($request);
    }

    private function checkOrderToken(Request $request): ?object
    {
        $token = trim($request->query('t', ''));

        if ($token === '' || ! preg_match('/^[a-f0-9]{64}$/', $token)) {
            return null;
        }

        $row = DB::table('order_access_tokens as t')
            ->join('orders as o', 'o.id', '=', 't.order_id')
            ->where('t.token', $token)
            ->first();

        if (! $row) {
            return null;
        }

        if ($row->deactivated_at !== null) {
            abort(403, ErrorCodes::userMsg('RC-TOKEN-003'));
        }

        return $row;
    }

    private function checkTestimonialToken(Request $request): ?object
    {
        $token = trim($request->query('t', ''));

        if ($token === '' || strlen($token) > 128) {
            return null;
        }

        $row = DB::table('testimonial_invites')
            ->where('token', $token)
            ->first();

        if (! $row) {
            return null;
        }

        if ($row->used_at !== null) {
            abort(403, ErrorCodes::userMsg('RC-TOKEN-002'));
        }

        return $row;
    }

    private function checkReferrerCode(Request $request): ?object
    {
        $code = strtoupper(trim($request->query('code', '')));

        if ($code === '') {
            return null;
        }

        return DB::table('referrers')
            ->where('code', $code)
            ->where('status', 'active')
            ->first();
    }
}
