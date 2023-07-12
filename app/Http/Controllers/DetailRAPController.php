<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAP\StoreRequest;
use App\Http\Requests\DetailRAP\UpdateRequest;
use App\Models\DetailRAP;
use App\Models\RAP;
use App\Models\Satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DetailRAPController extends Controller
{
    public function index(RAP $RAP): Response {
        $RAP = $RAP->query()
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rap.id_proyek')
            ->where('rap.id_rap', $RAP->id_rap)
            ->first();

        $DetailRAP = DetailRAP::query()
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rap.id_satuan')
            ->where('detail_rap.id_rap', $RAP->id_rap)
            ->orderBy('detail_rap.id_detail_rap', 'asc')->get();

        $Satuan = Satuan::select('id_satuan', 'nama_satuan')->get();

        $Timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.model_id', $RAP->id_rap)
            ->select(
                'timeline.created_at',
                'timeline.catatan',
                'timeline.status_aktivitas',
                'users.name as user_name',
                'roles.name as user_role'
            )
        ->get();

        return Inertia::render('DetailRAP/Index', [
            'rap' => $RAP,
            'detail_rap' => $DetailRAP,
            'satuan' => $Satuan,
            'timeline' => $Timeline
        ]);
    }

    public function store(StoreRequest $request, RAP $RAP): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAP = new DetailRAP;

        $DetailRAP->fill([
            'id_rap' => $RAP->id_rap,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $DetailRAP->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAP $DetailRAP): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAP->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $DetailRAP->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil diperbarui!');
    }

    public function destroy(DetailRAP $DetailRAP): RedirectResponse
    {
        $DetailRAP->delete();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dihapus!');
    }
}
