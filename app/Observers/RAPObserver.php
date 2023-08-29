<?php

namespace App\Observers;

use App\Models\PengajuanDana;
use App\Models\RAP;

class RAPObserver
{
    /**
     * Handle the RAP "created" event.
     */
    public function created(RAP $rap): void
    {
        //
    }

    /**
     * Handle the RAP "updated" event.
     */
    public function updated(RAP $rap): void
    {
        //
    }

    /**
     * Handle the RAP "deleted" event.
     */
    public function deleted(RAP $rap): void
    {
        $pengajuanDanaRecords = PengajuanDana::where('id_proyek', $rap->id_proyek)->get();

        foreach ($pengajuanDanaRecords as $pengajuanDana) {
            $pengajuanDana->delete();
        }
    }

    /**
     * Handle the RAP "restored" event.
     */
    public function restored(RAP $rap): void
    {
        //
    }

    /**
     * Handle the RAP "force deleted" event.
     */
    public function forceDeleted(RAP $rap): void
    {
        //
    }
}
