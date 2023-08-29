<?php

namespace App\Observers;

use App\Models\DetailPenagihan;
use App\Models\Penagihan;

class PenagihanObserver
{
    /**
     * Handle the Penagihan "created" event.
     */
    public function created(Penagihan $penagihan): void
    {
        //
    }

    /**
     * Handle the Penagihan "updated" event.
     */
    public function updated(Penagihan $penagihan): void
    {
        //
    }

    /**
     * Handle the Penagihan "deleted" event.
     */
    public function deleted(Penagihan $penagihan): void
    {
        DetailPenagihan::where('id_penagihan', $penagihan->id_penagihan)->delete();
    }

    /**
     * Handle the Penagihan "restored" event.
     */
    public function restored(Penagihan $penagihan): void
    {
        //
    }

    /**
     * Handle the Penagihan "force deleted" event.
     */
    public function forceDeleted(Penagihan $penagihan): void
    {
        //
    }
}
