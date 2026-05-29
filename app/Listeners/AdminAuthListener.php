<?php

namespace App\Listeners;

use App\Services\AuditLogger;

class AdminAuthListener
{
    public function handleLogin(object $event): void
    {
        $user = $event->user ?? null;
        AuditLogger::log(
            eventCode: 'ADMIN_LOGIN_OK',
            severity: 'info',
            message: 'Admin login: '.($user?->email ?? 'unknown'),
            actor: $user?->email,
        );
    }

    public function handleLoginFail(object $event): void
    {
        AuditLogger::log(
            eventCode: 'ADMIN_LOGIN_FAIL',
            severity: 'warning',
            message: 'Failed admin login attempt',
        );
    }

    public function handleLogout(object $event): void
    {
        $user = $event->user ?? null;
        AuditLogger::log(
            eventCode: 'ADMIN_LOGOUT',
            severity: 'info',
            message: 'Admin logout: '.($user?->email ?? 'unknown'),
            actor: $user?->email,
        );
    }
}
