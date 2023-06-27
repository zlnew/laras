<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAB\StoreRequest;
use App\Http\Requests\RAB\TaxRequest;
use App\Http\Requests\RAB\UpdateRequest;
use App\Models\DetailRAB;
use App\Models\Proyek;
use App\Models\RAB;
use App\Models\Satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RABController extends Controller
{
    public function search(Request $request): Response
    {
        $daftarProyek = Proyek::query();

        if ($request->isMethod('get') && $request->all()) {
            $daftarProyek = $this->filter($request, $daftarProyek);
        }

        $daftarProyek = $daftarProyek
            ->with('rab:id_proyek,id_rab')
            ->select('id_proyek', 'nama_proyek', 'tahun_anggaran', 'pengguna_jasa', 'status_proyek')
            ->latest('id_proyek')->take(5)->get();

        return Inertia::render('RAB/Search', [
            'daftarProyek' => $daftarProyek,
        ]);
    }

    public function filter($searchRequest, $daftarProyek) {
        $daftarProyek->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('nama_proyek', 'like', $input . '%');
        });

        return $daftarProyek;
    }

    public function detail(RAB $RAB): Response {
        $RAB = RAB::with('proyek:id_proyek,nama_proyek')
            ->select('id_proyek', 'id_rab', 'tax', 'additional_tax')
            ->where('id_rab', $RAB->id_rab)
            ->first();

        $detailRAB = DetailRAB::with('satuan:id_satuan,nama_satuan')
            ->where('id_rab', $RAB->id_rab)
            ->orderBy('id_detail_rab', 'asc')->get();

        $satuan = Satuan::select('id_satuan', 'nama_satuan')->get();

        return Inertia::render('RAB/Detail', [
            'rab' => $RAB,
            'detail_rab' => $detailRAB,
            'satuan' => $satuan
        ]);
    }

    public function store(StoreRequest $request, RAB $RAB): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAB = new DetailRAB;

        $DetailRAB->fill([
            'id_rab' => $RAB->id_rab,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $DetailRAB->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAB $DetailRAB): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAB->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $DetailRAB->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil diperbarui!');
    }

    public function destroy(DetailRAB $DetailRAB): RedirectResponse
    {
        $DetailRAB->delete();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dihapus!');
    }

    public function update_tax(TaxRequest $request, RAB $RAB): RedirectResponse
    {
        $validated = $request->safe();

        $RAB->fill([
            'tax' => $validated->tax,
            'additional_tax' => $validated->additional_tax,
        ]);

        $RAB->save();

        return redirect()->back();
    }
}
