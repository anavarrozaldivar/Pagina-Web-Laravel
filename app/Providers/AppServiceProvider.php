<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use App\Observers\ActivityObserver;
use App\Support\ActivityLogService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::observe(ActivityObserver::class);
        Role::observe(ActivityObserver::class);
        Content::observe(ActivityObserver::class);
        Setting::observe(ActivityObserver::class);
        Notification::observe(ActivityObserver::class);

        Event::listen(Login::class, function (Login $event): void {
            ActivityLogService::record(
                'login',
                $event->user,
                $event->user,
                'Inició sesión.'
            );
        });

        Event::listen(Logout::class, function (Logout $event): void {
            ActivityLogService::record(
                'logout',
                $event->user,
                $event->user,
                'Cerró sesión.'
            );
        });
    }
}