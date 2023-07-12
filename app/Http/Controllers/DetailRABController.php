<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAB\StoreRequest;
use App\Http\Requests\DetailRAB\UpdateRequest;
use App\Models\DetailRAB;
use App\Models\RAB;
use App\Models\Satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DetailRABController extends Controller
{
    public function index(RAB $RAB): Response {
        $RAB = $RAB->query()
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek')
            ->where('rab.id_rab', $RAB->id_rab)
            ->first();

        $DetailRAB = DetailRAB::query()
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rab.id_satuan')
            ->where('detail_rab.id_rab', $RAB->id_rab)
            ->orderBy('detail_rab.id_detail_rab', 'asc')->get();

        $Satuan = Satuan::select('id_satuan', 'nama_satuan')->get();

        $Timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.model_id', $RAB->id_rab)
            ->select(
                'timeline.created_at',
                'timeline.catatan',
                'timeline.status_aktivitas',
                'users.name as user_name',
                'roles.name as user_role'
            )
        ->get();

        return Inertia::render('DetailRAB/Index', [
            'rab' => $RAB,
            'detail_rab' => $DetailRAB,
            'satuan' => $Satuan,
            'timeline' => $Timeline
        ]);
    }

    public function store(StoreRequest $request, RAB $RAB): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAB = new DetailRAB;

        $DetailRAB->fill([
            'id_rab' => $RAB->id_rab,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $DetailRAB->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAB $DetailRAB): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAB->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $DetailRAB->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil diperbarui!');
    }

    public function destroy(DetailRAB $DetailRAB): RedirectResponse
    {
        $DetailRAB->delete();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dihapus!');
    }
}
