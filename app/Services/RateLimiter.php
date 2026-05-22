<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class RateLimiter
{
    const LIMIT_HOUR_MAX   = 30;
    const LIMIT_DAY_MAX    = 200;
    const LIMIT_TOKENS_MAX = 30000;

    public static function check(string $ip): void
    {
        $hourWindow = now()->format('Y-m-d H:00:00');
        $dayWindow  = now()->format('Y-m-d 00:00:00');

        $rows = DB::table('rate_limits')
            ->where('ip_address', $ip)
            ->where(function ($q) use ($hourWindow, $dayWindow) {
                $q->where(fn($q2) => $q2->where('bucket', 'hour')->where('window_start', $hourWindow))
                  ->orWhere(fn($q2) => $q2->where('bucket', 'day')->where('window_start', $dayWindow));
            })
            ->get(['bucket', 'counter'])
            ->keyBy('bucket');

        $hourCount = (int) ($rows->get('hour')->counter ?? 0);
        $dayCount  = (int) ($rows->get('day')->counter ?? 0);

        if ($hourCount >= self::LIMIT_HOUR_MAX) {
            throw new RuntimeException('RC-RATE-001');
        }
        if ($dayCount >= self::LIMIT_DAY_MAX) {
            throw new RuntimeException('RC-RATE-002');
        }

        DB::statement(
            "INSERT INTO rate_limits (ip_address, bucket, window_start, counter)
             VALUES (?, 'hour', ?, 1)
             ON DUPLICATE KEY UPDATE counter = counter + 1",
            [$ip, $hourWindow]
        );
        DB::statement(
            "INSERT INTO rate_limits (ip_address, bucket, window_start, counter)
             VALUES (?, 'day', ?, 1)
             ON DUPLICATE KEY UPDATE counter = counter + 1",
            [$ip, $dayWindow]
        );

        self::gc();
    }

    public static function checkTokens(string $ip): void
    {
        $dayWindow = now()->format('Y-m-d 00:00:00');

        $cur = (int) DB::table('rate_limits')
            ->where('ip_address', $ip)
            ->where('bucket', 'tokens_day')
            ->where('window_start', $dayWindow)
            ->value('counter');

        if ($cur >= self::LIMIT_TOKENS_MAX) {
            throw new RuntimeException('RC-RATE-003');
        }
    }

    public static function addTokens(string $ip, int $tokens): void
    {
        if ($tokens <= 0) {
            return;
        }

        $dayWindow = now()->format('Y-m-d 00:00:00');

        DB::statement(
            "INSERT INTO rate_limits (ip_address, bucket, window_start, counter)
             VALUES (?, 'tokens_day', ?, ?)
             ON DUPLICATE KEY UPDATE counter = counter + VALUES(counter)",
            [$ip, $dayWindow, $tokens]
        );
    }

    private static function gc(): void
    {
        if (random_int(1, 100) !== 1) {
            return;
        }

        try {
            DB::statement("DELETE FROM rate_limits WHERE window_start < (NOW() - INTERVAL 3 DAY)");
        } catch (Throwable $e) {
            error_log('RateLimiter::gc failed: ' . $e->getMessage());
        }
    }
}
