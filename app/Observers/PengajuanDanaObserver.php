<?php

namespace App\Observers;

use App\Models\DetailPengajuanDana;
use App\Models\File;
use App\Models\PencairanDana;
use App\Models\PengajuanDana;

class PengajuanDanaObserver
{
    /**
     * Handle the PengajuanDana "created" event.
     */
    public function created(PengajuanDana $pengajuanDana): void
    {
        //
    }

    /**
     * Handle the PengajuanDana "updated" event.
     */
    public function updated(PengajuanDana $pengajuanDana): void
    {
        //
    }

    /**
     * Handle the PengajuanDana "deleted" event.
     */
    public function deleted(PengajuanDana $pengajuanDana): void
    {
        $pencairanDanaRecords = PencairanDana::where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)->get();

        foreach ($pencairanDanaRecords as $pencairanDana) {
            $pencairanDana->delete();
        }

        DetailPengajuanDana::where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)->delete();
        File::where('model_id', $pengajuanDana->id_pengajuan_dana)->delete();
    }

    /**
     * Handle the PengajuanDana "restored" event.
     */
    public function restored(PengajuanDana $pengajuanDana): void
    {
        //
    }

    /**
     * Handle the PengajuanDana "force deleted" event.
     */
    public function forceDeleted(PengajuanDana $pengajuanDana): void
    {
        //
    }
}
