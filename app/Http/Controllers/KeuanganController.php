<?php

namespace App\Http\Controllers;

use App\Http\Requests\Keuangan\StoreRequest;
use App\Http\Requests\Keuangan\UpdateRequest;
use App\Models\PengajuanDana;
use App\Models\Proyek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class KeuanganController extends Controller
{
    public function search(Request $request): Response
    {
        $pengajuanDana = DB::table('pengajuan_dana');
        $proyek = Proyek::select('rap.id_rap', 'proyek.nama_proyek', 'proyek.tahun_anggaran')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('rap.status_rap', '400')
            ->latest('proyek.id_proyek')->get();

        $pengajuanDana = $pengajuanDana
            ->from('pengajuan_dana as pd')
            ->leftJoin('detail_pengajuan_dana as d_pd', 'd_pd.id_pengajuan_dana', '=', 'pd.id_pengajuan_dana')
            ->leftJoin('rap', 'rap.id_rap', '=', 'pd.id_rap')
            ->leftJoin('proyek as pry', 'pry.id_proyek', '=', 'rap.id_proyek');

        if ($request->isMethod('get') && $request->all()) {
            $pengajuanDana = $this->filter($request, $pengajuanDana);
        }

        $pengajuanDana = $pengajuanDana
            ->select(
                'pd.id_pengajuan_dana',
                'pd.id_rap',
                'pry.nama_proyek',
                'pd.keterangan',
                'pd.status_pengajuan',
                'pd.created_at',
            )
            ->where('pd.deleted_at', NULL)
            ->latest('id_pengajuan_dana')->paginate(10);

        return Inertia::render('Keuangan/Search', [
            'pengajuan_dana' => $pengajuanDana,
            'proyek' => $proyek
        ]);
    }

    public function filter($searchRequest, $pengajuanDana) {
        $pengajuanDana->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('pry.nama_proyek', 'like', $input . '%');
        });

        return $pengajuanDana;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $pengajuanDana = new PengajuanDana;

        $pengajuanDana->fill([
            'id_rap' => $validated->id_rap,
            'keterangan' => $validated->keterangan,
        ]);

        $pengajuanDana->save();

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil dibuat!');
    }

    public function update(UpdateRequest $request, PengajuanDana $PengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $PengajuanDana->fill([
            'id_rap' => $validated->id_rap,
            'keterangan' => $validated->keterangan,
        ]);

        $PengajuanDana->save();

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil diperbarui!');
    }

    public function destroy(PengajuanDana $PengajuanDana): RedirectResponse
    {
        $PengajuanDana->delete();

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil dihapus!');
    }
}
