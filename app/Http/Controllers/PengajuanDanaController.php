<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanDana\StoreRequest;
use App\Http\Requests\PengajuanDana\UpdateRequest;
use App\Models\DetailPengajuanDana;
use App\Models\PencairanDana;
use App\Models\PengajuanDana;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PengajuanDanaController extends Controller
{
    public function index(Request $request): Response
    {
        $pengajuanDanaQuery = DB::table('pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pengajuan_dana.deleted_at', NULL)
            ->where('rap.deleted_at', NULL);

        $role = $request->user()->roles->first()->name;

        if ($role === 'manajer proyek') {
            $pengajuanDanaQuery->where('proyek.id_user', $request->user()->id);
        }

        if ($request->isMethod('get') && $request->all()) {
            $pengajuanDanaQuery = $this->filter($request, $pengajuanDanaQuery);
        }

        $pengajuanDana = $pengajuanDanaQuery->groupBy('pengajuan_dana.id_pengajuan_dana')
            ->select(
                'pengajuan_dana.id_pengajuan_dana', 'pengajuan_dana.status_aktivitas',
                'pengajuan_dana.jenis_transaksi',
                'pengajuan_dana.keperluan', 'pengajuan_dana.status_pengajuan',
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
            ->orderBy('pengajuan_dana.id_pengajuan_dana', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PengajuanDanaPage', [
            'pengajuanDana' => $pengajuanDana,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
    {
        $proyek = DB::table('proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rap.deleted_at', null)
            ->where('rap.status_rap', '400')
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $currentProyek = DB::table('proyek')
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran'
            )
            ->get();
            
        $options = (object) [
            'proyek' => $proyek,
            'currentProyek' => $currentProyek
        ];

        return $options;
    }

    public function filter($searchRequest, $pengajuanDanaQuery) {
        $pengajuanDanaQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('pengajuan_dana.id_proyek', $input);
        });

        $pengajuanDanaQuery->when($searchRequest->get('jenis_transaksi'), function($query, $input) {
            $query->where('pengajuan_dana.jenis_transaksi', $input);
        });

        $pengajuanDanaQuery->when($searchRequest->get('status_pengajuan'), function($query, $input) {
            $query->where('pengajuan_dana.status_pengajuan', $input);
        });

        $pengajuanDanaQuery->when($searchRequest->get('ditolak') === 'true', function($query) {
            $query->where('pengajuan_dana.status_aktivitas', 'Ditolak');
        });

        return $pengajuanDanaQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $validated = $request->safe();
    
            $pengajuanDana = new PengajuanDana;

            $pengajuanDana->fill([
                'id_proyek' => $validated->id_proyek,
                'keperluan' => $validated->keperluan,
                'jenis_transaksi' => $validated->jenis_transaksi
            ]);
            
            $pengajuanDana->save();

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($pengajuanDana),
                'status_aktivitas' => 'Dibuat'
            ]);
            $timeline->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $pengajuanDana->fill([
            'id_proyek' => $validated->id_proyek,
            'keperluan' => $validated->keperluan,
            'jenis_transaksi' => $validated->jenis_transaksi
        ]);

        $pengajuanDana->save();

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil diperbarui!');
    }

    public function destroy(PengajuanDana $pengajuanDana): RedirectResponse
    {
        $pengajuanDana->delete();

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil dihapus!');
    }

    public function submit(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pengajuanDana) {
            // Create A Timeline  
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($pengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan'
            ]);
            $timeline->save();

            // Update The Pengajuan Dana Status
            $pengajuanDana->status_aktivitas = 'Diajukan';
            $pengajuanDana->tanggal_pengajuan = now();
            $pengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil diajukan!');
    }

    public function approve(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pengajuanDana) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($pengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Disetujui',
            ]);
            $timeline->save();

            // Update The Detail Pengajuan Dana
            DetailPengajuanDana::query()
                ->where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
                ->whereIn('id_detail_pengajuan_dana', $request->post('selected_ids_detail_pengajuan_dana'))
                ->update(['status_persetujuan' => '400']);

            // Delete The Detail Pengajuan Dana
            DetailPengajuanDana::query()
                ->where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
                ->whereNotIn('id_detail_pengajuan_dana', $request->post('selected_ids_detail_pengajuan_dana'))
                ->delete();

            // Update The Pengajuan Dana Status
            $pengajuanDana->status_pengajuan = '400';
            $pengajuanDana->status_aktivitas = 'Disetujui';
            $pengajuanDana->save();

            // Create A Pencairan Dana
            $pencairanDana = new PencairanDana;
            $pencairanDana->id_pengajuan_dana = $pengajuanDana->id_pengajuan_dana;
            $pencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil disetujui!');
    }

    public function reject(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pengajuanDana) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($pengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
    
            // Update The Pengajuan Dana Status
            $pengajuanDana->status_aktivitas = 'Ditolak';
            $pengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil ditolak!');
    }
}
