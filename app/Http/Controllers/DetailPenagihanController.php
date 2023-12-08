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
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->leftJoin('rekening as rpg', 'rpg.id_rekening', '=', 'penagihan.id_rekening')
            ->where('penagihan.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('proyek.deleted_at', null)
            ->where('penagihan.id_penagihan', $penagihan->id_penagihan)
            ->select(
                'penagihan.id_penagihan',
                'penagihan.nilai_netto', 'penagihan.faktur',
                'penagihan.keperluan', 'penagihan.tanggal_pengajuan',
                'penagihan.status_penagihan', 'penagihan.status_aktivitas',
                'penagihan.id_rekening as id_rekening_pg', 'penagihan.nomor_sp2d',
                'penagihan.tanggal_sp2d', 'penagihan.tanggal_terbit',
                'penagihan.tanggal_cair', 'rpg.nama_bank as nama_bank_pg',
                'rpg.nomor_rekening as nomor_rekening_pg', 'rpg.nama_rekening as nama_rekening_pg',
                'penagihan.potongan_ppn', 'penagihan.potongan_pph',
                'penagihan.potongan_lainnya', 'penagihan.keterangan_potongan_lainnya',
                'penagihan.potongan_lainnya2', 'penagihan.keterangan_potongan_lainnya2',
                'penagihan.potongan_lainnya3', 'penagihan.keterangan_potongan_lainnya3',
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
            ->where('dpg.deleted_at', null)
            ->where('dpg.id_penagihan', $penagihan->id_penagihan)
            ->select(
                'dpg.id_detail_penagihan', 'dpg.id_penagihan',
                'dpg.uraian', 'dpg.harga_satuan_penagihan',
                'dpg.volume_penagihan', 'dpg.status_diterima'
            )
            ->orderBy('dpg.id_detail_penagihan', 'asc')
            ->get();

        $evaluasi = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->where('p.id_proyek', $penagihan->id_proyek)
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    IFNULL(
                        CAST((SELECT SUM(drab.harga_satuan * drab.volume) - ((rab.additional_tax / 100) * SUM(drab.harga_satuan * drab.volume))
                            FROM detail_rab as drab
                            LEFT JOIN rab
                            ON rab.id_rab = drab.id_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND (
                                rab.deleted_at IS NULL
                                AND drab.deleted_at IS NULL
                                AND rab.status_rab = '400'
                            )
                            GROUP BY rab.id_rab
                        ) AS DECIMAL(20, 2))
                    , 0) AS nilai_kontrak
                "),
                DB::raw("
                    CAST(
                        (SELECT SUM(pg.jumlah_diterima)
                            FROM penagihan as pg
                            WHERE pg.id_proyek = p.id_proyek
                            AND pg.deleted_at IS NULL
                        )
                    AS DECIMAL(20, 2)) AS invoice_sebelumnya
                "),
                DB::raw("
                    CAST(
                        (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                            FROM penagihan AS pg
                            LEFT JOIN detail_penagihan AS dpg
                            ON dpg.id_penagihan = pg.id_penagihan
                            WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                AND dpg.deleted_at IS NULL
                                AND pg.status_penagihan = '100'
                            )
                        ) -
                        (SELECT SUM(pg.jumlah_diterima)
                            FROM penagihan as pg
                            WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                AND pg.status_penagihan = '100'
                            )
                        )
                    AS DECIMAL(20, 2)) AS invoice_saat_ini
                "),
                DB::raw("
                    CAST(
                        IFNULL((SELECT SUM(drab.harga_satuan * drab.volume) - ((rab.additional_tax / 100) * SUM(drab.harga_satuan * drab.volume))
                            FROM detail_rab as drab
                            LEFT JOIN rab
                            ON rab.id_rab = drab.id_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND (
                                rab.deleted_at IS NULL
                                AND drab.deleted_at IS NULL
                                AND rab.status_rab = '400'
                            )
                            GROUP BY rab.id_rab
                        ), 0)
                        -
                    (
                        IFNULL((SELECT SUM(pg.jumlah_diterima)
                            FROM penagihan as pg
                            WHERE pg.id_proyek = p.id_proyek
                            AND pg.deleted_at IS NULL
                        ), 0)
                        +
                        IFNULL((SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                            FROM penagihan AS pg
                            LEFT JOIN detail_penagihan AS dpg
                            ON dpg.id_penagihan = pg.id_penagihan
                            WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                AND dpg.deleted_at IS NULL
                                AND pg.status_penagihan = '100'
                            )
                        ), 0)
                        -
                        IFNULL((SELECT SUM(pg.jumlah_diterima)
                            FROM penagihan as pg
                            WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                AND pg.status_penagihan = '100'
                            )
                        ), 0)
                    ) AS DECIMAL(20, 2)) AS sisa_netto_kontrak
                ")
            )
            ->orderBy('p.id_proyek', 'asc')
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

        return Inertia::render('Keuangan/DetailPenagihanPage', [
            'penagihan' => $penagihan,
            'detailPenagihan' => $detailPenagihan,
            'evaluasi' => $evaluasi,
            'timeline' => $timeline
        ]);
    }

    public function store(StoreRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $detailPenagihan = new DetailPenagihan;

        $detailPenagihan->fill([
            'id_penagihan' => $penagihan->id_penagihan,
            'uraian' => $validated->uraian,
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
            'uraian' => $validated->uraian,
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
