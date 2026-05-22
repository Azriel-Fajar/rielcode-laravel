<?php

namespace App\Http\Middleware;

use App\Services\AuditLogger;
use App\Services\RateLimiter;
use App\Support\ErrorCodes;
use Closure;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class RateLimitChat
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        try {
            RateLimiter::check($ip);
            RateLimiter::checkTokens($ip);
        } catch (RuntimeException $e) {
            $code = $e->getMessage();

            AuditLogger::log('RATE_LIMIT_HIT', 'warn', $ip, [
                'code'   => $code,
                'bucket' => match ($code) {
                    'RC-RATE-001' => 'hour',
                    'RC-RATE-002' => 'day',
                    'RC-RATE-003' => 'tokens_day',
                    default       => 'unknown',
                },
            ]);

            $entry = ErrorCodes::errorResponse($code);

            return response()->json([
                'ok'    => false,
                'reply' => $entry['reply'],
                'code'  => $code,
            ], $entry['http']);
        }

        return $next($request);
    }
}
