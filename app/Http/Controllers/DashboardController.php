<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function admin(Request $request): Response
    {
        $proyekQuery = DB::table('proyek AS p')
            ->where([
                'p.deleted_at' => null,
                'p.status_proyek' => '100'
            ]);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery->when($request->get('tahun_anggaran'), function($query, $input) {
                $query->where('p.tahun_anggaran', $input);
            });
        }
        
        $proyek = $proyekQuery
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                'p.penyedia_jasa', 'p.tahun_anggaran',
                DB::raw(
                    "(SELECT (SUM(drab.harga_satuan * drab.volume) + (rab.tax / 100) * SUM(drab.harga_satuan * drab.volume))
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

        $sisaDanaRekening = DB::table('rekening as rk')
            ->where('rk.deleted_at', null)
            ->groupBy('rk.id_rekening')
            ->select(
                'rk.id_rekening', 'rk.nama_bank',
                'rk.nama_rekening', 'rk.nomor_rekening',
                DB::raw("
                    (SELECT SUM(p.nilai_kontrak)
                        FROM proyek AS p
                        WHERE p.id_rekening = rk.id_rekening
                        AND p.deleted_at IS  NULL
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
                            AND dpd.status_persetujuan = '400'
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
                            AND dpc.status_pembayaran = '400'
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

        $proyeksiInvoiceProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) AS invoice_sebelumnya
                "),
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    ) AS invoice_saat_ini
                "),
                DB::raw("
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
                    ) -
                    ((SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) +
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    )) AS DECIMAL(20, 2)) AS sisa_netto_kontrak
                ")
            )
            ->orderBy('p.id_proyek', 'asc')
            ->get();
            
        $proyeksiKebutuhanDanaProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->havingRaw('total_pengajuan > 0')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    IFNULL((SELECT COUNT(pc.id_pencairan_dana)
                        FROM pencairan_dana as pc
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = pc.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND pc.deleted_at IS NULL
                            AND pc.status_pencairan = '100'
                        )
                        GROUP BY pd.id_proyek
                    ), 0) AS total_pengajuan
                "),
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana as dpd
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND dpd.deleted_at IS NULL
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
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
                            AND dpc.status_pembayaran = '400'
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_belum_dibayar
                ")
            )
            ->orderBy('total_pengajuan', 'desc')
            ->get();

        $proyeksiUtang = DB::table('pencairan_dana as pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where([
                'pc.deleted_at' => null,
                'pd.deleted_at' => null,
                'p.deleted_at' => null
            ])
            ->where('pc.status_pencairan', '100')
            ->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'p.nama_proyek', 'pd.keperluan',
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                        AND (
                            dpd.status_persetujuan = '400'
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        )
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN detail_pencairan_dana as dpc
                        ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                        WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        AND dpd.status_persetujuan = '400'
                        AND dpc.status_pembayaran = '400'
                        AND (
                            dpd.deleted_at IS NULL
                            AND dpc.deleted_at IS NULL
                        )
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_utang
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        $proyeksiPiutangQuery = DB::table('penagihan AS pg')
            ->leftJoin('proyek as p', 'p.id_proyek', '=', 'pg.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'pg.deleted_at' => null,
                'pg.status_penagihan' => '100',
            ])
            ->where('pg.status_aktivitas', '!=', 'Dibuat');

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $proyeksiPiutangQuery->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPiutangQuery->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiPiutang = $proyeksiPiutangQuery->groupBy('pg.id_penagihan')
            ->select(
                'pg.id_penagihan',
                'p.id_user', 'p.nama_proyek',
                'p.pengguna_jasa', 'pg.keperluan', 
                DB::raw("
                    (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                    FROM detail_penagihan AS dpg
                    WHERE dpg.id_penagihan = pg.id_penagihan
                    AND dpg.deleted_at IS NULL) - pg.jumlah_diterima
                    AS jumlah_piutang
                ")
            )
            ->orderBy('pg.id_penagihan', 'desc')
            ->get();

        
        $overview = [
            (Object) [
                'title' => 'Proyek Selesai',
                'data' => Proyek::where('status_proyek', '400')->count(),
                'color' => 'secondary',
                'href' => route('proyek', ['status_proyek' => '400'])
            ],
            (Object) [
                'title' => 'Proyek Aktif',
                'data' => Proyek::where('status_proyek', '100')->count(),
                'color' => 'primary',
                'href' => route('proyek', ['status_proyek' => '100'])
            ]
        ];

        $options = (Object) [
            'tahunAnggaran' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('tahun_anggaran')
                ->pluck('tahun_anggaran'),
            'pic' => User::role('manajer proyek')->get(['id', 'name'])->toArray(),
            'penggunaJasa' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('pengguna_jasa')
                ->pluck('pengguna_jasa')
        ];

        return Inertia::render('Dashboard/AdminPage', [
            'proyek' => $proyek,
            'sisaDanaRekening' => $sisaDanaRekening,
            'proyeksiInvoiceProyek' => $proyeksiInvoiceProyek,
            'proyeksiKebutuhanDanaProyek' => $proyeksiKebutuhanDanaProyek,
            'proyeksiUtang' => $proyeksiUtang,
            'proyeksiPiutang' => $proyeksiPiutang,
            'overview' => $overview,
            'options' => $options
        ]);
    }

    public function manajer_proyek(Request $request): Response
    {
        $proyekQuery = DB::table('proyek AS p')
            ->leftJoin('users', 'users.id', '=', 'p.id_user')
            ->where([
                'p.deleted_at' => null,
                'p.status_proyek' => '100',
                'p.id_user' => $request->user()->id
            ]);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery->when($request->get('tahun_anggaran'), function($query, $input) {
                $query->where('p.tahun_anggaran', $input);
            });
        }
        
        $proyek = $proyekQuery
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                'p.penyedia_jasa', 'p.tahun_anggaran',
                DB::raw(
                    "(SELECT (SUM(drab.harga_satuan * drab.volume) + (rab.tax / 100) * SUM(drab.harga_satuan * drab.volume))
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

        $reminder = DB::table('pengajuan_dana AS pd')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->leftJoin('timeline AS t', 't.model_id', '=', 'pd.id_pengajuan_dana')
            ->where([
                'p.deleted_at' => null,
                't.deleted_at' => null,
                'pd.deleted_at' => null,
                'p.status_proyek' => '100',
                't.model_type' => 'App\Models\PengajuanDana',
                'pd.status_aktivitas' => 'Ditolak',
                't.status_aktivitas' => 'Ditolak'
            ])
            ->groupBy('pd.id_pengajuan_dana', 't.catatan')
            ->select(
                'pd.id_pengajuan_dana', 'p.nama_proyek',
                'pd.keperluan', 'pd.status_pengajuan',
                't.catatan'
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        $proyekAktif = $proyek->count();
        $proyekSelesai = DB::table('proyek AS p')
            ->leftJoin('users', 'users.id', '=', 'p.id_user')
            ->where([
                'p.status_proyek' => '400',
                'p.id_user' => $request->user()->id
            ])->count();

        $overview = [
            (Object) [
                'title' => 'Proyek Selesai',
                'data' => $proyekSelesai,
                'color' => 'secondary',
                'href' => route('proyek', ['status_proyek' => '400'])
            ],
            (Object) [
                'title' => 'Proyek Aktif',
                'data' => $proyekAktif,
                'color' => 'primary',
                'href' => route('proyek', ['status_proyek' => '100'])
            ]
        ];

        return Inertia::render('Dashboard/ManajerProyekPage', [
            'proyek' => $proyek,
            'reminder' => $reminder,
            'overview' => $overview
        ]);
    }

    public function kepala_divisi(Request $request): Response
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

        $piutangQuery = DB::table('penagihan AS pg')
            ->leftJoin('proyek as p', 'p.id_proyek', '=', 'pg.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'pg.deleted_at' => null,
                'pg.status_penagihan' => '100',
            ])
            ->where('pg.status_aktivitas', '!=', 'Dibuat');

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $piutangQuery->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $piutangQuery->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input['id']);
            });
        }

        $piutang = $piutangQuery->groupBy('pg.id_penagihan')
            ->select(
                'p.nama_proyek',
                'pg.id_penagihan', 'pg.keperluan',
                'p.pengguna_jasa', 'p.id_user',
                DB::raw("
                    (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                    FROM detail_penagihan AS dpg
                    WHERE dpg.id_penagihan = pg.id_penagihan
                    AND dpg.deleted_at IS NULL) - pg.jumlah_diterima
                    AS jumlah_piutang
                ")
            )
            ->orderBy('pg.id_penagihan', 'desc')
            ->get();

        $overview = [
            (Object) [
                'title' => 'Proyek Selesai',
                'data' => Proyek::where('status_proyek', '400')->count(),
                'color' => 'secondary',
                'href' => route('proyek', ['status_proyek' => '400'])
            ],
            (Object) [
                'title' => 'Proyek Aktif',
                'data' => Proyek::where('status_proyek', '100')->count(),
                'color' => 'primary',
                'href' => route('proyek', ['status_proyek' => '100'])
            ]
        ];

        $options = (Object)[
            'pic' => User::role('manajer proyek')->get(['id', 'name'])->toArray(),
            'penggunaJasa' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('pengguna_jasa')
                ->pluck('pengguna_jasa')
        ];

        return Inertia::render('Dashboard/KepalaDivisiPage', [
            'proyek' => $proyek,
            'piutang' => $piutang,
            'overview' => $overview,
            'options' => $options
        ]);
    }

    public function keuangan(Request $request): Response
    {
        $sisaDanaRekening = DB::table('rekening as rk')
            ->where('rk.deleted_at', null)
            ->groupBy('rk.id_rekening')
            ->select(
                'rk.id_rekening', 'rk.nama_bank',
                'rk.nama_rekening', 'rk.nomor_rekening',
                DB::raw("
                    (SELECT SUM(p.nilai_kontrak)
                        FROM proyek AS p
                        WHERE p.id_rekening = rk.id_rekening
                        AND p.deleted_at IS  NULL
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
                            AND dpd.status_persetujuan = '400'
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
                            AND dpc.status_pembayaran = '400'
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

        $proyeksiInvoiceProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) AS invoice_sebelumnya
                "),
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    ) AS invoice_saat_ini
                "),
                DB::raw("
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
                    ) -
                    ((SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) +
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    )) AS DECIMAL(20, 2)) AS sisa_netto_kontrak
                ")
            )
            ->orderBy('p.id_proyek', 'asc')
            ->get();
            
        $proyeksiKebutuhanDanaProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->havingRaw('total_pengajuan > 0')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    IFNULL((SELECT COUNT(pc.id_pencairan_dana)
                        FROM pencairan_dana as pc
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = pc.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND pc.deleted_at IS NULL
                            AND pc.status_pencairan = '100'
                        )
                        GROUP BY pd.id_proyek
                    ), 0) AS total_pengajuan
                "),
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana as dpd
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND dpd.deleted_at IS NULL
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
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
                            AND dpc.status_pembayaran = '400'
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_belum_dibayar
                ")
            )
            ->orderBy('total_pengajuan', 'desc')
            ->get();

        $proyeksiUtang = DB::table('pencairan_dana as pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where([
                'pc.deleted_at' => null,
                'pd.deleted_at' => null,
                'p.deleted_at' => null
            ])
            ->where('pc.status_pencairan', '100')
            ->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'p.nama_proyek', 'pd.keperluan',
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                        AND (
                            dpd.status_persetujuan = '400'
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        )
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN detail_pencairan_dana as dpc
                        ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                        WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        AND dpd.status_persetujuan = '400'
                        AND dpc.status_pembayaran = '400'
                        AND (
                            dpd.deleted_at IS NULL
                            AND dpc.deleted_at IS NULL
                        )
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_utang
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        $proyeksiPiutangQuery = DB::table('penagihan AS pg')
            ->leftJoin('proyek as p', 'p.id_proyek', '=', 'pg.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'pg.deleted_at' => null,
                'pg.status_penagihan' => '100',
            ])
            ->where('pg.status_aktivitas', '!=', 'Dibuat');

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $proyeksiPiutangQuery->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPiutangQuery->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiPiutang = $proyeksiPiutangQuery->groupBy('pg.id_penagihan')
            ->select(
                'pg.id_penagihan',
                'p.id_user', 'p.nama_proyek',
                'p.pengguna_jasa', 'pg.keperluan', 
                DB::raw("
                    (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                    FROM detail_penagihan AS dpg
                    WHERE dpg.id_penagihan = pg.id_penagihan
                    AND dpg.deleted_at IS NULL) - pg.jumlah_diterima
                    AS jumlah_piutang
                ")
            )
            ->orderBy('pg.id_penagihan', 'desc')
            ->get();

        $overview = [
            (Object) [
                'title' => 'Proyek Selesai',
                'data' => Proyek::where('status_proyek', '400')->count(),
                'color' => 'secondary',
                'href' => route('proyek', ['status_proyek' => '400'])
            ],
            (Object) [
                'title' => 'Proyek Aktif',
                'data' => Proyek::where('status_proyek', '100')->count(),
                'color' => 'primary',
                'href' => route('proyek', ['status_proyek' => '100'])
            ]
        ];

        $options = (Object)[
            'pic' => User::role('manajer proyek')->get(['id', 'name'])->toArray(),
            'penggunaJasa' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('pengguna_jasa')
                ->pluck('pengguna_jasa')
        ];

        return Inertia::render('Dashboard/KeuanganPage', [
            'sisaDanaRekening' => $sisaDanaRekening,
            'proyeksiInvoiceProyek' => $proyeksiInvoiceProyek,
            'proyeksiKebutuhanDanaProyek' => $proyeksiKebutuhanDanaProyek,
            'proyeksiUtang' => $proyeksiUtang,
            'proyeksiPiutang' => $proyeksiPiutang,
            'options' => $options,
            'overview' => $overview
        ]);
    }

    public function direktur_utama(Request $request): Response
    {
        $proyekQuery = DB::table('proyek AS p')
            ->where([
                'p.deleted_at' => null,
                'p.status_proyek' => '100'
            ]);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery->when($request->get('tahun_anggaran'), function($query, $input) {
                $query->where('p.tahun_anggaran', $input);
            });
        }
        
        $proyek = $proyekQuery
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                'p.penyedia_jasa', 'p.tahun_anggaran',
                DB::raw(
                    "(SELECT (SUM(drab.harga_satuan * drab.volume) + (rab.tax / 100) * SUM(drab.harga_satuan * drab.volume))
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

            $sisaDanaRekening = DB::table('rekening as rk')
            ->where('rk.deleted_at', null)
            ->groupBy('rk.id_rekening')
            ->select(
                'rk.id_rekening', 'rk.nama_bank',
                'rk.nama_rekening', 'rk.nomor_rekening',
                DB::raw("
                    (SELECT SUM(p.nilai_kontrak)
                        FROM proyek AS p
                        WHERE p.id_rekening = rk.id_rekening
                        AND p.deleted_at IS  NULL
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
                            AND dpd.status_persetujuan = '400'
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
                            AND dpc.status_pembayaran = '400'
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

        $proyeksiInvoiceProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) AS invoice_sebelumnya
                "),
                DB::raw("
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    ) AS invoice_saat_ini
                "),
                DB::raw("
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
                    ) -
                    ((SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) +
                    (SELECT SUM(pg.jumlah_diterima)
                        FROM penagihan as pg
                        WHERE pg.id_proyek = p.id_proyek
                        AND (
                            pg.deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    )) AS DECIMAL(20, 2)) AS sisa_netto_kontrak
                ")
            )
            ->orderBy('p.id_proyek', 'asc')
            ->get();
            
        $proyeksiKebutuhanDanaProyek = DB::table('proyek as p')
            ->where('p.deleted_at', null)
            ->groupBy('p.id_proyek')
            ->havingRaw('total_pengajuan > 0')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw("
                    IFNULL((SELECT COUNT(pc.id_pencairan_dana)
                        FROM pencairan_dana as pc
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = pc.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND pc.deleted_at IS NULL
                            AND pc.status_pencairan = '100'
                        )
                        GROUP BY pd.id_proyek
                    ), 0) AS total_pengajuan
                "),
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana as dpd
                        LEFT JOIN pengajuan_dana as pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND (
                            pd.deleted_at IS NULL
                            AND dpd.deleted_at IS NULL
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
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
                            AND dpc.status_pembayaran = '400'
                        )
                        GROUP BY pd.id_proyek
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_belum_dibayar
                ")
            )
            ->orderBy('total_pengajuan', 'desc')
            ->get();

        $proyeksiUtang = DB::table('pencairan_dana as pc')
            ->leftJoin('pengajuan_dana AS pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek AS p', 'p.id_proyek', '=', 'pd.id_proyek')
            ->where([
                'pc.deleted_at' => null,
                'pd.deleted_at' => null,
                'p.deleted_at' => null
            ])
            ->where('pc.status_pencairan', '100')
            ->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana',
                'p.nama_proyek', 'pd.keperluan',
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.deleted_at IS NULL
                        AND (
                            dpd.status_persetujuan = '400'
                            AND dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        )
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpc.jumlah_pencairan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN detail_pencairan_dana as dpc
                        ON dpc.id_detail_pengajuan_dana = dpd.id_detail_pengajuan_dana
                        WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        AND dpd.status_persetujuan = '400'
                        AND dpc.status_pembayaran = '400'
                        AND (
                            dpd.deleted_at IS NULL
                            AND dpc.deleted_at IS NULL
                        )
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_utang
                ")
            )
            ->orderBy('pd.id_pengajuan_dana', 'desc')
            ->get();

        $proyeksiPiutangQuery = DB::table('penagihan AS pg')
            ->leftJoin('proyek as p', 'p.id_proyek', '=', 'pg.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'pg.deleted_at' => null,
                'pg.status_penagihan' => '100',
            ])
            ->where('pg.status_aktivitas', '!=', 'Dibuat');

        if ($request->isMethod('get') && $request->get('piutang_query')) {
            $proyeksiPiutangQuery->when($request->get('piutang_pengguna_jasa'), function($query, $input) {
                $query->where('p.pengguna_jasa', $input);
            });

            $proyeksiPiutangQuery->when($request->get('piutang_pic'), function($query, $input) {
                $query->where('p.id_user', $input);
            });
        }

        $proyeksiPiutang = $proyeksiPiutangQuery->groupBy('pg.id_penagihan')
            ->select(
                'pg.id_penagihan',
                'p.id_user', 'p.nama_proyek',
                'p.pengguna_jasa', 'pg.keperluan', 
                DB::raw("
                    (SELECT SUM(dpg.harga_satuan_penagihan * dpg.volume_penagihan)
                    FROM detail_penagihan AS dpg
                    WHERE dpg.id_penagihan = pg.id_penagihan
                    AND dpg.deleted_at IS NULL) - pg.jumlah_diterima
                    AS jumlah_piutang
                ")
            )
            ->orderBy('pg.id_penagihan', 'desc')
            ->get();

        
        $overview = [
            (Object) [
                'title' => 'Proyek Selesai',
                'data' => Proyek::where('status_proyek', '400')->count(),
                'color' => 'secondary',
                'href' => route('proyek', ['status_proyek' => '400'])
            ],
            (Object) [
                'title' => 'Proyek Aktif',
                'data' => Proyek::where('status_proyek', '100')->count(),
                'color' => 'primary',
                'href' => route('proyek', ['status_proyek' => '100'])
            ]
        ];

        $options = (Object) [
            'tahunAnggaran' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('tahun_anggaran')
                ->pluck('tahun_anggaran'),
            'pic' => User::role('manajer proyek')->get(['id', 'name'])->toArray(),
            'penggunaJasa' => DB::table('proyek')
                ->where('deleted_at', null)
                ->groupBy('pengguna_jasa')
                ->pluck('pengguna_jasa')
        ];

        return Inertia::render('Dashboard/DirekturUtamaPage', [
            'proyek' => $proyek,
            'sisaDanaRekening' => $sisaDanaRekening,
            'proyeksiInvoiceProyek' => $proyeksiInvoiceProyek,
            'proyeksiKebutuhanDanaProyek' => $proyeksiKebutuhanDanaProyek,
            'proyeksiUtang' => $proyeksiUtang,
            'proyeksiPiutang' => $proyeksiPiutang,
            'overview' => $overview,
            'options' => $options
        ]);
    }
}
