<?php

namespace App\Http\Controllers;

use App\Http\Requests\Keuangan\StoreRequest;
use App\Http\Requests\Keuangan\UpdateRequest;
use App\Models\Keuangan;
use App\Models\Penagihan;
use App\Models\PengajuanDana;
use App\Models\Proyek;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class KeuanganController extends Controller
{
    public function index(Request $request): Response
    {
        $Keuangan = DB::table('keuangan');

        $KeuanganQuery = $Keuangan
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'keuangan.id_proyek')
            ->leftJoin('pengajuan_dana as pgd', 'pgd.id_keuangan', '=', 'keuangan.id_keuangan')
            ->leftJoin('pencairan_dana as pcd', 'pcd.id_keuangan', '=', 'keuangan.id_keuangan')
            ->leftJoin('penagihan as png', 'png.id_keuangan', '=', 'keuangan.id_keuangan');

        if ($request->isMethod('get') && $request->all()) {
            $KeuanganQuery = $this->filter($request, $KeuanganQuery);
        }

        $Keuangan = $KeuanganQuery->select(
            'keuangan.id_keuangan',
            'keuangan.keperluan',
            'proyek.id_proyek',
            'proyek.nama_proyek',
            'proyek.tahun_anggaran',
            'proyek.pengguna_jasa',
            'pgd.id_pengajuan_dana',
            'pcd.id_pencairan_dana',
            'png.id_penagihan'
        )
        ->where('keuangan.deleted_at', NULL)
        ->groupBy(
            'keuangan.id_keuangan',
            'proyek.id_proyek',
            'pgd.id_pengajuan_dana',
            'pcd.id_pencairan_dana',
            'png.id_penagihan'
        )
        ->latest('keuangan.id_keuangan')->paginate(10);

        $Proyek = Proyek::query()
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->select(
                'proyek.id_proyek',
                'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
        ->where('rab.status_rab', '400')
        ->where('rap.status_rap', '400')
        ->get();
            
        return Inertia::render('Keuangan/Index', [
            'keuangan' => $Keuangan,
            'proyek' => $Proyek
        ]);
    }

    public function filter($searchRequest, $KeuanganQuery) {
        $KeuanganQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', $input . '%');
        });

        return $KeuanganQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $validated = $request->safe();
    
            $Keuangan = new Keuangan;
            $Keuangan->fill([
                'id_proyek' => $validated->id_proyek,
                'keperluan' => $validated->keperluan,
            ]);
            $Keuangan->save();

            if ($request->post('for') === 'pengajuan dana') {
                $PengajuanDana = new PengajuanDana;
                $PengajuanDana->id_keuangan = $Keuangan->id_keuangan;
                $PengajuanDana->save();
            }

            if ($request->post('for') === 'penagihan') {
                $Penagihan = new Penagihan;
                $Penagihan->id_keuangan = $Keuangan->id_keuangan;
                $Penagihan->save();
            }
        });

        return redirect()->back()->with('success', 'Keuangan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Keuangan $Keuangan): RedirectResponse
    {
        $validated = $request->safe();

        $Keuangan->fill([
            'keperluan' => $validated->keperluan,
        ]);

        $Keuangan->save();

        return redirect()->back()->with('success', 'Keuangan berhasil diperbarui!');
    }

    public function destroy(Keuangan $Keuangan): RedirectResponse
    {
        $Keuangan->delete();

        return redirect()->back()->with('success', 'Keuangan berhasil dihapus!');
    }
}
