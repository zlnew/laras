<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAB\StoreRequest;
use App\Http\Requests\RAB\TaxRequest;
use App\Http\Requests\RAB\UpdateRequest;
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
        $rabQuery = DB::table('rab')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek')
            ->where('rab.deleted_at', null);

        if ($request->isMethod('get') && $request->all()) {
            $rabQuery = $this->filter($request, $rabQuery);
        }

        $rab = $rabQuery->select(
                'rab.id_rab', 'rab.status_rab',
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran', 'proyek.pengguna_jasa',
            )
            ->orderBy('rab.id_rab', 'desc')
            ->paginate(10);

        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->where('rab.deleted_at', null)
            ->where('rab.id_rab', null)
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();
            
        return Inertia::render('RAB/Index', [
            'rab' => $rab,
            'proyek' => $proyek
        ]);
    }

    private function filter($searchRequest, $rabQuery) {
        $rabQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', $input . '%');
        });

        return $rabQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->safe();

            // Create A RAB
            $rab = new RAB;
            $rab->id_proyek = $validated->id_proyek;
            $rab->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rab->id_rab,
                'model_type' => get_class($rab),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibuat'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, RAB $rab): RedirectResponse
    {
        $validated = $request->safe();

        $rab->id_proyek = $validated->id_proyek;
        $rab->save();

        return redirect()->back()->with('success', 'RAB berhasil diperbarui!');
    }

    public function destroy(RAB $rab): RedirectResponse
    {
        $rab->delete();

        return redirect()->back()->with('success', 'RAB berhasil dihapus!');
    }

    public function update_tax(TaxRequest $request, RAB $rab): RedirectResponse
    {
        $validated = $request->safe();

        $rab->fill([
            'tax' => $validated->tax,
            'additional_tax' => $validated->additional_tax,
        ]);
        $rab->save();

        return redirect()->back();
    }

    public function submit(Request $request, RAB $rab): RedirectResponse
    {
        DB::transaction(function () use ($request, $rab) {
            // Update The RAB Status
            $rab->status_aktivitas = 'Diajukan';
            $rab->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rab->id_rab,
                'model_type' => get_class($rab),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil diajukan!');
    }

    public function approve(Request $request, RAB $rab): RedirectResponse
    {
        DB::transaction(function () use ($request, $rab) {
            // Update The RAB Status
            $rab->status_rab = '400';
            $rab->status_aktivitas = 'Disetujui';
            $rab->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rab->id_rab,
                'model_type' => get_class($rab),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Disetujui'
            ]);
            $timeline->save();
        });

        return redirect()->route('rab')->with('success', 'RAB berhasil disetujui!');
    }

    public function refuse(Request $request, RAB $rab): RedirectResponse
    {
        DB::transaction(function () use ($request, $rab) {
            // Update The RAB Status
            $rab->status_aktivitas = 'Dibuat';
            $rab->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rab->id_rab,
                'model_type' => get_class($rab),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil ditolak!');
    }
}
