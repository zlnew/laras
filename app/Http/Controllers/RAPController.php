<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAP\StoreRequest;
use App\Http\Requests\RAP\UpdateRequest;
use App\Models\RAP;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class RAPController extends Controller
{
    public function index(Request $request): Response
    {
        $rapQuery = DB::table('rap')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rap.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('rap.deleted_at', null);

        $role = $request->user()->roles->first()->name;

        if ($role === 'manajer proyek') {
            $rapQuery->where('id_user', $request->user()->id);
        }

        if ($request->isMethod('get') && $request->all()) {
            $rapQuery = $this->filter($request, $rapQuery);
        }

        $rap = $rapQuery->groupBy('rap.id_rap')
            ->select(
                'rap.id_rap', 'rap.status_rap',
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
            ->orderBy('rap.id_rap', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Main/RAPPage', [
            'rap' => $rap,
            'formOptions' => $formOptions
        ]);
    }

    private function formOptions(): stdClass {
        $proyek = DB::table('proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rap.deleted_at', null)
            ->where('rap.id_proyek', null)
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $currentProyek = DB::table('proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rap.deleted_at', null)
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

    private function filter($searchRequest, $rapQuery) {
        $rapQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('rap.id_proyek', $input);
        });

        $rapQuery->when($searchRequest->get('status_rap'), function($query, $input) {
            $query->where('rap.status_rap', $input);
        });

        return $rapQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validated = $request->safe();

            // Create A RAP
            $rap = new RAP;

            $rap->id_proyek = $validated->id_proyek;

            $rap->save();
            
            // Create A Timeline
            $timeline = new Timeline;

            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rap->id_rap,
                'model_type' => get_class($rap),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibuat'
            ]);

            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, RAP $rap): RedirectResponse
    {
        $validated = $request->safe();

        $rap->id_proyek = $validated->id_proyek;
        
        $rap->save();

        return redirect()->back()->with('success', 'RAP berhasil diperbarui!');
    }

    public function destroy(RAP $rap): RedirectResponse
    {
        $rap->delete();

        return redirect()->back()->with('success', 'RAP berhasil dihapus!');
    }

    public function submit(Request $request, RAP $rap): RedirectResponse
    {
        DB::transaction(function () use ($request, $rap) {
            // Update The RAP Status
            $rap->status_aktivitas = 'Diajukan';
            $rap->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rap->id_rap,
                'model_type' => get_class($rap),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil diajukan!');
    }

    public function approve(Request $request, RAP $rap): RedirectResponse
    {
        DB::transaction(function () use ($request, $rap) {
            $role = $request->user()->roles->first()->name;

            if ($role === 'kepala divisi') {
                $status_rap = '100';
                $status_aktivitas_rap = 'Diperiksa';
            } else if ($role === 'direktur utama' || $role === 'admin') {
                $status_rap = '400';
                $status_aktivitas_rap = 'Disetujui';
            }

            // Update The RAP Status
            $rap->status_rap = $status_rap;
            $rap->status_aktivitas = $status_aktivitas_rap;
            $rap->save();
            
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rap->id_rap,
                'model_type' => get_class($rap),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Disetujui'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil disetujui!');
    }

    public function reject(Request $request, RAP $rap): RedirectResponse
    {
        DB::transaction(function () use ($request, $rap) {
            // Update The RAP Status
            $rap->status_aktivitas = 'Ditolak';
            $rap->save();

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $rap->id_rap,
                'model_type' => get_class($rap),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'RAP berhasil ditolak!');
    }
}