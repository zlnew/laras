<?php

namespace App\Providers;

use App\Models\Penagihan;
use App\Models\PencairanDana;
use App\Models\PengajuanDana;
use App\Models\Proyek;
use App\Models\RAB;
use App\Models\RAP;
use App\Observers\PenagihanObserver;
use App\Observers\PencairanDanaObserver;
use App\Observers\PengajuanDanaObserver;
use App\Observers\ProyekObserver;
use App\Observers\RABObserver;
use App\Observers\RAPObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        Proyek::observe(ProyekObserver::class);
        RAB::observe(RABObserver::class);
        RAP::observe(RAPObserver::class);
        PengajuanDana::observe(PengajuanDanaObserver::class);
        PencairanDana::observe(PencairanDanaObserver::class);
        Penagihan::observe(PenagihanObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
