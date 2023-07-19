<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penagihan\StoreRequest;
use App\Http\Requests\Penagihan\UpdateRequest;
use App\Models\DetailPenagihan;
use App\Models\Penagihan;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PenagihanController extends Controller
{
    public function detail(Penagihan $penagihan): Response
    {
        $keuangan = DB::table('keuangan')
            ->leftJoin('proyek', 'keuangan.id_proyek', '=', 'proyek.id_proyek')
            ->where('keuangan.deleted_at', null)
            ->where('keuangan.id_keuangan', $penagihan->id_keuangan)
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran','proyek.pengguna_jasa',
                'keuangan.keperluan'
            )
            ->first();
            
        $detailPenagihan = DB::table('detail_penagihan as d_png')
            ->leftJoin('detail_rab as d_rab', 'd_rab.id_detail_rab', '=', 'd_png.id_detail_rab')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'd_rab.id_satuan')
            ->where('d_png.deleted_at', null)
            ->where('d_png.id_penagihan', $penagihan->id_penagihan)
            ->select(
                'd_png.id_detail_penagihan', 'd_png.id_penagihan',
                'd_rab.uraian', 'satuan.nama_satuan',
                'd_rab.harga_satuan', 'd_png.volume_penagihan',
                'd_rab.id_detail_rab', 'd_png.status_diterima'
            )
            ->orderBy('d_png.id_detail_penagihan', 'asc')
            ->get();
        
        $detailRAB = DB::table('detail_rab')
            ->leftJoin('rab', 'rab.id_rab', '=', 'detail_rab.id_rab')
            ->where('detail_rab.deleted_at', null)
            ->where('rab.id_proyek', $keuangan->id_proyek)
            ->groupBy('detail_rab.id_detail_rab')
            ->select(
                'detail_rab.id_detail_rab', 'detail_rab.uraian',
                'detail_rab.harga_satuan'
            )
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $penagihan->id_penagihan)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();

        return Inertia::render('Penagihan/Detail', [
            'keuangan' => $keuangan,
            'penagihan' => $penagihan,
            'detail_penagihan' => $detailPenagihan,
            'detail_rab' => $detailRAB,
            'timeline' => $timeline,
        ]);
    }

    public function store(StoreRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $detailPenagihan = new DetailPenagihan;

        $detailPenagihan->fill([
            'id_penagihan' => $penagihan->id_penagihan,
            'id_detail_rab' => $validated->id_detail_rab,
            'volume_penagihan' => $validated->volume_penagihan
        ]);

        $detailPenagihan->save();

        return redirect()->back()->with('success', 'Uraian Penagihan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailPenagihan $detailPenagihan): RedirectResponse
    {
        $validated = $request->safe();

        $detailPenagihan->fill([
            'id_detail_rab' => $validated->id_detail_rab,
            'volume_penagihan' => $validated->volume_penagihan
        ]);

        $detailPenagihan->save();

        return redirect()->back()->with('success', 'Uraian Penagihan Dana berhasil diperbarui!');
    }

    public function destroy(DetailPenagihan $detailPenagihan): RedirectResponse
    {
        $detailPenagihan->delete();

        return redirect()->back()->with('success', 'Uraian Penagihan Dana berhasil dihapus!');
    }

    public function submit(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {    
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan',
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->status_aktivitas = 'Diajukan';
            $penagihan->tanggal_pengajuan = now();
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil diajukan!');
    }

    public function accept(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            // Update The Detail Penagihan Status
            $updateDetailPenagihan = DetailPenagihan::where('id_penagihan', $penagihan->id_penagihan)
                ->whereIn('id_detail_penagihan', $request->post('group_of_id_detail_penagihan'))
                ->get();

            foreach ($updateDetailPenagihan as $detail) {
                $detail->status_diterima = '400';
                $detail->save();
            }

            // Checking if all Penagihan is completed
            $detailPenagihanQuery = DetailPenagihan::query()
                ->where('id_penagihan', $penagihan->id_penagihan);

            $totalDetailPenagihan = $detailPenagihanQuery->get()->count();
            $totalDetailPenagihanDiterima = $detailPenagihanQuery->where('status_diterima', '400')->get()->count();

            $status_pencairan = '100';
            $status_aktivitas = 'Dibuat';

            if ($totalDetailPenagihan === $totalDetailPenagihanDiterima) {
                $status_pencairan = '400';
                $status_aktivitas = 'Diterima';
            }

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diterima',
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->status_penagihan = $status_pencairan;
            $penagihan->status_aktivitas = $status_aktivitas;
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi berhasil dilakukan!');
    }

    public function decline(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
    
            // Update A Penagihan Status
            $penagihan->status_aktivitas = 'Dibuat';
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi berhasil dilakukan!');
    }
}
