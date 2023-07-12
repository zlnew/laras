<?php

namespace App\Http\Controllers;

use App\Http\Requests\PencairanDana\StoreRequest;
use App\Models\DetailPencairanDana;
use App\Models\PencairanDana;
use App\Models\PengajuanDana;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PencairanDanaController extends Controller
{
    public function detail(PencairanDana $PencairanDana): Response
    {
        $Keuangan = DB::table('keuangan')
            ->leftJoin('proyek', 'keuangan.id_proyek', '=', 'proyek.id_proyek')
            ->where('keuangan.id_keuangan', $PencairanDana->id_keuangan)
            ->select(
                'keuangan.id_keuangan',
                'proyek.nama_proyek',
                'proyek.tahun_anggaran',
                'proyek.pengguna_jasa',
                'keuangan.keperluan'
            )
            ->where('keuangan.deleted_at', NULL)
            ->first();

        $DetailPencairanDana = DB::table('detail_pencairan_dana')
            ->where('id_pencairan_dana', $PencairanDana->id_pencairan_dana)
            ->select(
                'id_detail_pencairan_dana',
                'id_pencairan_dana',
                'id_detail_pengajuan_dana',
                'jumlah_pencairan'
            )
            ->where('deleted_at', NULL)
            ->orderBy('id_detail_pengajuan_dana', 'asc')->get();
        
        $PengajuanDana = PengajuanDana::select('id_pengajuan_dana')
            ->where('id_keuangan', $Keuangan->id_keuangan)
            ->first();
            
        $DetailPengajuanDana = DB::table('detail_pengajuan_dana as d_pgd')
            ->leftJoin('rekening as rek', 'rek.id_rekening', '=', 'd_pgd.id_rekening')
            ->leftJoin('detail_rap as d_rap', 'd_rap.id_detail_rap', '=', 'd_pgd.id_detail_rap')
            ->leftJoin('detail_pencairan_dana as d_pcd', 'd_pcd.id_detail_pengajuan_dana', '=', 'd_pgd.id_detail_pengajuan_dana')
            ->where('d_pgd.id_pengajuan_dana', $PengajuanDana->id_pengajuan_dana)
            ->select(
                'd_pgd.id_detail_pengajuan_dana',
                'd_pgd.id_pengajuan_dana',
                'd_pgd.uraian',
                'd_pgd.jenis_pembayaran',
                'd_pgd.id_rekening',
                'd_pgd.jumlah_pengajuan',
                'rek.nomor_rekening',
                'rek.nama_rekening',
                'rek.nama_bank',
                'd_rap.id_detail_rap',
                'd_rap.uraian as uraian_rap',
                DB::raw('SUM(d_pcd.jumlah_pencairan) as jumlah_pencairan'),
            )
            ->where('d_pgd.deleted_at', NULL)
            ->groupBy('d_pgd.id_detail_pengajuan_dana')
            ->orderBy('d_pgd.id_detail_pengajuan_dana', 'asc')->get();

        $Timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.model_id', $PencairanDana->id_pencairan_dana)
            ->select(
                'timeline.created_at',
                'timeline.catatan',
                'timeline.status_aktivitas',
                'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();

        return Inertia::render('PencairanDana/Detail', [
            'keuangan' => $Keuangan,
            'pencairan_dana' => $PencairanDana,
            'detail_pencairan_dana' => $DetailPencairanDana,
            'detail_pengajuan_dana' => $DetailPengajuanDana,
            'timeline' => $Timeline,
        ]);
    }

    public function store(StoreRequest $request, PencairanDana $PencairanDana): RedirectResponse
    {
        $validated = $request->safe();

        $DetailPencairanDana = new DetailPencairanDana();

        $DetailPencairanDana->fill([
            'id_pencairan_dana' => $PencairanDana->id_pencairan_dana,
            'id_detail_pengajuan_dana' => $validated->id_detail_pengajuan_dana,
            'jumlah_pencairan' => $validated->jumlah_pencairan,
        ]);

        $DetailPencairanDana->save();

        return redirect()->back()->with('success', 'Uraian Pencairan Dana berhasil dibuat!');
    }

    public function submit(Request $request, PencairanDana $PencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PencairanDana) {    
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PencairanDana->id_pencairan_dana,
                'model_type' => get_class($PencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Dibayar'
            ]);
            $Timeline->save();

            $PencairanDana->status_aktivitas = 'Dibayar';
            $PencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil dibayar!');
    }

    public function accept(Request $request, PencairanDana $PencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PencairanDana) {
            $is_lunas = $request->post('is_lunas');

            $status_pencairan = '400';
            $status_aktivitas = 'Diterima';

            if ($is_lunas === 'false') {
                $status_pencairan = '100';
                $status_aktivitas = 'Dibuat';
            }

            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PencairanDana->id_pencairan_dana,
                'model_type' => get_class($PencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diterima',
            ]);
            $Timeline->save();

            $PencairanDana->status_pencairan = $status_pencairan;
            $PencairanDana->status_aktivitas = $status_aktivitas;
            $PencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil diterima!');
    }

    public function reject(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PengajuanDana) {
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $Timeline->save();
    
            $PengajuanDana->status_aktivitas = 'Dibuat';
            $PengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil ditolak!');
    }
}