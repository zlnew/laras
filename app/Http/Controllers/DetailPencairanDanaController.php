<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPencairanDana\StoreRequest;
use App\Models\DetailPencairanDana;
use App\Models\PencairanDana;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class DetailPencairanDanaController extends Controller
{
    public function index(PencairanDana $pencairanDana): Response
    {
        $detailPencairanDana = DB::table('detail_pencairan_dana')
            ->where('id_pencairan_dana', $pencairanDana->id_pencairan_dana)
            ->where('deleted_at', null)
            ->select(
                'id_detail_pencairan_dana', 'id_pencairan_dana',
                'id_detail_pengajuan_dana', 'jumlah_pencairan'
            )
            ->orderBy('id_detail_pengajuan_dana', 'asc')
            ->get();

        $pengajuanDana = DB::table('pengajuan_dana')
            ->where('deleted_at', null)
            ->where('id_proyek', $pencairanDana->id_proyek)
            ->select('id_pengajuan_dana')
            ->first();
            
        $detailPengajuanDana = DB::table('detail_pengajuan_dana as d_pgd')
            ->leftJoin('rekening as rek', 'rek.id_rekening', '=', 'd_pgd.id_rekening')
            ->leftJoin('detail_rap as d_rap', 'd_rap.id_detail_rap', '=', 'd_pgd.id_detail_rap')
            ->leftJoin('detail_pencairan_dana as d_pcd', 'd_pcd.id_detail_pengajuan_dana', '=', 'd_pgd.id_detail_pengajuan_dana')
            ->where('d_pgd.deleted_at', NULL)
            ->where('d_pgd.id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
            ->groupBy('d_pgd.id_detail_pengajuan_dana')
            ->select(
                'd_pgd.id_detail_pengajuan_dana', 'd_pgd.id_pengajuan_dana',
                'd_pgd.uraian', 'd_pgd.jenis_pembayaran',
                'd_pgd.id_rekening', 'd_pgd.jumlah_pengajuan',
                'rek.nomor_rekening', 'rek.nama_rekening',
                'rek.nama_bank', 'd_rap.id_detail_rap',
                'd_rap.uraian as uraian_rap', DB::raw('SUM(d_pcd.jumlah_pencairan) as jumlah_pencairan'),
            )
            ->orderBy('d_pgd.id_detail_pengajuan_dana', 'asc')
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $pencairanDana->id_pencairan_dana)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();

        return Inertia::render('PencairanDana/Detail', [
            'pencairanDana' => $pencairanDana,
            'detailPencairanDana' => $detailPencairanDana,
            'detailPengajuanDana' => $detailPengajuanDana,
            'timeline' => $timeline,
        ]);
    }

    public function store(StoreRequest $request, PencairanDana $pencairanDana): RedirectResponse
    {
        $validated = $request->safe();

        $detailPencairanDana = new DetailPencairanDana();

        $detailPencairanDana->fill([
            'id_pencairan_dana' => $pencairanDana->id_pencairan_dana,
            'id_detail_pengajuan_dana' => $validated->id_detail_pengajuan_dana,
            'jumlah_pencairan' => $validated->jumlah_pencairan,
        ]);

        $detailPencairanDana->save();

        return redirect()->back()->with('success', 'Uraian Pencairan Dana berhasil dibuat!');
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

    public function accept(Request $request, PencairanDana $pencairanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $pencairanDana) {
            $is_lunas = $request->post('is_lunas');

            $status_pencairan = '400';
            $status_aktivitas = 'Diterima';

            if ($is_lunas === 'false') {
                $status_pencairan = '100';
                $status_aktivitas = 'Dibuat';
            }

            // Create A Timeline
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pencairanDana->id_pencairan_dana,
                'model_type' => get_class($pencairanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diterima',
            ]);
            $Timeline->save();

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
            $pencairanDana->status_aktivitas = 'Dibuat';
            $pencairanDana->save();
        });

        return redirect()->back()->with('success', 'Pencairan Dana berhasil ditolak!');
    }
}