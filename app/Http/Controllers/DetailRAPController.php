<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAP\StoreRequest;
use App\Http\Requests\DetailRAP\UpdateRequest;
use App\Models\DetailRAP;
use App\Models\RAP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DetailRAPController extends Controller
{
    public function index(RAP $rap): Response {
        $rap = DB::table('rap')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rap.id_proyek')
            ->where('rap.deleted_at', null)
            ->where('rap.id_rap', $rap->id_rap)
            ->first();

        $detailRap = DB::table('detail_rap')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rap.id_satuan')
            ->where('detail_rap.deleted_at', null)
            ->where('detail_rap.id_rap', $rap->id_rap)
            ->orderBy('detail_rap.id_detail_rap', 'asc')
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
            ->where('timeline.model_id', $rap->id_rap)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->orderBy('timeline.created_at', 'asc')
            ->get();

        return Inertia::render('DetailRAP/Index', [
            'rap' => $rap,
            'detail_rap' => $detailRap,
            'satuan' => $satuan,
            'timeline' => $timeline
        ]);
    }

    public function store(StoreRequest $request, RAP $rap): RedirectResponse
    {
        $validated = $request->safe();

        $detailRap = new DetailRAP;

        $detailRap->fill([
            'id_rap' => $rap->id_rap,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $detailRap->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAP $detailRap): RedirectResponse
    {
        $validated = $request->safe();

        $detailRap->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $detailRap->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil diperbarui!');
    }

    public function destroy(DetailRAP $detailRap): RedirectResponse
    {
        $detailRap->delete();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dihapus!');
    }
}
