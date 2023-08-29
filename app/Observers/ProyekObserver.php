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
        //
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
        $rabRecords = RAB::where('id_proyek', $proyek->id_proyek)->get();
        $rapRecords = RAP::where('id_proyek', $proyek->id_proyek)->get();

        foreach ($rabRecords as $rab) {
            $rab->delete();
        }

        foreach ($rapRecords as $rap) {
            $rap->delete();
        }
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
