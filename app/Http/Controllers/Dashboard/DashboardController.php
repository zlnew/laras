<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getProyek ($request)
    {
        $proyekBuilder = DB::table('proyek AS p')
            ->where('p.deleted_at', null)
            ->where('p.status_proyek', '100');

        if ($request->isMethod('get') && $request->get('proyek_query')) {
            $proyekBuilder->when($request->get('proyek_tahun_anggaran'), function($query, $input) {
                $query->where('p.tahun_anggaran', $input);
            });
        }
        
        $proyek = $proyekBuilder->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek',
                'p.nama_proyek',
                'p.penyedia_jasa',
                'p.tahun_anggaran',
                DB::raw(
                    "(SELECT (
                            SUM(drab.harga_satuan * drab.volume) +
                            (rab.tax / 100) *
                            SUM(drab.harga_satuan * drab.volume)
                        )
                        FROM detail_rab AS drab
                        LEFT JOIN rab
                        ON rab.id_rab = drab.id_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND (
                            drab.deleted_at IS NULL
                            AND rab.deleted_at IS NULL
                            AND rab.status_rab = '400'
                        )
                        GROUP BY rab.id_rab
                    ) AS nilai_kontrak"
                ),
                DB::raw(
                    "(SELECT SUM(drap.harga_satuan * drap.volume)
                        FROM detail_rap AS drap
                        LEFT JOIN rap
                        ON rap.id_rap = drap.id_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND (
                            drap.deleted_at IS NULL
                            AND rap.deleted_at IS NULL
                            AND rap.status_rap = '400'
                        )
                        GROUP BY rap.id_rap
                    ) AS rap"
                ),
                DB::raw(
                    "(SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            dpd.deleted_at IS NULL
                            AND pd.deleted_at IS NULL
                            AND dpd.status_persetujuan = '400'
                        )
                        GROUP BY pd.id_proyek
                    ) AS pengajuan_sebelumnya"
                ),
                DB::raw(
                    "(SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            dpd.deleted_at IS NULL
                            AND pd.deleted_at IS NULL
                            AND dpd.status_persetujuan = '100'
                            AND pd.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pd.id_proyek
                    ) AS pengajuan_dalam_proses"
                ),
                DB::raw(
                    "(SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            dpd.deleted_at IS NULL
                            AND pd.deleted_at IS NULL
                            AND pd.status_pengajuan = '400'
                        )
                        GROUP BY pd.id_proyek
                    ) AS total_pengajuan"
                ),
                DB::raw(
                    "(SELECT SUM(drap.harga_satuan * drap.volume)
                        FROM detail_rap AS drap
                        LEFT JOIN rap
                        ON rap.id_rap = drap.id_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND (
                            drap.deleted_at IS NULL
                            AND rap.deleted_at IS NULL
                            AND rap.status_rap = '400'
                        )
                        GROUP BY rap.id_rap
                    ) -
                    IFNULL((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            dpd.deleted_at IS NULL
                            AND pd.deleted_at IS NULL
                            AND pd.status_pengajuan = '400'
                        )
                        GROUP BY pd.id_proyek
                    ), 0) AS sisa_anggaran"
                ),
                DB::raw(
                    "(SELECT (SUM(drab.harga_satuan * drab.volume) - (rab.additional_tax / 100) * SUM(drab.harga_satuan * drab.volume))
                        FROM detail_rab AS drab
                        LEFT JOIN rab
                        ON rab.id_rab = drab.id_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND (
                            drab.deleted_at IS NULL
                            AND rab.deleted_at IS NULL
                            AND rab.status_rab = '400'
                        )
                        GROUP BY rab.id_rab
                    ) - (SELECT SUM(drap.harga_satuan * drap.volume)
                        FROM detail_rap AS drap
                        LEFT JOIN rap
                        ON rap.id_rap = drap.id_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND (
                            drap.deleted_at IS NULL
                            AND rap.deleted_at IS NULL
                            AND rap.status_rap = '400'
                        )
                        GROUP BY rap.id_rap
                    ) AS estimasi_laba"
                ),
                DB::raw(
                    "(((SELECT (SUM(drab.harga_satuan * drab.volume) - (rab.additional_tax / 100) * SUM(drab.harga_satuan * drab.volume))
                        FROM detail_rab AS drab
                        LEFT JOIN rab
                        ON rab.id_rab = drab.id_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND (
                            drab.deleted_at IS NULL
                            AND rab.deleted_at IS NULL
                            AND rab.status_rab = '400'
                        )
                        GROUP BY rab.id_rab
                    ) - (SELECT SUM(drap.harga_satuan * drap.volume)
                        FROM detail_rap AS drap
                        LEFT JOIN rap
                        ON rap.id_rap = drap.id_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND (
                            drap.deleted_at IS NULL
                            AND rap.deleted_at IS NULL
                            AND rap.status_rap = '400'
                        )
                        GROUP BY rap.id_rap
                    )) * 100) / (SELECT (SUM(drab.harga_satuan * drab.volume) - (rab.additional_tax / 100) * SUM(drab.harga_satuan * drab.volume))
                        FROM detail_rab AS drab
                        LEFT JOIN rab
                        ON rab.id_rab = drab.id_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND (
                            drab.deleted_at IS NULL
                            AND rab.deleted_at IS NULL
                            AND rab.status_rab = '400'
                        )
                        GROUP BY rab.id_rab
                    ) AS persentase_laba"
                ),
            )
            ->orderBy('p.id_proyek', 'asc')
            ->get();

        return $proyek;
    }

    public function getProyekV2 ()
    {
        $proyek = DB::table('proyek AS p')
            ->where([
                'p.deleted_at' => null,
                'p.status_proyek' => '100'
            ])
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw(
                    "(SELECT (SUM(drab.harga_satuan * drab.volume) + (rab.tax / 100) * SUM(drab.harga_satuan * drab.volume))
                        FROM detail_rab AS drab
                        LEFT JOIN rab ON rab.id_rab = drab.id_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND (
                            drab.deleted_at IS NULL
                            AND rab.deleted_at IS NULL
                        )
                        GROUP BY rab.id_rab
                    ) AS nilai_kontrak"
                ),
                DB::raw(
                    "(SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        LEFT JOIN penagihan AS pg
                        ON pg.id_penagihan = dpg.id_penagihan
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            dpg.deleted_at IS NULL
                            AND pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                        GROUP BY pg.id_proyek
                    ) AS termin_sebelumnya"
                ),
                DB::raw(
                    "(SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        LEFT JOIN penagihan AS pg
                        ON pg.id_penagihan = dpg.id_penagihan
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            dpg.deleted_at IS NULL
                            AND pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                            AND pg.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pg.id_proyek
                    ) AS termin_dalam_proses"
                ),
                DB::raw(
                    "(SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        LEFT JOIN penagihan AS pg
                        ON pg.id_penagihan = dpg.id_penagihan
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            dpg.deleted_at IS NULL
                            AND pg.deleted_at IS NULL
                            AND pg.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pg.id_proyek
                    ) - (SELECT SUM(pg.potongan_ppn + pg.potongan_pph + pg.potongan_lainnya)
                        FROM penagihan AS pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pg.id_proyek
                    )
                    AS total_pencairan"
                ),
                DB::raw(
                    "(SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        LEFT JOIN penagihan AS pg
                        ON pg.id_penagihan = dpg.id_penagihan
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            dpg.deleted_at IS NULL
                            AND pg.deleted_at IS NULL
                            AND pg.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pg.id_proyek
                    )  - (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan AS pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_aktivitas != 'Dibuat'
                        )
                        GROUP BY pg.id_proyek
                    ) AS sisa_penagihan"
                ),
            )
            ->orderBy('p.id_proyek', 'asc')
            ->get();

        return $proyek;
    }

    public function getSisaDanaRekening ()
    {
        $sisaDanaRekening = DB::table('rekening as rk')
            ->where('rk.deleted_at', null)
            ->where('rk.tujuan_rekening', 'Penerimaan Invoice')
            ->groupBy('rk.id_rekening')
            ->select(
                'rk.id_rekening',
                'rk.nama_bank',
                'rk.nama_rekening',
                'rk.nomor_rekening',
                DB::raw("
                    (SELECT SUM(p.nilai_kontrak)
                        FROM proyek AS p
                        WHERE p.id_rekening = rk.id_rekening
                        AND p.deleted_at IS NULL
                        GROUP BY p.id_rekening
                    ) AS nilai_kontrak
                "),
                DB::raw("
                    (SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE dpd.id_rekening = rk.id_rekening
                        AND (
                            dpd.deleted_at IS NULL
                            AND pd.deleted_at IS NULL
                        )
                    ) AS total_pengajuan_dana"
                ),
                DB::raw("
                    (SELECT SUM(dpc.jumlah_pencairan)
                        FROM detail_pencairan_dana AS dpc
                        LEFT JOIN pencairan_dana AS pc
                        ON pc.id_pencairan_dana = dpc.id_pencairan_dana
                        LEFT JOIN detail_pengajuan_dana AS dpd
                        ON dpd.id_detail_pengajuan_dana = dpc.id_detail_pengajuan_dana
                        WHERE dpd.id_rekening = rk.id_rekening
                        AND (
                            dpc.deleted_at IS NULL
                            AND pc.deleted_at IS NULL
                            AND dpd.deleted_at IS NULL
                        )
                    ) AS total_pencairan_dana"
                ),
                DB::raw("
                    (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        LEFT JOIN penagihan AS pg
                        ON pg.id_penagihan = dpg.id_penagihan
                        WHERE pg.id_rekening = rk.id_rekening
                        AND (
                            pg.deleted_at IS NULL
                            AND dpg.deleted_at IS NULL
                        )
                    ) AS total_penagihan"
                ),
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan AS pg
                        WHERE pg.id_rekening = rk.id_rekening
                        AND pg.deleted_at IS NULL
                    ) AS total_penagihan_diterima"
                )
            )
            ->orderBy('rk.id_rekening', 'desc')
            ->get();

        return $sisaDanaRekening;
    }

    public function getProyeksiInvoiceProyek ()
    {
        $proyeksiInvoiceProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->having('total_penagihan', '>', 0)
            ->select(
                'p.id_proyek',
                'p.nama_proyek',
                DB::raw("
                    (
                        SELECT COUNT(pg.id_penagihan)
                        FROM penagihan AS pg
                        WHERE pg.id_proyek = p.id_proyek
                            AND pg.deleted_at IS NULL
                    ) AS total_penagihan
                "),
                DB::raw("
                    (
                        SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                            AND pg.deleted_at IS NULL
                    ) AS invoice_sebelumnya
                "),
                DB::raw("
                    (
                        SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM penagihan AS pg
                        LEFT JOIN detail_penagihan AS dpg
                            ON dpg.id_penagihan = pg.id_penagihan
                        WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                    AND dpg.deleted_at IS NULL
                                    AND pg.status_penagihan = '100'
                            )
                    )
                    -
                    (
                        SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                            AND (
                                pg.deleted_at IS NULL
                                    AND pg.status_penagihan = '100'
                            )
                    ) AS invoice_saat_ini
                "),
                DB::raw("
                    CAST(
                        IFNULL((
                            SELECT
                                SUM(drab.harga_satuan * drab.volume) -
                                (
                                    (rab.additional_tax / 100) *
                                    SUM(drab.harga_satuan * drab.volume)
                                )
                            FROM detail_rab AS drab
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
                        IFNULL((
                            SELECT SUM(pg.jumlah_diterima)
                            FROM penagihan as pg
                            WHERE pg.id_proyek = p.id_proyek
                                AND pg.deleted_at IS NULL
                        ), 0)
                        +
                        IFNULL((
                            SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
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
                        IFNULL((
                            SELECT SUM(pg.jumlah_diterima)
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

        return $proyeksiInvoiceProyek;
    }

    public function getProyeksiKebutuhanDanaProyek ()
    {
        $proyeksiKebutuhanDanaProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->having('total_pengajuan', '>', 0)
            ->having('jumlah_belum_dibayar', '>', 0)
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek',
                'p.nama_proyek',
                DB::raw("
                    IFNULL((
                        SELECT COUNT(pc.id_pencairan_dana)
                        FROM pencairan_dana as pc
                        LEFT JOIN pengajuan_dana as pd
                            ON pd.id_pengajuan_dana = pc.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                            AND (
                                pd.deleted_at IS NULL
                                    AND pc.deleted_at IS NULL
                                    AND pc.status_pencairan = '100'
                                    AND pd.jenis_transaksi = 'Pembayaran'
                            )
                        GROUP BY pd.id_proyek
                    ), 0) AS total_pengajuan
                "),
                DB::raw("
                    CAST((
                        SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana as dpd
                        LEFT JOIN pengajuan_dana as pd
                            ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                            AND (
                                pd.deleted_at IS NULL
                                    AND dpd.deleted_at IS NULL
                                    AND pd.jenis_transaksi = 'Pembayaran'
                            )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2))
                    -
                    IFNULL(
                        CAST((
                            SELECT SUM(dpc.jumlah_pencairan)
                            FROM detail_pengajuan_dana as dpd
                            LEFT JOIN pengajuan_dana as pd
                                ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                            LEFT JOIN detail_pencairan_dana as dpc
                                ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                            WHERE pd.id_proyek = p.id_proyek
                                AND (
                                    pd.deleted_at IS NULL
                                        AND dpd.deleted_at IS NULL
                                        AND dpc.deleted_at IS NULL
                                        AND dpd.status_persetujuan = '400'
                                )
                            GROUP BY pd.id_proyek
                        ) AS DECIMAL(20, 2)),
                    0) AS jumlah_belum_dibayar
                ")
            )
            ->orderBy('total_pengajuan', 'desc')
            ->get();

        return $proyeksiKebutuhanDanaProyek;
    } 

    public function getProyeksiUtang ($request)
    {
        $proyeksiUtangBuilder = DB::table('pencairan_dana AS pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where('pc.deleted_at', null)
            ->where('pd.deleted_at', null)
            ->where('p.deleted_at', null)
            ->where('pd.jenis_transaksi', 'Utang')
            ->orWhere('pd.kategori', 'Proyek')
            ->having('jumlah_utang', '>', 0);

        if ($request->isMethod('get') && $request->get('utang_query')) {
            $proyeksiUtangBuilder->when($request->get('utang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiUtangBuilder->when($request->get('utang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }
        
        $proyeksiUtang = $proyeksiUtangBuilder->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'pd.keperluan',
                'p.nama_proyek',
                DB::raw("
                    CAST((
                        SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                    ) AS DECIMAL(20, 2))
                    -
                    IFNULL(
                        CAST((
                            SELECT SUM(dpc.jumlah_pencairan)
                            FROM detail_pengajuan_dana AS dpd
                            LEFT JOIN detail_pencairan_dana as dpc
                                ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                            WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                                AND (
                                    dpd.deleted_at IS NULL
                                        AND dpc.deleted_at IS NULL
                                )
                        ) AS DECIMAL(20, 2)),
                    0) AS jumlah_utang
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();
        
        return $proyeksiUtang;
    }

    public function getProyeksiPiutang ($request)
    {
        $proyeksiPiutangInvoiceBuilder = DB::table('penagihan AS pg')
            ->leftJoin('proyek as p', 'p.id_proyek', '=', 'pg.id_proyek')
            ->where('p.deleted_at', null)
            ->where('pg.deleted_at', null)
            ->where('pg.status_penagihan', '100')
            ->where('pg.status_aktivitas', '!=', 'Dibuat')
            ->having('jumlah_piutang', '>', 0);

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $proyeksiPiutangInvoiceBuilder->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPiutangInvoiceBuilder->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiPiutangInvoice = $proyeksiPiutangInvoiceBuilder->groupBy('pg.id_penagihan')
            ->select(
                'pg.id_penagihan',
                'pg.keperluan', 
                'p.id_user',
                'p.nama_proyek',
                'p.pengguna_jasa',
                DB::raw("
                    (
                        SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                        FROM detail_penagihan AS dpg
                        WHERE dpg.id_penagihan = pg.id_penagihan
                            AND dpg.deleted_at IS NULL
                    ) - pg.jumlah_diterima AS jumlah_piutang
                ")
            )
            ->orderBy('pg.id_penagihan', 'desc')
            ->get();

        $proyeksiPiutangDirectBuilder = DB::table('pencairan_dana AS pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where('pc.deleted_at', null)
            ->where('pd.deleted_at', null)
            ->where('p.deleted_at', null)
            ->where('pd.jenis_transaksi', 'Piutang')
            ->having('jumlah_piutang', '>', 0);

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $proyeksiPiutangDirectBuilder->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPiutangDirectBuilder->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }
        
        $proyeksiPiutangDirect = $proyeksiPiutangDirectBuilder->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'pd.keperluan',
                'p.id_user',
                'p.nama_proyek',
                'p.pengguna_jasa',
                DB::raw("
                    CAST((
                        SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                    ) AS DECIMAL(20, 2))
                    -
                    IFNULL(
                        CAST((
                            SELECT SUM(dpc.jumlah_pencairan)
                            FROM detail_pengajuan_dana AS dpd
                            LEFT JOIN detail_pencairan_dana as dpc
                                ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                            WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                                AND (
                                    dpd.deleted_at IS NULL
                                        AND dpc.deleted_at IS NULL
                                )
                        ) AS DECIMAL(20, 2)),
                    0) AS jumlah_piutang
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        $proyeksiPiutang = collect($proyeksiPiutangInvoice)
            ->merge($proyeksiPiutangDirect)
            ->all();

        return $proyeksiPiutang;
    }

    public function getProyeksiSetoranModal ($request)
    {
        $proyeksiSetoranModalBuilder = DB::table('pencairan_dana AS pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where('pc.deleted_at', null)
            ->where('pd.deleted_at', null)
            ->where('p.deleted_at', null)
            ->where('pd.jenis_transaksi', 'Setoran Modal')
            ->having('jumlah_setoran_modal', '>', 0);
            
        if ($request->isMethod('get') && $request->get('setoran_modal_query')) {
            $proyeksiSetoranModalBuilder->when($request->get('setoran_modal_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiSetoranModalBuilder->when($request->get('setoran_modal_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiSetoranModal = $proyeksiSetoranModalBuilder->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'pd.keperluan',
                'p.nama_proyek',
                DB::raw("
                    CAST((
                        SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                    ) AS DECIMAL(20, 2))
                    -
                    IFNULL(
                        CAST((
                            SELECT SUM(dpc.jumlah_pencairan)
                            FROM detail_pengajuan_dana AS dpd
                            LEFT JOIN detail_pencairan_dana as dpc
                                ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                            WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                                AND (
                                    dpd.deleted_at IS NULL
                                        AND dpc.deleted_at IS NULL
                                )
                        ) AS DECIMAL(20, 2)),
                    0) AS jumlah_setoran_modal
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        return $proyeksiSetoranModal;
    }

    public function getProyeksiPenarikan ($request)
    {
        $proyeksiPenarikan = DB::table('pencairan_dana AS pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where('pc.deleted_at', null)
            ->where('pd.deleted_at', null)
            ->where('p.deleted_at', null)
            ->where('pd.jenis_transaksi', 'Penarikan')
            ->having('jumlah_penarikan', '>', 0);
            
        if ($request->isMethod('get') && $request->get('penarikan_query')) {
            $proyeksiPenarikan->when($request->get('penarikan_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPenarikan->when($request->get('penarikan_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiPenarikan = $proyeksiPenarikan->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'pd.keperluan',
                'p.nama_proyek',
                DB::raw("
                    CAST((
                        SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                    ) AS DECIMAL(20, 2))
                    -
                    IFNULL(
                        CAST((
                            SELECT SUM(dpc.jumlah_pencairan)
                            FROM detail_pengajuan_dana AS dpd
                            LEFT JOIN detail_pencairan_dana as dpc
                                ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                            WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                                AND (
                                    dpd.deleted_at IS NULL
                                        AND dpc.deleted_at IS NULL
                                )
                        ) AS DECIMAL(20, 2)),
                    0) AS jumlah_penarikan
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        return $proyeksiPenarikan;
    }
}