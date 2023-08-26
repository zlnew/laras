<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPengajuanDana\StoreRequest;
use App\Http\Requests\DetailPengajuanDana\UpdateRequest;
use App\Models\DetailPengajuanDana;
use App\Models\PengajuanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class DetailPengajuanDanaController extends Controller
{
    public function index(PengajuanDana $pengajuanDana): Response
    {         
        $pengajuanDana = DB::table('pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pengajuan_dana.deleted_at', null)
            ->where('pengajuan_dana.id_pengajuan_dana', $pengajuanDana->id_pengajuan_dana)
            ->select(
                'pengajuan_dana.id_pengajuan_dana', 'pengajuan_dana.jenis_transaksi',
                'pengajuan_dana.keperluan', 'pengajuan_dana.tanggal_pengajuan',
                'pengajuan_dana.status_pengajuan', 'pengajuan_dana.status_aktivitas',
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
            ->first();

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
                'd_rap.uraian as pos',
            )
            ->orderBy('d_pd.id_detail_pengajuan_dana', 'asc')
            ->get();

        $dokumenPenunjang = DB::table('files')
            ->leftJoin('pengajuan_dana as pd', 'pd.id_pengajuan_dana', '=', 'files.model_id')
            ->where([
                'files.deleted_at' => null,
                'pd.deleted_at' => null
            ])
            ->where('files.model_id', $pengajuanDana->id_pengajuan_dana)
            ->select('files.id_file', 'files.file_name', 'files.file_path')
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

        $evaluasi = DB::table('detail_rap as drap')
            ->leftJoin('satuan as stn', 'stn.id_satuan', '=', 'drap.id_satuan')
            ->leftJoin('rap', 'rap.id_rap', '=', 'drap.id_rap')
            ->where('rap.id_proyek', $pengajuanDana->id_proyek)
            ->where([
                'drap.deleted_at' => null, 
                'rap.deleted_at' => null,
            ])
            ->groupBy('drap.id_detail_rap')
            ->select(
                'drap.id_detail_rap', 'rap.id_proyek',
                'drap.uraian', 'stn.nama_satuan',
                'drap.harga_satuan', 'drap.volume',
                DB::raw('SUM(drap.harga_satuan * drap.volume) AS total_harga')
            )
            ->get();
        
        foreach ($evaluasi as $item) {
            $pengajuanLalu = DB::table('detail_pengajuan_dana')
                ->where('deleted_at', null)
                ->where('id_detail_rap', $item->id_detail_rap)
                ->where('status_persetujuan', '400')
                ->selectRaw('SUM(jumlah_pengajuan) AS jumlah')
                ->first();
            
            $item->pengajuan_lalu = $pengajuanLalu->jumlah;
        }

        $formOptions = $this->formOptions($pengajuanDana->id_proyek);

        return Inertia::render('Keuangan/DetailPengajuanDanaPage', [
            'pengajuanDana' => $pengajuanDana,
            'detailPengajuanDana' => $detailPengajuanDana,
            'dokumenPenunjang' => $dokumenPenunjang,
            'evaluasi' => $evaluasi,
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
            ->where('tujuan_rekening', 'Daftar Rekening Keluar')
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
}