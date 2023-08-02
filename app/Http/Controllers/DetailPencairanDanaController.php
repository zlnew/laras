<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPencairanDana\StoreRequest;
use App\Models\DetailPencairanDana;
use App\Models\PencairanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DetailPencairanDanaController extends Controller
{
    public function index(PencairanDana $pencairanDana): Response
    {
        $pencairanDana = DB::table('pencairan_dana')
            ->leftJoin('pengajuan_dana', 'pengajuan_dana.id_pengajuan_dana', '=', 'pencairan_dana.id_pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pencairan_dana.deleted_at', null)
            ->where('pencairan_dana.id_pencairan_dana', $pencairanDana->id_pencairan_dana)
            ->select(
                'pencairan_dana.id_pencairan_dana',
                'pencairan_dana.id_pengajuan_dana',
                'pencairan_dana.status_pencairan',
                'pencairan_dana.status_aktivitas',
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

        $pengajuanDana = DB::table('pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pengajuan_dana.deleted_at', null)
            ->where('pengajuan_dana.id_pengajuan_dana', $pencairanDana->id_pengajuan_dana)
            ->select(
                'pengajuan_dana.id_pengajuan_dana',
                'pengajuan_dana.keperluan', 'pengajuan_dana.tanggal_pengajuan',
                'pengajuan_dana.status_pengajuan', 'pengajuan_dana.status_aktivitas',
            )
            ->first();

        $detailPencairanDana = DB::table('detail_pencairan_dana')
            ->where('deleted_at', null)
            ->where('id_pencairan_dana', $pencairanDana->id_pencairan_dana)
            ->select(
                'id_detail_pengajuan_dana',
                'jumlah_pencairan', 'status_pembayaran'
            )
            ->get();

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
            ->leftJoin('pencairan_dana as pc', 'pc.id_pencairan_dana', '=', 'files.model_id')
            ->where([
                'files.deleted_at' => null,
                'pc.deleted_at' => null
            ])
            ->where('files.model_id', $pencairanDana->id_pencairan_dana)
            ->select('files.id_file', 'files.file_name', 'files.file_path')
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
        
        return Inertia::render('Keuangan/DetailPencairanDanaPage', [
            'pencairanDana' => $pencairanDana,
            'pengajuanDana' => $pengajuanDana,
            'detailPencairanDana' => $detailPencairanDana,
            'detailPengajuanDana' => $detailPengajuanDana,
            'dokumenPenunjang' => $dokumenPenunjang,
            'timeline' => $timeline,
        ]);
    }

    public function store(StoreRequest $request, PencairanDana $pencairanDana): RedirectResponse
    {
        $validated = $request->safe();
        
        DetailPencairanDana::updateOrCreate(
            [
                'id_pencairan_dana' => $pencairanDana->id_pencairan_dana,
                'id_detail_pengajuan_dana' => $validated->id_detail_pengajuan_dana,
                'status_pembayaran' => '100'
            ],
            ['jumlah_pencairan' => $validated->jumlah_pencairan]
        );

        return redirect()->back()->with('success', 'Uraian Pencairan Dana berhasil dibayar!');
    }
}