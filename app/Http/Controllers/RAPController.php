<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAP\StoreRequest;
use App\Http\Requests\RAP\UpdateRequest;
use App\Models\Proyek;
use App\Models\RAP;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RAPController extends Controller
{
    public function index(Request $request): Response
    {
        $RAP = DB::table('rap');

        $RAPQuery = $RAP->leftJoin('proyek', 'proyek.id_proyek', '=', 'rap.id_proyek');

        if ($request->isMethod('get') && $request->all()) {
            $RAPQuery = $this->filter($request, $RAPQuery);
        }

        $RAP = $RAPQuery->select(
            'rap.id_rap',
            'rap.status_rap',
            'proyek.id_proyek',
            'proyek.nama_proyek',
            'proyek.tahun_anggaran',
            'proyek.pengguna_jasa',
        )
        ->where('rap.deleted_at', NULL)
        ->latest('rap.id_rap')->paginate(10);

        $Proyek = Proyek::query()
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->select(
                'proyek.id_proyek',
                'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
        ->where('rab.status_rab', '400')
        ->where('rap.id_rap', null)
        ->get();
            
        return Inertia::render('RAP/Index', [
            'rap' => $RAP,
            'proyek' => $Proyek
        ]);
    }

    public function filter($searchRequest, $RAPQuery) {
        $RAPQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', $input . '%');
        });

        return $RAPQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->safe();

            $RAP = new RAP;
            $RAP->id_proyek = $validated->id_proyek;
            $RAP->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAP->id_rap,
                'model_type' => get_class($RAP),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibuat'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, RAP $RAP): RedirectResponse
    {
        $validated = $request->safe();

        $RAP->id_proyek = $validated->id_proyek;
        $RAP->save();

        return redirect()->back()->with('success', 'RAP berhasil diperbarui!');
    }

    public function destroy(RAP $RAP): RedirectResponse
    {
        $RAP->delete();

        return redirect()->back()->with('success', 'RAP berhasil dihapus!');
    }

    public function submit(Request $request, RAP $RAP): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAP) {
            $RAP->status_aktivitas = 'Diajukan';
            $RAP->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAP->id_rap,
                'model_type' => get_class($RAP),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil diajukan!');
    }

    public function approve(Request $request, RAP $RAP): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAP) {
            $role = $request->user()->roles->first()->name;

            if ($role === 'kepala divisi') {
                $status_rap = '100';
                $status_aktivitas_rap = 'Diperiksa';
            } else if ($role === 'direktur utama' || $role === 'admin') {
                $status_rap = '400';
                $status_aktivitas_rap = 'Disetujui';
            }

            $RAP->status_rap = $status_rap;
            $RAP->status_aktivitas = $status_aktivitas_rap;
            $RAP->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAP->id_rap,
                'model_type' => get_class($RAP),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Disetujui'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil disetujui!');
    }

    public function refuse(Request $request, RAP $RAP): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAP) {
            $RAP->status_aktivitas = 'Dibuat';
            $RAP->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAP->id_rap,
                'model_type' => get_class($RAP),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil ditolak!');
    }
}