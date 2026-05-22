<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class AuditLogger
{
    public static function log(
        string $eventCode,
        string $severity = 'info',
        ?string $actor = null,
        array $meta = [],
        ?string $refTable = null,
        ?int $refId = null,
        ?string $message = null
    ): void {
        try {
            $validSeverities = ['info', 'warn', 'error'];

            DB::table('audit_log')->insert([
                'event_code' => substr($eventCode, 0, 32),
                'severity'   => in_array($severity, $validSeverities, true) ? $severity : 'info',
                'actor'      => $actor !== null ? substr($actor, 0, 120) : null,
                'ip_address' => app()->runningInConsole() ? 'cli' : request()->ip(),
                'ref_table'  => $refTable !== null ? substr($refTable, 0, 64) : null,
                'ref_id'     => $refId,
                'message'    => $message !== null ? substr($message, 0, 255) : null,
                'meta'       => $meta ? json_encode($meta, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'created_at' => now(),
            ]);
        } catch (Throwable $e) {
            error_log('AuditLogger::log failed: ' . $e->getMessage());
        }
    }
}
