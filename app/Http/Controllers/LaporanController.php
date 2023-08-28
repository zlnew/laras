<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class LaporanController extends Controller
{
    public function pengajuan_dana(Request $request): Response
    {
        $pengajuanDanaQuery = DB::table('pengajuan_dana as pd')
            ->leftJoin('detail_pengajuan_dana as dpd', 'dpd.id_pengajuan_dana', '=', 'pd.id_pengajuan_dana')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'pd.id_proyek')
            ->leftJoin('users as us', 'us.id', '=', 'pr.id_user')
            ->leftJoin('rekening as rk', 'rk.id_rekening', '=', 'pr.id_rekening')
            ->where([
                'pd.deleted_at' => null,
                'pr.deleted_at' => null,
            ])
            ->where('pd.tanggal_pengajuan', '!=', null);

        if ($request->isMethod('get') && $request->all()) {
            $pengajuanDanaQuery->when($request->get('id_proyek'), function($query, $input) {
                $query->whereIn('pd.id_proyek', $input);
            });

            $pengajuanDanaQuery->when($request->get('jenis_transaksi'), function($query, $input) {
                $query->where('pd.jenis_transaksi', $input);
            });

            $pengajuanDanaQuery->when($request->get('status_pengajuan'), function($query, $input) {
                $query->where('pd.status_pengajuan', $input);
            });

            $pengajuanDanaQuery->when($request->get('ditolak') === 'true', function($query) {
                $query->where('pd.status_aktivitas', 'Ditolak');
            });
        }

        $pengajuanDana = $pengajuanDanaQuery
            ->groupBy('pd.id_pengajuan_dana')
            ->select(
                'pd.id_pengajuan_dana', 'pr.nilai_kontrak',
                'pr.id_proyek', 'pr.nama_proyek',
                'pr.nomor_kontrak', 'pr.tanggal_kontrak',
                'pr.pengguna_jasa', 'pr.penyedia_jasa',
                'pr.tahun_anggaran', 'pr.nomor_spmk',
                'pr.tanggal_spmk', 'pr.tanggal_mulai',
                'pr.durasi', 'pr.tanggal_selesai',
                'us.id as id_user', 'us.name as pic',
                'pr.status_proyek', 'rk.id_rekening',
                'rk.nama_bank', 'rk.nomor_rekening',
                'rk.nama_rekening', 'pd.jenis_transaksi',
                'pd.keperluan', 'pd.tanggal_pengajuan',
                'pd.status_pengajuan', 'pd.status_aktivitas',
                DB::raw("SUM(dpd.jumlah_pengajuan) AS nilai_pengajuan"),
                DB::raw("
                    CAST(SUM(
                        CASE
                            WHEN dpd.status_persetujuan = '400'
                            AND dpd.deleted_at IS NULL
                            THEN dpd.jumlah_pengajuan
                        END
                    ) AS DECIMAL(20, 2)) AS jumlah_disetujui"
                ),
            )
            ->orderBy('pd.id_pengajuan_dana', 'asc')
            ->get();

        $proyek = DB::table('proyek')
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran'
            )
            ->get();

        $formOptions = (object) [
            'proyek' => $proyek
        ];
        
        return Inertia::render('Laporan/LaporanPengajuanDanaPage', [
            'pengajuanDana' => $pengajuanDana,
            'formOptions' => $formOptions
        ]);
    }

    public function pencairan_dana(Request $request): Response
    {
        $pencairanDanaQuery = DB::table('pencairan_dana as pc')
            ->leftJoin('pengajuan_dana as pd', 'pd.id_pengajuan_dana', '=', 'pc.id_pengajuan_dana')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'pd.id_proyek')
            ->leftJoin('users as us', 'us.id', '=', 'pr.id_user')
            ->leftJoin('rekening as rk', 'rk.id_rekening', '=', 'pr.id_rekening')
            ->where([
                'pc.deleted_at' => null,
                'pd.deleted_at' => null,
                'pr.deleted_at' => null,
            ])
            ->where('pd.tanggal_pengajuan', '!=', null);

        if ($request->isMethod('get') && $request->all()) {
            $pencairanDanaQuery->when($request->get('id_proyek'), function($query, $input) {
                $query->whereIn('pd.id_proyek', $input);
            });

            $pencairanDanaQuery->when($request->get('status_pencairan'), function($query, $input) {
                $query->where('pc.status_pencairan', $input);
            });

            $pencairanDanaQuery->when($request->get('ditolak') === 'true', function($query) {
                $query->where('pc.status_aktivitas', 'Ditolak');
            });
        }

        $pencairanDana = $pencairanDanaQuery
            ->groupBy('pc.id_pencairan_dana')
            ->select(
                'pc.id_pencairan_dana', 'pr.nilai_kontrak',
                'pr.id_proyek', 'pr.nama_proyek',
                'pr.nomor_kontrak', 'pr.tanggal_kontrak',
                'pr.pengguna_jasa', 'pr.penyedia_jasa',
                'pr.tahun_anggaran', 'pr.nomor_spmk',
                'pr.tanggal_spmk', 'pr.tanggal_mulai',
                'pr.durasi', 'pr.tanggal_selesai',
                'us.id as id_user', 'us.name as pic',
                'pr.status_proyek', 'rk.id_rekening',
                'rk.nama_bank', 'rk.nomor_rekening',
                'rk.nama_rekening',
                'pd.keperluan', 'pd.tanggal_pengajuan',
                'pc.status_pencairan', 'pc.status_aktivitas',
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        AND(
                            dpd.status_persetujuan = '400'
                            AND dpd.deleted_at IS NULL
                    )) AS DECIMAL(20, 2)) AS nilai_pengajuan
                "),
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pencairan)
                        FROM detail_pencairan_dana AS dpd
                        WHERE dpd.id_pencairan_dana = pc.id_pencairan_dana
                        AND(
                            dpd.deleted_at IS NULL
                    )) AS DECIMAL(20, 2)) AS jumlah_sudah_dibayar
                "),
                DB::raw("
                    CAST((SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        WHERE dpd.id_pengajuan_dana = pd.id_pengajuan_dana
                        AND(
                            dpd.status_persetujuan = '400'
                            AND dpd.deleted_at IS NULL
                        )
                    ) AS DECIMAL(20, 2)) -
                    IFNULL(CAST((SELECT SUM(dpd.jumlah_pencairan)
                        FROM detail_pencairan_dana AS dpd
                        WHERE dpd.id_pencairan_dana = pc.id_pencairan_dana
                        AND dpd.deleted_at IS NULL
                    ) AS DECIMAL(20, 2)), 0) AS jumlah_belum_dibayar
                ")
            )
            ->orderBy('pc.id_pencairan_dana', 'asc')
            ->get();

        $proyek = DB::table('proyek')
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran'
            )
            ->get();

        $formOptions = (object) [
            'proyek' => $proyek
        ];
        
        return Inertia::render('Laporan/LaporanPencairanDanaPage', [
            'pencairanDana' => $pencairanDana,
            'formOptions' => $formOptions
        ]);
    }

    public function penagihan(Request $request): Response
    {
        $penagihanQuery = DB::table('penagihan as pg')
            ->leftJoin('detail_penagihan as dpg', 'dpg.id_penagihan', '=', 'pg.id_penagihan')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'pg.id_proyek')
            ->leftJoin('users as us', 'us.id', '=', 'pr.id_user')
            ->leftJoin('rekening as rk', 'rk.id_rekening', '=', 'pr.id_rekening')
            ->where([
                'pg.deleted_at' => null,
                'dpg.deleted_at' => null,
                'pr.deleted_at' => null,
            ])
            ->where('pg.tanggal_pengajuan', '!=', null);

        if ($request->isMethod('get') && $request->all()) {
            $penagihanQuery->when($request->get('id_proyek'), function($query, $input) {
                $query->whereIn('pg.id_proyek', $input);
            });

            $penagihanQuery->when($request->get('status_penagihan'), function($query, $input) {
                $query->where('pg.status_penagihan', $input);
            });

            $penagihanQuery->when($request->get('ditolak') === 'true', function($query) {
                $query->where('pg.status_aktivitas', 'Ditolak');
            });
        }

        $penagihan = $penagihanQuery
            ->groupBy('pg.id_penagihan')
            ->select(
                'pg.id_penagihan', 'pr.nilai_kontrak',
                'pr.id_proyek', 'pr.nama_proyek',
                'pr.nomor_kontrak', 'pr.tanggal_kontrak',
                'pr.pengguna_jasa', 'pr.penyedia_jasa',
                'pr.tahun_anggaran', 'pr.nomor_spmk',
                'pr.tanggal_spmk', 'pr.tanggal_mulai',
                'pr.durasi', 'pr.tanggal_selesai',
                'us.id as id_user', 'us.name as pic',
                'pr.status_proyek', 'rk.id_rekening',
                'rk.nama_bank', 'rk.nomor_rekening',
                'rk.nama_rekening',
                'pg.keperluan', 'pg.tanggal_pengajuan',
                'pg.status_penagihan', 'pg.status_aktivitas',
                'pg.jumlah_diterima',
                DB::raw("
                    CAST(
                        SUM(dpg.volume_penagihan * dpg.harga_satuan_penagihan)
                    AS DECIMAL(20, 2))
                    AS jumlah_penagihan
                "),
                DB::raw("
                    CAST(
                        (SUM(dpg.volume_penagihan * dpg.harga_satuan_penagihan) - pg.jumlah_diterima)
                    AS DECIMAL(20, 2))
                    AS sisa_penagihan
                "),
            )
            ->orderBy('pg.id_penagihan', 'asc')
            ->get();

        $proyek = DB::table('proyek')
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran'
            )
            ->get();

        $formOptions = (object) [
            'proyek' => $proyek
        ];
        
        return Inertia::render('Laporan/LaporanPenagihanPage', [
            'penagihan' => $penagihan,
            'formOptions' => $formOptions
        ]);
    }
}
