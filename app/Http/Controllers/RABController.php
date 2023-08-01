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
use stdClass;

class RABController extends Controller
{
    public function index(Request $request): Response
    {
        $rabQuery = DB::table('rab')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('rab.deleted_at', null);

        $role = $request->user()->roles->first()->name;

        if ($role === 'manajer proyek') {
            $rabQuery->where('id_user', $request->user()->id);
        }

        if ($request->isMethod('get') && $request->all()) {
            $rabQuery = $this->filter($request, $rabQuery);
        }

        $rab = $rabQuery->groupBy('rab.id_rab')
            ->select(
                'rab.id_rab',
                'rab.status_rab', 'rab.status_aktivitas',
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.nomor_kontrak', 'proyek.tanggal_kontrak',
                'proyek.pengguna_jasa', 'proyek.penyedia_jasa',
                'proyek.tahun_anggaran', 'proyek.nomor_spmk',
                'proyek.tanggal_spmk', 'proyek.nilai_kontrak',
                'proyek.tanggal_mulai', 'proyek.durasi',
                'proyek.tanggal_selesai', 'users.id as id_user',
                'users.name as pic', 'proyek.status_proyek',
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )
            ->orderBy('rab.id_rab', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Main/RABPage', [
            'rab' => $rab,
            'formOptions' => $formOptions
        ]);
    }

    private function formOptions(): stdClass {
        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('rab.id_proyek', null)
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $currentProyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $options = (object) [
            'proyek' => $proyek,
            'currentProyek' => $currentProyek
        ];

        return $options;
    }

    private function filter($searchRequest, $rabQuery) {
        $rabQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('rab.id_proyek', $input);
        });

        $rabQuery->when($searchRequest->get('status_rab'), function($query, $input) {
            $query->where('rab.status_rab', $input);
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

        return redirect()->back()->with('success', 'RAB berhasil disetujui!');
    }

    public function reject(Request $request, RAB $rab): RedirectResponse
    {
        DB::transaction(function () use ($request, $rab) {
            // Update The RAB Status
            $rab->status_aktivitas = 'Ditolak';
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
