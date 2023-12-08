<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class KeuanganController extends Controller
{
    public function index(Request $request): Response
    {
        $dashboard = new DashboardController();

        $sisaDanaRekening = $dashboard->getSisaDanaRekening();
        $proyeksiInvoiceProyek = $dashboard->getproyeksiInvoiceProyek();
        $proyeksiKebutuhanDanaProyek = $dashboard->getproyeksiKebutuhanDanaProyek();
        $proyeksiUtang = $dashboard->getProyeksiUtang($request);
        $proyeksiPiutang = $dashboard->getProyeksiPiutang($request);
        $proyeksiSetoranModal = $dashboard->getProyeksiSetoranModal($request);
        $proyeksiPenarikan = $dashboard->getProyeksiPenarikan($request);

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
            'proyeksiSetoranModal' => $proyeksiSetoranModal,
            'proyeksiPenarikan' => $proyeksiPenarikan,
            'options' => $options,
            'overview' => $overview
        ]);
    }
}