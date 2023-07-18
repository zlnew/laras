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
        $PengajuanDana = DB::table('pengajuan_dana as pd')
            ->leftJoin('keuangan as ka', 'ka.id_keuangan', '=', 'pd.id_keuangan')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'ka.id_proyek')
            ->leftJoin('detail_pengajuan_dana as d_pd', 'd_pd.id_pengajuan_dana', '=', 'pd.id_pengajuan_dana');

        if ($request->isMethod('get') && $request->all()) {
            $PengajuanDana->when($request->get('nama_proyek'), function($query, $input) {
                $query->where('pr.nama_proyek', 'like', $input . '%');
            });
        }

        $PengajuanDana = $PengajuanDana
            ->select(
                'pr.id_proyek',
                'pd.id_pengajuan_dana',
                'pr.nama_proyek',
                'ka.keperluan',
                'pd.tanggal_pengajuan',
                DB::raw('SUM(d_pd.jumlah_pengajuan) as jumlah_pengajuan_dana'),
                DB::raw("SUM(
                    CASE
                        WHEN d_pd.status_persetujuan = '400'
                        THEN d_pd.jumlah_pengajuan
                    END) as jumlah_disetujui"
                ),
                'pd.status_pengajuan',
            )
        ->where('pd.tanggal_pengajuan', '!=', NULL)
        ->groupBy('pd.id_pengajuan_dana')
        ->orderBy('pd.id_pengajuan_dana', 'asc')->paginate(10);
        
        return Inertia::render('Laporan/PengajuanDana', [
            'pengajuan_dana' => $PengajuanDana
        ]);
    }

    public function pencairan_dana(Request $request): Response
    {
        $PencairanDana = DB::table('pengajuan_dana as pd')
            ->leftJoin('keuangan as ka', 'ka.id_keuangan', '=', 'pd.id_keuangan')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'ka.id_proyek')
            ->leftJoin('pencairan_dana as pc', 'pc.id_keuangan', '=', 'ka.id_keuangan')
            ->leftJoin('detail_pengajuan_dana as d_pd', 'd_pd.id_pengajuan_dana', '=', 'pd.id_pengajuan_dana')
            ->rightJoin('detail_pencairan_dana as d_pc', 'd_pc.id_detail_pengajuan_dana', '=', 'd_pd.id_detail_pengajuan_dana');

        if ($request->isMethod('get') && $request->all()) {
            $PencairanDana->when($request->get('nama_proyek'), function($query, $input) {
                $query->where('pr.nama_proyek', 'like', $input . '%');
            });
        }

        $PencairanDana = $PencairanDana
            ->select(
                'pr.id_proyek',
                'pd.id_pengajuan_dana',
                'pc.id_pencairan_dana',
                'pr.nama_proyek',
                'ka.keperluan',
                'pd.tanggal_pengajuan',

                DB::raw("(SELECT SUM(d_pd.jumlah_pengajuan)
                    FROM detail_pengajuan_dana as d_pd
                    WHERE d_pd.status_persetujuan = '400'
                    AND d_pd.id_pengajuan_dana = pd.id_pengajuan_dana) as jumlah_pengajuan_dana"),

                DB::raw("(SELECT SUM(d_pc.jumlah_pencairan)
                    FROM detail_pencairan_dana as d_pc
                    WHERE d_pc.id_pencairan_dana = pc.id_pencairan_dana) as jumlah_sudah_dibayarkan"),

                DB::raw("(SELECT SUM(d_pd.jumlah_pengajuan)
                    FROM detail_pengajuan_dana as d_pd
                    WHERE d_pd.status_persetujuan = '400'
                    AND d_pd.id_pengajuan_dana = pd.id_pengajuan_dana) - (SELECT SUM(d_pc.jumlah_pencairan)
                        FROM detail_pencairan_dana as d_pc
                        WHERE d_pc.id_pencairan_dana = pc.id_pencairan_dana) as jumlah_belum_dibayarkan"),

                'pc.status_pencairan',
            )
            ->groupBy(
                'pr.id_proyek',
                'pd.id_pengajuan_dana',
                'pc.id_pencairan_dana',
                'pr.nama_proyek',
                'ka.keperluan',
                'pd.tanggal_pengajuan',
                'pc.status_pencairan'
            )
            ->orderBy('pd.id_pengajuan_dana', 'asc')->paginate(10);
        
        return Inertia::render('Laporan/PencairanDana', [
            'pencairan_dana' => $PencairanDana
        ]);
    }

    public function penagihan(Request $request): Response
    {
        $penagihan = DB::table('penagihan as png')
            ->leftJoin('keuangan as ka', 'ka.id_keuangan', '=', 'png.id_keuangan')
            ->leftJoin('proyek as pr', 'pr.id_proyek', '=', 'ka.id_proyek')
            ->leftJoin('detail_penagihan as d_png', 'd_png.id_penagihan', '=', 'png.id_penagihan')
            ->leftJoin('detail_rab as d_rab', 'd_rab.id_detail_rab', '=', 'd_png.id_detail_rab');

        if ($request->isMethod('get') && $request->all()) {
            $penagihan->when($request->get('nama_proyek'), function($query, $input) {
                $query->where('pr.nama_proyek', 'like', $input . '%');
            });
        }

        $penagihan = $penagihan
            ->select(
                'pr.id_proyek',
                'png.id_penagihan',
                'pr.nama_proyek',
                'ka.keperluan',
                'png.tanggal_pengajuan',
                DB::raw('SUM(d_png.volume_penagihan * d_rab.harga_satuan) as jumlah_pengajuan'),
                DB::raw("SUM(
                    CASE
                        WHEN d_png.status_diterima = '400'
                        THEN d_png.volume_penagihan * d_rab.harga_satuan
                    END) as jumlah_diterima"
                ),
                DB::raw("SUM(
                    CASE
                        WHEN d_png.status_diterima = '100'
                        THEN d_png.volume_penagihan * d_rab.harga_satuan
                    END) as jumlah_belum_ditagihkan"
                ),
                'png.status_penagihan',
            )
        ->where('png.tanggal_pengajuan', '!=', NULL)
        ->groupBy('png.id_penagihan')
        ->orderBy('png.id_penagihan', 'asc')->paginate(10);
        
        return Inertia::render('Laporan/Penagihan', [
            'penagihan' => $penagihan
        ]);
    }
}
