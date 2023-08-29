<?php

namespace App\Observers;

use App\Models\DetailPencairanDana;
use App\Models\File;
use App\Models\PencairanDana;

class PencairanDanaObserver
{
    /**
     * Handle the PencairanDana "created" event.
     */
    public function created(PencairanDana $pencairanDana): void
    {
        //
    }

    /**
     * Handle the PencairanDana "updated" event.
     */
    public function updated(PencairanDana $pencairanDana): void
    {
        //
    }

    /**
     * Handle the PencairanDana "deleted" event.
     */
    public function deleted(PencairanDana $pencairanDana): void
    {
        DetailPencairanDana::where('id_pencairan_dana', $pencairanDana->id_pencairan_dana)->delete();
        File::where('model_id', $pencairanDana->id_pencairan_dana)->delete();
    }

    /**
     * Handle the PencairanDana "restored" event.
     */
    public function restored(PencairanDana $pencairanDana): void
    {
        //
    }

    /**
     * Handle the PencairanDana "force deleted" event.
     */
    public function forceDeleted(PencairanDana $pencairanDana): void
    {
        //
    }
}
