<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class KepalaDivisiController extends Controller
{
    public function index(Request $request): Response
    {
        $dashboard = new DashboardController();

        $proyek = $dashboard->getProyekV2();
        $piutang = $dashboard->getProyeksiPiutang($request);

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
}