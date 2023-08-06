<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function admin(Request $request): Response
    {
        $proyekQuery = DB::table('proyek AS p')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'p.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'p.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'rab.deleted_at' => null,
                'rap.deleted_at' => null,
                'p.status_proyek' => '100'
            ]);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery->when($request->get('tahun_anggaran'), function($query, $input) {
                $query->where('p.tahun_anggaran', $input);
            });
        }
        
        $proyek = $proyekQuery
            ->groupBy('p.id_proyek', 'rab.tax', 'rab.additional_tax')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                'p.penyedia_jasa', 'p.tahun_anggaran',
                DB::raw(
                    "(SELECT (SUM(harga_satuan * volume) + (rab.tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) AS nilai_kontrak"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
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
                        )
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
                        )
                    ) AS total_pengajuan"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND pd.deleted_at IS NULL
                    ) AS sisa_anggaran"
                ),
                DB::raw(
                    "(SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) AS estimasi_laba"
                ),
                DB::raw(
                    "(((SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    )) * 100) / (SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
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

        return Inertia::render('Dashboard/AdminPage', [
            'proyek' => $proyek,
            'overview' => $overview
        ]);
    }

    public function manajer_proyek(Request $request): Response
    {
        $proyek = DB::table('proyek AS p')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'p.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'p.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'p.id_user')
            ->where([
                'p.deleted_at' => null,
                'rab.deleted_at' => null,
                'rap.deleted_at' => null,
                'p.status_proyek' => '100',
                'p.id_user' => $request->user()->id
            ])
            ->groupBy('p.id_proyek', 'rab.tax', 'rab.additional_tax')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw(
                    "(SELECT (SUM(harga_satuan * volume) + (rab.tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) AS nilai_kontrak"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
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
                        )
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
                        )
                    ) AS total_pengajuan"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(dpd.jumlah_pengajuan)
                        FROM detail_pengajuan_dana AS dpd
                        LEFT JOIN pengajuan_dana AS pd
                        ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                        WHERE pd.id_proyek = p.id_proyek
                        AND pd.deleted_at IS NULL
                    ) AS sisa_anggaran"
                ),
                DB::raw(
                    "(SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) AS estimasi_laba"
                ),
                DB::raw(
                    "(((SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) - (SELECT SUM(harga_satuan * volume)
                        FROM detail_rap
                        WHERE rap.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    )) * 100) / (SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
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

    public function kepala_divisi(): Response
    {
        $proyek = DB::table('proyek AS p')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'p.id_proyek')
            ->leftJoin('penagihan AS pg', 'pg.id_proyek', '=', 'p.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'rab.deleted_at' => null,
                'pg.deleted_at' => null,
                'p.status_proyek' => '100'
            ])
            ->groupBy('p.id_proyek', 'rab.tax', 'rab.additional_tax')
            ->select(
                'p.id_proyek', 'p.nama_proyek',
                DB::raw(
                    "(SELECT (SUM(harga_satuan * volume) + (rab.tax / 100) * SUM(harga_satuan * volume))
                        FROM detail_rab
                        WHERE rab.id_proyek = p.id_proyek
                        AND deleted_at IS NULL
                    ) AS nilai_kontrak"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan_penagihan * volume_penagihan)
                        FROM detail_penagihan
                        WHERE id_penagihan = pg.id_penagihan
                        AND (
                            deleted_at IS NULL
                            AND pg.status_penagihan = '400'
                        )
                    ) AS termin_sebelumnya"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan_penagihan * volume_penagihan)
                        FROM detail_penagihan
                        WHERE id_penagihan = pg.id_penagihan
                        AND (
                            deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    ) AS termin_dalam_proses"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan_penagihan * volume_penagihan)
                    - pg.potongan_ppn - pg.potongan_pph - pg.potongan_lainnya
                        FROM detail_penagihan
                        WHERE id_penagihan = pg.id_penagihan
                        AND deleted_at IS NULL
                    ) AS total_pencairan"
                ),
                DB::raw(
                    "(SELECT SUM(harga_satuan_penagihan * volume_penagihan) - pg.jumlah_diterima
                        FROM detail_penagihan
                        WHERE id_penagihan = pg.id_penagihan
                        AND (
                            deleted_at IS NULL
                            AND pg.status_penagihan = '100'
                        )
                    ) AS sisa_penagihan"
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

        return Inertia::render('Dashboard/KepalaDivisiPage', [
            'proyek' => $proyek,
            'overview' => $overview
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
            ->leftJoin('rab', 'rab.id_proyek', '=', 'p.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'p.id_proyek')
            ->where([
                'p.deleted_at' => null,
                'rab.deleted_at' => null,
                'rap.deleted_at' => null,
                'p.status_proyek' => '100'
            ]);

            if ($request->isMethod('get') && $request->all()) {
                $proyekQuery->when($request->get('tahun_anggaran'), function($query, $input) {
                    $query->where('p.tahun_anggaran', $input);
                });
            }
            
            $proyek = $proyekQuery
                ->groupBy('p.id_proyek', 'rab.tax', 'rab.additional_tax')
                ->select(
                    'p.id_proyek', 'p.nama_proyek',
                    'p.penyedia_jasa', 'p.tahun_anggaran',
                    DB::raw(
                        "(SELECT (SUM(harga_satuan * volume) + (rab.tax / 100) * SUM(harga_satuan * volume))
                            FROM detail_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        ) AS nilai_kontrak"
                    ),
                    DB::raw(
                        "(SELECT SUM(harga_satuan * volume)
                            FROM detail_rap
                            WHERE rap.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
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
                            )
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
                            )
                        ) AS total_pengajuan"
                    ),
                    DB::raw(
                        "(SELECT SUM(harga_satuan * volume)
                            FROM detail_rap
                            WHERE rap.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        ) - (SELECT SUM(dpd.jumlah_pengajuan)
                            FROM detail_pengajuan_dana AS dpd
                            LEFT JOIN pengajuan_dana AS pd
                            ON pd.id_pengajuan_dana = dpd.id_pengajuan_dana
                            WHERE pd.id_proyek = p.id_proyek
                            AND pd.deleted_at IS NULL
                        ) AS sisa_anggaran"
                    ),
                    DB::raw(
                        "(SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                            FROM detail_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        ) - (SELECT SUM(harga_satuan * volume)
                            FROM detail_rap
                            WHERE rap.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        ) AS estimasi_laba"
                    ),
                    DB::raw(
                        "(((SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                            FROM detail_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        ) - (SELECT SUM(harga_satuan * volume)
                            FROM detail_rap
                            WHERE rap.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
                        )) * 100) / (SELECT (SUM(harga_satuan * volume) - (rab.additional_tax / 100) * SUM(harga_satuan * volume))
                            FROM detail_rab
                            WHERE rab.id_proyek = p.id_proyek
                            AND deleted_at IS NULL
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

        return Inertia::render('Dashboard/DirekturUtamaPage', [
            'proyek' => $proyek,
            'overview' => $overview
        ]);
    }
}
