<?php

namespace App\Observers;

use App\Models\Proyek;
use App\Models\RAB;
use App\Models\RAP;

class ProyekObserver
{
    /**
     * Handle the Proyek "created" event.
     */
    public function created(Proyek $proyek): void
    {
        RAB::create(['id_proyek' => $proyek->id_proyek]);
        RAP::create(['id_proyek' => $proyek->id_proyek]);
    }

    /**
     * Handle the Proyek "updated" event.
     */
    public function updated(Proyek $proyek): void
    {
        //
    }

    /**
     * Handle the Proyek "deleted" event.
     */
    public function deleted(Proyek $proyek): void
    {
        //
    }

    /**
     * Handle the Proyek "restored" event.
     */
    public function restored(Proyek $proyek): void
    {
        //
    }

    /**
     * Handle the Proyek "force deleted" event.
     */
    public function forceDeleted(Proyek $proyek): void
    {
        //
    }
}
