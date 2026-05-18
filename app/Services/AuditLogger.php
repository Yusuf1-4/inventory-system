<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Log;

class AuditLogger
{
    /**
     * Record an audit log entry for the currently authenticated user.
     */
    public static function log(
        string $action,
        string $module,
        ?int $recordId = null,
        string $description = '',
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        try {
            AuditLog::create([
                'user_id'     => auth()->id(),
                'action'      => $action,
                'module'      => $module,
                'record_id'   => $recordId,
                'description' => $description,
                'old_values'  => $oldValues,
                'new_values'  => $newValues,
                'ip_address'  => request()->ip(),
                'user_agent'  => mb_substr((string) request()->userAgent(), 0, 512),
            ]);
        } catch (\Throwable $e) {
            Log::warning('AuditLogger failed: ' . $e->getMessage());
        }
    }

    /**
     * Record an audit log entry for a specific user (used for login/logout events).
     */
    public static function logForUser(
        int $userId,
        string $action,
        string $module,
        string $description = ''
    ): void {
        try {
            AuditLog::create([
                'user_id'     => $userId,
                'action'      => $action,
                'module'      => $module,
                'record_id'   => null,
                'description' => $description,
                'old_values'  => null,
                'new_values'  => null,
                'ip_address'  => request()->ip(),
                'user_agent'  => mb_substr((string) request()->userAgent(), 0, 512),
            ]);
        } catch (\Throwable $e) {
            Log::warning('AuditLogger failed: ' . $e->getMessage());
        }
    }
}
