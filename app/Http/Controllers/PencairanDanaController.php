<?php

namespace App\Http\Controllers;

use App\Models\DetailPencairanDana;
use App\Models\PencairanDana;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PencairanDanaController extends Controller
{
    public function index(Request $request): Response
    {
        $pencairanDana = DB::table('pencairan_dana')
            ->leftJoin('pengajuan_dana', 'pengajuan_dana.id_pengajuan_dana', '=', 'pencairan_dana.id_pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pencairan_dana.deleted_at', NULL)
            ->where('rap.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $pencairanDana = $this->filter($request, $pencairanDana);
        }

        $pencairanDana = $pencairanDana->groupBy('pencairan_dana.id_pencairan_dana')
            ->select(
                'pencairan_dana.id_pencairan_dana', 'pencairan_dana.status_aktivitas',
                'pengajuan_dana.keperluan', 'pencairan_dana.status_pencairan',
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
            ->orderBy('pencairan_dana.id_pencairan_dana', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PencairanDanaPage', [
            'pencairanDana' => $pencairanDana,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
    {
        $currentProyek = DB::table('proyek')
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran'
            )
            ->get();

        $options = (object) [
            'currentProyek' => $currentProyek
        ];

        return $options;
    }

    public function filter($searchRequest, $pencairanDana) {
        $pencairanDana->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $pencairanDana->when($searchRequest->get('status_pencairan'), function($query, $input) {
            $query->where('pencairan_dana.status_pencairan', $input);
        });

        $pencairanDana->when($searchRequest->get('ditolak') === 'true', function($query) {
            $query->where('pencairan_dana.status_aktivitas', 'Ditolak');
        });

        return $pencairanDana;
    }

    public function submit(Request $request, PencairanDana $pencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pencairanDana) {   
            // Create A Timeline 
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pencairanDana->id_pencairan_dana,
                'model_type' => get_class($pencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibayar'
            ]);
            $timeline->save();

            // Update The Pencairan Dana Status
            $pencairanDana->status_aktivitas = 'Dibayar';
            $pencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil dibayar!');
    }

    public function confirm(Request $request, PencairanDana $pencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pencairanDana) {
            $bertahap = $request->post('bertahap');

            $status_pencairan = '400';
            $status_aktivitas = 'Diterima';

            if ($bertahap) {
                $status_pencairan = '100';
                $status_aktivitas = 'Diterima Bertahap';
            }
            
            // Create A Timeline
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pencairanDana->id_pencairan_dana,
                'model_type' => get_class($pencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => $status_aktivitas,
            ]);
            $Timeline->save();

            // Update The Item of Pencairan Dana Status
            DetailPencairanDana::query()
                ->where([
                    'id_pencairan_dana' => $pencairanDana->id_pencairan_dana,
                    'status_pembayaran' => '100'
                ])
                ->update(['status_pembayaran' => '400']);

            // Update The Pencairan Dana Status
            $pencairanDana->status_pencairan = $status_pencairan;
            $pencairanDana->status_aktivitas = $status_aktivitas;
            $pencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil diterima!');
    }

    public function reject(Request $request, PencairanDana $pencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pencairanDana) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pencairanDana->id_pengajuan_dana,
                'model_type' => get_class($pencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
    
            // Update The Pencairan Dana Status
            $pencairanDana->status_aktivitas = 'Ditolak';
            $pencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil ditolak!');
    }
}
