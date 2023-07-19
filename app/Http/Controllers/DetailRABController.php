<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAB\StoreRequest;
use App\Http\Requests\DetailRAB\UpdateRequest;
use App\Models\DetailRAB;
use App\Models\RAB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DetailRABController extends Controller
{
    public function index(RAB $rab): Response
    {
        $rab = DB::table('rab')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek')
            ->where('rab.deleted_at', null)
            ->where('rab.id_rab', $rab->id_rab)
            ->first();

        $detailRab = DB::table('detail_rab')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rab.id_satuan')
            ->where('detail_rab.deleted_at', null)
            ->where('detail_rab.id_rab', $rab->id_rab)
            ->orderBy('detail_rab.id_detail_rab', 'asc')
            ->get();

        $satuan = DB::table('satuan')
            ->where('deleted_at', null)
            ->select('id_satuan', 'nama_satuan')
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $rab->id_rab)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->orderBy('timeline.created_at', 'asc')
            ->get();

        return Inertia::render('DetailRAB/Index', [
            'rab' => $rab,
            'detail_rab' => $detailRab,
            'satuan' => $satuan,
            'timeline' => $timeline
        ]);
    }

    public function store(StoreRequest $request, RAB $rab): RedirectResponse
    {
        $validated = $request->safe();

        $detailRab = new DetailRAB;

        $detailRab->fill([
            'id_rab' => $rab->id_rab,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $detailRab->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAB $detailRab): RedirectResponse
    {
        $validated = $request->safe();

        $detailRab->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $detailRab->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil diperbarui!');
    }

    public function destroy(DetailRAB $detailRab): RedirectResponse
    {
        $detailRab->delete();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dihapus!');
    }
}