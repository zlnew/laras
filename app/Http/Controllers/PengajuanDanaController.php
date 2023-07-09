<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanDana\StoreRequest;
use App\Http\Requests\PengajuanDana\UpdateRequest;
use App\Models\DetailPengajuanDana;
use App\Models\PengajuanDana;
use App\Models\Persetujuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PengajuanDanaController extends Controller
{
    public function detail(PengajuanDana $PengajuanDana): Response
    {
        $Proyek = DB::table('proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('rap.id_rap', $PengajuanDana->id_rap)
            ->select('nama_proyek')
            ->where('proyek.deleted_at', NULL)
            ->first();
            
        $DetailPengajuanDana = DB::table('detail_pengajuan_dana as d_pd')
            ->leftJoin('detail_rap as d_rap', 'd_rap.id_detail_rap', '=', 'd_pd.id_detail_rap')
            ->where('d_pd.id_pengajuan_dana', $PengajuanDana->id_pengajuan_dana)
            ->select(
                'd_pd.id_detail_pengajuan_dana',
                'd_pd.id_pengajuan_dana',
                'd_pd.uraian',
                'd_pd.jenis_pembayaran',
                'd_pd.nomor_rekening',
                'd_pd.nama_rekening',
                'd_pd.nama_bank',
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

        $Persetujuan = DB::table('persetujuan')
            ->leftJoin('users', 'users.id', '=', 'persetujuan.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('persetujuan.model_id', $PengajuanDana->id_pengajuan_dana)
            ->select(
                'persetujuan.created_at',
                'persetujuan.catatan',
                'persetujuan.status',
                'users.name as user_name',
                'roles.name as user_role'
            )
            ->get();

        return Inertia::render('PengajuanDana/Detail', [
            'proyek' => $Proyek,
            'pengajuan_dana' => $PengajuanDana,
            'detail_pengajuan_dana' => $DetailPengajuanDana,
            'detail_rap' => $DetailRAP,
            'persetujuan' => $Persetujuan
        ]);
    }

    public function store(StoreRequest $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $DetailPengajuanDana = new DetailPengajuanDana();

        $DetailPengajuanDana->fill([
            'id_pengajuan_dana' => $PengajuanDana->id_pengajuan_dana,
            'id_detail_rap' => $validated->id_detail_rap,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
            'nama_rekening' => $validated->nama_rekening,
            'nomor_rekening' => $validated->nomor_rekening,
            'nama_bank' => $validated->nama_bank,
        ]);

        $DetailPengajuanDana->save();

        return redirect()->back()->with('success', 'Uraian Pengajuan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailPengajuanDana $DetailPengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $DetailPengajuanDana->fill([
            'id_detail_rap' => $validated->id_detail_rap,
            'uraian' => $validated->uraian,
            'jumlah_pengajuan' => $validated->jumlah_pengajuan,
            'jenis_pembayaran' => $validated->jenis_pembayaran,
            'nama_rekening' => $validated->nama_rekening,
            'nomor_rekening' => $validated->nomor_rekening,
            'nama_bank' => $validated->nama_bank,
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
            $Persetujuan = new Persetujuan;
            $Persetujuan->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'status' => 'Dibuat'
            ]);
            $Persetujuan->save();

            $PengajuanDana->status_persetujuan = 'Dibuat';
            $PengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil dibuat!');
    }

    public function approve(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        DB::transaction(function () use ($request, $PengajuanDana) {
            $status = 'Disetujui';
    
            if ($request->user()->roles[0]->name === 'kepala divisi') {
                $status = 'Diperiksa';
            }
    
            $Persetujuan = new Persetujuan;
            $Persetujuan->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'catatan' => $request->post('catatan'),
                'status' => $status
            ]);
            $Persetujuan->save();

            $DetailPengajuanDana = new DetailPengajuanDana;
            $DetailPengajuanDana
            ->whereNotIn('id_detail_pengajuan_dana',
                $request->post('group_of_id_detail_pengajuan_dana')
            )->delete();

            $PengajuanDana->status_persetujuan = $status;
            $PengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil disetujui!');
    }

    public function reject(Request $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        $Persetujuan = new Persetujuan;
        $Persetujuan->fill([
            'user_id' => $request->user()->id,
            'model_id' => $PengajuanDana->id_pengajuan_dana,
            'model_type' => get_class($PengajuanDana),
            'catatan' => $request->post('catatan'),
            'status' => 'Ditolak'
        ]);

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil ditolak!');
    }
}