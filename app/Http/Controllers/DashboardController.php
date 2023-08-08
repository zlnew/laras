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
                    ) - (SELECT SUM(dpd.jumlah_pengajuan)
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
                    ) AS sisa_anggaran"
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
            'tahunAnggaran' => $proyekQuery->pluck('tahun_anggaran')
        ];

        return Inertia::render('Dashboard/AdminPage', [
            'proyek' => $proyek,
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
                    ) - (SELECT SUM(dpd.jumlah_pengajuan)
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
                    ) AS sisa_anggaran"
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

    public function keuangan(): Response
    {
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

        return Inertia::render('Dashboard/KeuanganPage', [
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
                    ) - (SELECT SUM(dpd.jumlah_pengajuan)
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
                    ) AS sisa_anggaran"
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
                ->pluck('tahun_anggaran')
        ];

        return Inertia::render('Dashboard/DirekturUtamaPage', [
            'proyek' => $proyek,
            'overview' => $overview,
            'options' => $options
        ]);
    }
}
