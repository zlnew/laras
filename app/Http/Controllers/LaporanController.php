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
                DB::raw('SUM(
                    CASE
                        WHEN d_pd.deleted_at IS NULL
                        THEN d_pd.jumlah_pengajuan
                    END) as jumlah_disetujui'
                ),
                'pd.status_pengajuan',
            )
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

                DB::raw('(SELECT SUM(d_pd.jumlah_pengajuan)
                    FROM detail_pengajuan_dana as d_pd
                    WHERE d_pd.id_pengajuan_dana = pd.id_pengajuan_dana) as jumlah_pengajuan_dana'),

                DB::raw('(SELECT SUM(d_pc.jumlah_pencairan)
                    FROM detail_pencairan_dana as d_pc
                    WHERE d_pc.id_pencairan_dana = pc.id_pencairan_dana) as jumlah_sudah_dibayarkan'),

                DB::raw('(SELECT SUM(d_pd.jumlah_pengajuan)
                    FROM detail_pengajuan_dana as d_pd
                    WHERE d_pd.id_pengajuan_dana = pd.id_pengajuan_dana) - (SELECT SUM(d_pc.jumlah_pencairan)
                        FROM detail_pencairan_dana as d_pc
                        WHERE d_pc.id_pencairan_dana = pc.id_pencairan_dana) as jumlah_belum_dibayarkan'),

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
}
