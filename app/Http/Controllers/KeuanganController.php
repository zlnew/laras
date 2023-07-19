<?php

namespace App\Http\Controllers;

use App\Http\Requests\Keuangan\StoreRequest;
use App\Http\Requests\Keuangan\UpdateRequest;
use App\Models\Keuangan;
use App\Models\Penagihan;
use App\Models\PengajuanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class KeuanganController extends Controller
{
    public function index(Request $request): Response
    {
        $keuanganQuery = DB::table('keuangan')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'keuangan.id_proyek')
            ->leftJoin('pengajuan_dana as pgd', 'pgd.id_keuangan', '=', 'keuangan.id_keuangan')
            ->leftJoin('pencairan_dana as pcd', 'pcd.id_keuangan', '=', 'keuangan.id_keuangan')
            ->leftJoin('penagihan as png', 'png.id_keuangan', '=', 'keuangan.id_keuangan')
            ->where('keuangan.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $keuanganQuery = $this->filter($request, $keuanganQuery);
        }

        $keuangan = $keuanganQuery->groupBy(
                'keuangan.id_keuangan', 'proyek.id_proyek',
                'pgd.id_pengajuan_dana', 'pcd.id_pencairan_dana',
                'png.id_penagihan'
            )
            ->select(
                'keuangan.id_keuangan', 'keuangan.keperluan',
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran', 'proyek.pengguna_jasa',
                'pgd.id_pengajuan_dana', 'pcd.id_pencairan_dana',
                'png.id_penagihan'
            )
            ->orderBy('keuangan.id_keuangan', 'desc')
            ->paginate(10);

        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->where('rap.status_rap', '400')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();
            
        return Inertia::render('Keuangan/Index', [
            'keuangan' => $keuangan,
            'proyek' => $proyek
        ]);
    }

    public function filter($searchRequest, $keuanganQuery) {
        $keuanganQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', $input . '%');
        });

        return $keuanganQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $validated = $request->safe();
    
            $keuangan = new Keuangan;
            $keuangan->fill([
                'id_proyek' => $validated->id_proyek,
                'keperluan' => $validated->keperluan,
            ]);
            $keuangan->save();

            if ($request->post('for') === 'pengajuan dana') {
                $pengajuanDana = new PengajuanDana;
                $pengajuanDana->id_keuangan = $keuangan->id_keuangan;
                $pengajuanDana->save();
            }

            if ($request->post('for') === 'penagihan') {
                $penagihan = new Penagihan;
                $penagihan->id_keuangan = $keuangan->id_keuangan;
                $penagihan->save();
            }
        });

        return redirect()->back()->with('success', 'Keuangan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Keuangan $keuangan): RedirectResponse
    {
        $validated = $request->safe();

        $keuangan->keperluan = $validated->keperluan;

        $keuangan->save();

        return redirect()->back()->with('success', 'Keuangan berhasil diperbarui!');
    }

    public function destroy(Keuangan $keuangan): RedirectResponse
    {
        $keuangan->delete();

        return redirect()->back()->with('success', 'Keuangan berhasil dihapus!');
    }
}
