<?php

namespace App\Http\Controllers;

use App\Http\Requests\RAP\StoreRequest;
use App\Http\Requests\RAP\UpdateRequest;
use App\Models\DetailRAP;
use App\Models\Proyek;
use App\Models\RAP;
use App\Models\Satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RAPController extends Controller
{
    public function search(Request $request): Response
    {
        $daftarProyek = Proyek::query();

        if ($request->isMethod('get') && $request->all()) {
            $daftarProyek = $this->filter($request, $daftarProyek);
        }

        $daftarProyek = $daftarProyek
            ->with('rap:id_proyek,id_rap')
            ->select('id_proyek', 'nama_proyek', 'tahun_anggaran', 'pengguna_jasa', 'status_proyek')
            ->latest('id_proyek')->take(5)->get();

        return Inertia::render('RAP/Search', [
            'daftarProyek' => $daftarProyek,
        ]);
    }

    public function filter($searchRequest, $daftarProyek) {
        $daftarProyek->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('nama_proyek', 'like', $input . '%');
        });

        return $daftarProyek;
    }

    public function detail(RAP $RAP): Response {
        $RAP = RAP::with('proyek:id_proyek,nama_proyek')
            ->select('id_proyek', 'id_rap')
            ->where('id_rap', $RAP->id_rap)
            ->first();

        $detailRAP = DetailRAP::with('satuan:id_satuan,nama_satuan')
            ->where('id_rap', $RAP->id_rap)
            ->orderBy('id_detail_rap', 'asc')->get();

        $satuan = Satuan::select('id_satuan', 'nama_satuan')->get();

        return Inertia::render('RAP/Detail', [
            'rap' => $RAP,
            'detail_rap' => $detailRAP,
            'satuan' => $satuan
        ]);
    }

    public function store(StoreRequest $request, RAP $RAP): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAP = new DetailRAP;

        $DetailRAP->fill([
            'id_rap' => $RAP->id_rap,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $DetailRAP->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAP $DetailRAP): RedirectResponse
    {
        $validated = $request->safe();

        $DetailRAP->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
            'status_uraian' => $validated->status_uraian,
        ]);

        $DetailRAP->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil diperbarui!');
    }

    public function destroy(DetailRAP $DetailRAP): RedirectResponse
    {
        $DetailRAP->delete();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dihapus!');
    }
}
