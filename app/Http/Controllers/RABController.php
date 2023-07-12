<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAB\StoreRequest;
use App\Http\Requests\RAB\TaxRequest;
use App\Http\Requests\RAB\UpdateRequest;
use App\Models\Proyek;
use App\Models\RAB;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RABController extends Controller
{
    public function index(Request $request): Response
    {
        $RAB = DB::table('rab');

        $RABQuery = $RAB->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek');

        if ($request->isMethod('get') && $request->all()) {
            $RABQuery = $this->filter($request, $RABQuery);
        }

        $RAB = $RABQuery->select(
            'rab.id_rab',
            'rab.status_rab',
            'proyek.id_proyek',
            'proyek.nama_proyek',
            'proyek.tahun_anggaran',
            'proyek.pengguna_jasa',
        )
        ->where('rab.deleted_at', NULL)
        ->latest('rab.id_rab')->paginate(10);

        $Proyek = Proyek::query()
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->select(
                'proyek.id_proyek',
                'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
        ->where('rab.id_rab', null)
        ->get();
            
        return Inertia::render('RAB/Index', [
            'rab' => $RAB,
            'proyek' => $Proyek
        ]);
    }

    public function filter($searchRequest, $RABQuery) {
        $RABQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', $input . '%');
        });

        return $RABQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->safe();

            $RAB = new RAB;
            $RAB->id_proyek = $validated->id_proyek;
            $RAB->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAB->id_rab,
                'model_type' => get_class($RAB),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibuat'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, RAB $RAB): RedirectResponse
    {
        $validated = $request->safe();

        $RAB->id_proyek = $validated->id_proyek;
        $RAB->save();

        return redirect()->back()->with('success', 'RAB berhasil diperbarui!');
    }

    public function destroy(RAB $RAB): RedirectResponse
    {
        $RAB->delete();

        return redirect()->back()->with('success', 'RAB berhasil dihapus!');
    }

    public function update_tax(TaxRequest $request, RAB $RAB): RedirectResponse
    {
        $validated = $request->safe();

        $RAB->fill([
            'tax' => $validated->tax,
            'additional_tax' => $validated->additional_tax,
        ]);

        $RAB->save();

        return redirect()->back();
    }

    public function submit(Request $request, RAB $RAB): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAB) {
            $RAB->status_aktivitas = 'Diajukan';
            $RAB->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAB->id_rab,
                'model_type' => get_class($RAB),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil diajukan!');
    }

    public function approve(Request $request, RAB $RAB): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAB) {
            $RAB->status_rab = '400';
            $RAB->status_aktivitas = 'Disetujui';
            $RAB->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAB->id_rab,
                'model_type' => get_class($RAB),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Disetujui'
            ]);
            $Timeline->save();
        });

        return redirect()->route('rab')->with('success', 'RAB berhasil disetujui!');
    }

    public function refuse(Request $request, RAB $RAB): RedirectResponse
    {
        DB::transaction(function () use ($request, $RAB) {
            $RAB->status_aktivitas = 'Dibuat';
            $RAB->save();
            
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $RAB->id_rab,
                'model_type' => get_class($RAB),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil ditolak!');
    }
}
