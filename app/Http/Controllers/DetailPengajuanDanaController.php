<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPengajuanDana\StoreRequest;
use App\Http\Requests\DetailPengajuanDana\UpdateRequest;
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

class DetailPengajuanDanaController extends Controller
{
    public function index(PengajuanDana $pengajuanDana): Response
    {            
        $detailPengajuanDana = DB::table('detail_pengajuan_dana as d_pd')
            ->leftJoin('rekening as rek', 'rek.id_rekening', '=', 'd_pd.id_rekening')
            ->leftJoin('detail_rap as d_rap', 'd_rap.id_detail_rap', '=', 'd_pd.id_detail_rap')
            ->where('d_pd.deleted_at', null)
            ->where('d_pd.id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
            ->select(
                'd_pd.id_detail_pengajuan_dana', 'd_pd.id_pengajuan_dana',
                'd_pd.uraian', 'd_pd.jenis_pembayaran',
                'd_pd.id_rekening', 'rek.nomor_rekening',
                'rek.nama_rekening', 'rek.nama_bank',
                'd_pd.jumlah_pengajuan', 'd_rap.id_detail_rap',
                'd_rap.uraian as uraian_rap',
            )
            ->orderBy('d_pd.id_detail_pengajuan_dana', 'asc')
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $pengajuanDana->id_pengajuan_dana)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();

        $formOptions = $this->formOptions($pengajuanDana->id_proyek);

        return Inertia::render('PengajuanDana/Detail', [
            'pengajuanDana' => $pengajuanDana,
            'detailPengajuanDana' => $detailPengajuanDana,
            'timeline' => $timeline,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions($id_proyek): stdClass
    {
        $detailRap = DB::table('detail_rap')
            ->leftJoin('rap', 'rap.id_rap', '=', 'detail_rap.id_rap')
            ->where('detail_rap.deleted_at', null)
            ->where('rap.id_proyek', $id_proyek)
            ->groupBy('detail_rap.id_detail_rap')
            ->select(
                'detail_rap.id_detail_rap', 'detail_rap.uraian',
                'detail_rap.harga_satuan'
            )
            ->get();

        $rekening = DB::table('rekening')
            ->where('deleted_at', null)
            ->select(
                'id_rekening', 'nama_bank',
                'nomor_rekening', 'nama_rekening'
            )
            ->get();

        $options = (object) [
            'detailRap' => $detailRap,
            'rekening' => $rekening
        ];

        return $options;
    }

    public function store(StoreRequest $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $detailPengajuanDana = new DetailPengajuanDana;

        $detailPengajuanDana->fill([
            'id_pengajuan_dana' => $pengajuanDana->id_pengajuan_dana,
            'id_detail_rap' => $validated->id_detail_rap,
            'id_rekening' => $validated->id_rekening,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
        ]);

        $detailPengajuanDana->save();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailPengajuanDana $detailPengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $detailPengajuanDana->fill([
            'id_detail_rap' => $validated->id_detail_rap,
            'id_rekening' => $validated->id_rekening,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
        ]);

        $detailPengajuanDana->save();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil diperbarui!');
    }

    public function destroy(DetailPengajuanDana $detailPengajuanDana): RedirectResponse
    {
        $detailPengajuanDana->delete();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil dihapus!');
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
            $status_pengajuan = '400';
            $status_aktivitas = 'Disetujui';
    
            if ($request->user()->roles->first()->name === 'kepala divisi') {
                $status_pengajuan = '100';
                $status_aktivitas = 'Dievaluasi';
            }
    
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $pengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($pengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => $status_aktivitas
            ]);
            $timeline->save();

            // Update The Detail Pengajuan Dana
            $updateDetailPengajuanDana = DetailPengajuanDana::query()
                ->where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
                ->whereIn('id_detail_pengajuan_dana',
                    $request->post('group_of_id_detail_pengajuan_dana')
                )
                ->get();

            foreach ($updateDetailPengajuanDana as $item) {
                $item->status_persetujuan = '400';
                $item->save();
            }

            // Delete The Detail Pengajuan Dana
            $deleteDetailPengajuanDana = DetailPengajuanDana::query()
                ->where('id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
                ->whereNotIn('id_detail_pengajuan_dana',
                    $request->post('group_of_id_detail_pengajuan_dana')
                )
                ->get();

            foreach ($deleteDetailPengajuanDana as $item) {
                $item->delete();
            }

            // Update The Pengajuan Dana Status
            $pengajuanDana->status_pengajuan = $status_pengajuan;
            $pengajuanDana->status_aktivitas = $status_aktivitas;
            $pengajuanDana->save();

            // Update The Pencairan Dana when Status Pengajuan is 400
            if ($pengajuanDana->status_pengajuan === '400') {
                $pencairanDana = new PencairanDana;
                $pencairanDana->id_keuangan = $pengajuanDana->id_keuangan;
                $pencairanDana->save();
            }
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil disetujui!');
    }

    public function refuse(Request $request, PengajuanDana $pengajuanDana): RedirectResponse
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
            $pengajuanDana->status_aktivitas = 'Dibuat';
            $pengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil ditolak!');
    }
}