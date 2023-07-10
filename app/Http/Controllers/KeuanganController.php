<?php

namespace App\Http\Controllers;

use App\Http\Requests\Keuangan\StoreRequest;
use App\Http\Requests\Keuangan\UpdateRequest;
use App\Models\Keuangan;
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
            ->leftJoin('pengajuan_dana as pd', 'pd.id_keuangan', '=', 'keuangan.id_keuangan');

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
            'pd.id_pengajuan_dana'
        )
        ->where('keuangan.deleted_at', NULL)
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

            $PengajuanDana = new PengajuanDana;
            $PengajuanDana->id_keuangan = $Keuangan->id_keuangan;
            $PengajuanDana->save();

            $Timeline = new Timeline;
            $Timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $PengajuanDana->id_pengajuan_dana,
                'model_type' => get_class($PengajuanDana),
                'status_aktivitas' => 'Dibuat'
            ]);
            $Timeline->save();
        });

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Keuangan $Keuangan): RedirectResponse
    {
        $validated = $request->safe();

        $Keuangan->fill([
            'keperluan' => $validated->keperluan,
        ]);

        $Keuangan->save();

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil diperbarui!');
    }

    public function destroy(Keuangan $Keuangan): RedirectResponse
    {
        $Keuangan->delete();

        return redirect()->back()->with('success', 'Keuangan Proyek berhasil dihapus!');
    }
}
