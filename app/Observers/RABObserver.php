<?php

namespace App\Observers;

use App\Models\Penagihan;
use App\Models\RAB;

class RABObserver
{
    /**
     * Handle the RAB "created" event.
     */
    public function created(RAB $rab): void
    {
        //
    }

    /**
     * Handle the RAB "updated" event.
     */
    public function updated(RAB $rab): void
    {
        //
    }

    /**
     * Handle the RAB "deleted" event.
     */
    public function deleted(RAB $rab): void
    {
        $penagihanRecords = Penagihan::where('id_proyek', $rab->id_proyek)->get();

        foreach ($penagihanRecords as $penagihan) {
            $penagihan->delete();
        }
    }

    /**
     * Handle the RAB "restored" event.
     */
    public function restored(RAB $rab): void
    {
        //
    }

    /**
     * Handle the RAB "force deleted" event.
     */
    public function forceDeleted(RAB $rab): void
    {
        //
    }
}
