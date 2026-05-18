<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Login::class;
        \Illuminate\Support\Facades\Event::listen(Login::class, function (Login $event) {
            try {
                AuditLog::create([
                    'user_id'     => $event->user->id,
                    'action'      => 'login',
                    'module'      => 'Auth',
                    'description' => "User logged in: {$event->user->name} ({$event->user->email})",
                    'ip_address'  => request()->ip(),
                    'user_agent'  => mb_substr((string) request()->userAgent(), 0, 512),
                ]);
            } catch (\Throwable $e) {
                Log::warning('AuditLogger failed: ' . $e->getMessage());
            }
        });

        \Illuminate\Support\Facades\Event::listen(Logout::class, function (Logout $event) {
            if (!$event->user) return;
            try {
                AuditLog::create([
                    'user_id'     => $event->user->id,
                    'action'      => 'logout',
                    'module'      => 'Auth',
                    'description' => "User logged out: {$event->user->name} ({$event->user->email})",
                    'ip_address'  => request()->ip(),
                    'user_agent'  => mb_substr((string) request()->userAgent(), 0, 512),
                ]);
            } catch (\Throwable $e) {
                Log::warning('AuditLogger failed: ' . $e->getMessage());
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
