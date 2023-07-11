<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanDana\StoreRequest;
use App\Http\Requests\PengajuanDana\UpdateRequest;
use App\Models\DetailPengajuanDana;
use App\Models\PencairanDana;
use App\Models\PengajuanDana;
use App\Models\Rekening;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PengajuanDanaController extends Controller
{
    public function detail(PengajuanDana $PengajuanDana): Response
    {
        $Keuangan = DB::table('keuangan')
            ->leftJoin('proyek', 'keuangan.id_proyek', '=', 'proyek.id_proyek')
            ->where('keuangan.id_keuangan', $PengajuanDana->id_keuangan)
            ->select(
                'proyek.nama_proyek',
                'proyek.tahun_anggaran',
                'proyek.pengguna_jasa',
                'keuangan.keperluan'
            )
            ->where('keuangan.deleted_at', NULL)
            ->first();
            
        $DetailPengajuanDana = DB::table('detail_pengajuan_dana as d_pd')
            ->leftJoin('rekening as rek', 'rek.id_rekening', '=', 'd_pd.id_rekening')
            ->leftJoin('detail_rap as d_rap', 'd_rap.id_detail_rap', '=', 'd_pd.id_detail_rap')
            ->where('d_pd.id_pengajuan_dana', $PengajuanDana->id_pengajuan_dana)
            ->select(
                'd_pd.id_detail_pengajuan_dana',
                'd_pd.id_pengajuan_dana',
                'd_pd.uraian',
                'd_pd.jenis_pembayaran',
                'd_pd.id_rekening',
                'rek.nomor_rekening',
                'rek.nama_rekening',
                'rek.nama_bank',
                'd_pd.jumlah_pengajuan',
                'd_rap.id_detail_rap',
                'd_rap.uraian as uraian_rap',
            )
            ->where('d_pd.deleted_at', NULL)
            ->orderBy('d_pd.id_detail_pengajuan_dana', 'asc')->get();
        
        $DetailRAP = DB::table('detail_rap')
            ->select('id_detail_rap', 'uraian', 'harga_satuan')
            ->where('deleted_at', NULL)
            ->get();

        $Timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.model_id', $PengajuanDana->id_pengajuan_dana)
            ->select(
                'timeline.created_at',
                'timeline.catatan',
                'timeline.status_aktivitas',
                'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();
        
        $Rekening = Rekening::all();

        return Inertia::render('PengajuanDana/Detail', [
            'keuangan' => $Keuangan,
            'pengajuan_dana' => $PengajuanDana,
            'detail_pengajuan_dana' => $DetailPengajuanDana,
            'detail_rap' => $DetailRAP,
            'timeline' => $Timeline,
            'rekening' => $Rekening
        ]);
    }

    public function store(StoreRequest $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $DetailPengajuanDana = new DetailPengajuanDana();

        $DetailPengajuanDana->fill([
            'id_pengajuan_dana' => $PengajuanDana->id_pengajuan_dana,
            'id_detail_rap' => $validated->id_detail_rap,
            'id_rekening' => $validated->id_rekening,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
        ]);

        $DetailPengajuanDana->save();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailPengajuanDana $DetailPengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $DetailPengajuanDana->fill([
            'id_detail_rap' => $validated->id_detail_rap,
            'id_rekening' => $validated->id_rekening,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
        ]);

        $DetailPengajuanDana->save();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil diperbarui!');
    }

    public function destroy(DetailPengajuanDana $DetailPengajuanDana): RedirectResponse
    {
        $DetailPengajuanDana->delete();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil dihapus!');
    }

    public function submit(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PengajuanDana) {    
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'status_aktivitas' => 'Diajukan'
            ]);
            $Timeline->save();

            $PengajuanDana->status_aktivitas = 'Diajukan';
            $PengajuanDana->tanggal_pengajuan = now();
            $PengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil diajukan!');
    }

    public function approve(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PengajuanDana) {
            $status_pengajuan = '400';
            $status_aktivitas = 'Disetujui';
    
            if ($request->user()->roles->first()->name === 'kepala divisi') {
                $status_pengajuan = '100';
                $status_aktivitas = 'Dievaluasi';
            }
    
            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => $status_aktivitas
            ]);
            $Timeline->save();

            $DetailPengajuanDana = new DetailPengajuanDana;
            $DetailPengajuanDana
                ->whereNotIn(
                    'id_detail_pengajuan_dana',
                    $request->post('group_of_id_detail_pengajuan_dana'
                ))->delete();

            $PengajuanDana->status_pengajuan = $status_pengajuan;
            $PengajuanDana->status_aktivitas = $status_aktivitas;
            $PengajuanDana->save();

            if ($PengajuanDana->status_pengajuan === '400') {
                $PencairanDana = new PencairanDana;

                $PencairanDana->id_keuangan = $PengajuanDana->id_keuangan;
                $PencairanDana->save();
            }
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil disetujui!');
    }

    public function refuse(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
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

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil ditolak!');
    }
}