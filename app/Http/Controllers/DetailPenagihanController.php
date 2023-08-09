<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPenagihan\StoreRequest;
use App\Http\Requests\DetailPenagihan\UpdateRequest;
use App\Models\DetailPenagihan;
use App\Models\Penagihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class DetailPenagihanController extends Controller
{
    public function index(Penagihan $penagihan): Response
    {
        $penagihan = DB::table('penagihan')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'penagihan.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->leftJoin('rekening as rpg', 'rpg.id_rekening', '=', 'penagihan.id_rekening')
            ->where('penagihan.deleted_at', null)
            ->where('penagihan.id_penagihan', $penagihan->id_penagihan)
            ->select(
                'penagihan.id_penagihan', 'penagihan.kas_masuk',
                'penagihan.keperluan', 'penagihan.tanggal_pengajuan',
                'penagihan.status_penagihan', 'penagihan.status_aktivitas',
                'penagihan.id_rekening as id_rekening_pg', 'penagihan.nomor_sp2d',
                'penagihan.tanggal_sp2d', 'penagihan.tanggal_terbit',
                'penagihan.tanggal_cair', 'rpg.nama_bank as nama_bank_pg',
                'rpg.nomor_rekening as nomor_rekening_pg', 'rpg.nama_rekening as nama_rekening_pg',
                'penagihan.potongan_ppn', 'penagihan.potongan_pph',
                'penagihan.potongan_lainnya', 'penagihan.keterangan_potongan_lainnya',
                'penagihan.jumlah_diterima',
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

        $detailPenagihan = DB::table('detail_penagihan as dpg')
            ->leftJoin('detail_rab as drab', 'drab.id_detail_rab', '=', 'dpg.id_detail_rab')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'drab.id_satuan')
            ->where([
                'dpg.deleted_at' => null,
                'drab.deleted_at' => null
            ])
            ->where('dpg.id_penagihan', $penagihan->id_penagihan)
            ->select(
                'dpg.id_detail_penagihan', 'dpg.id_penagihan',
                'drab.uraian', 'satuan.nama_satuan',
                'dpg.harga_satuan_penagihan', 'dpg.volume_penagihan',
                'drab.id_detail_rab', 'dpg.status_diterima'
            )
            ->orderBy('dpg.id_detail_penagihan', 'asc')
            ->get();

        $dokumenPenunjang = DB::table('files')
            ->leftJoin('penagihan as pg', 'pg.id_penagihan', '=', 'files.model_id')
            ->where([
                'files.deleted_at' => null,
                'pg.deleted_at' => null
            ])
            ->where('files.model_id', $penagihan->id_penagihan)
            ->select('files.id_file', 'files.file_name', 'files.file_path')
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

        $formOptions = $this->formOptions($penagihan->id_proyek);

        return Inertia::render('Keuangan/DetailPenagihanPage', [
            'penagihan' => $penagihan,
            'detailPenagihan' => $detailPenagihan,
            'dokumenPenunjang' => $dokumenPenunjang,
            'timeline' => $timeline,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions($id_proyek): stdClass
    {
        $detailRab = DB::table('detail_rab')
            ->leftJoin('rab', 'rab.id_rab', '=', 'detail_rab.id_rab')
            ->where('detail_rab.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->where('rab.id_proyek', $id_proyek)
            ->groupBy('detail_rab.id_detail_rab')
            ->select(
                'detail_rab.id_detail_rab', 'detail_rab.uraian',
                'detail_rab.harga_satuan'
            )
            ->get();
        
        $rekening = DB::table('rekening')
            ->where('deleted_at', null)
            ->where('tujuan_rekening', 'Penerimaan Invoice')
            ->select(
                'id_rekening', 'nama_bank',
                'nomor_rekening', 'nama_rekening'
            )->get();

        $options = (object) [
            'detailRab' => $detailRab,
            'rekening' => $rekening
        ];

        return $options;
    }

    public function store(StoreRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $detailPenagihan = new DetailPenagihan;

        $detailPenagihan->fill([
            'id_penagihan' => $penagihan->id_penagihan,
            'id_detail_rab' => $validated->id_detail_rab,
            'volume_penagihan' => $validated->volume_penagihan,
            'harga_satuan_penagihan' => $validated->harga_satuan_penagihan
        ]);

        $detailPenagihan->save();

        return redirect()->back()->with('success', 'Uraian Penagihan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailPenagihan $detailPenagihan): RedirectResponse
    {
        $validated = $request->safe();

        $detailPenagihan->fill([
            'id_detail_rab' => $validated->id_detail_rab,
            'volume_penagihan' => $validated->volume_penagihan,
            'harga_satuan_penagihan' => $validated->harga_satuan_penagihan
        ]);

        $detailPenagihan->save();

        return redirect()->back()->with('success', 'Uraian Penagihan Dana berhasil diperbarui!');
    }

    public function destroy(DetailPenagihan $detailPenagihan): RedirectResponse
    {
        $detailPenagihan->delete();

        return redirect()->back()->with('success', 'Uraian Penagihan Dana berhasil dihapus!');
    }
}
