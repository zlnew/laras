<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rekening\StoreRequest;
use App\Http\Requests\Rekening\UpdateRequest;
use App\Models\Rekening;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class RekeningController extends Controller
{
    public function index(Request $request): Response
    {
        $rekeningQuery = DB::table('rekening')->where('deleted_at', NULL);

        if ($request->method() === 'GET' && $request->all()) {
            $rekeningQuery = $this->filter($request, $rekeningQuery);
        }

        $rekening = $rekeningQuery->select(
                'id_rekening', 'nama',
                'jabatan', 'nama_bank',
                'nomor_rekening', 'nama_rekening',
                'tujuan_rekening'
            )
            ->orderBy('id_rekening', 'desc')
            ->get();

        $formOptions = $this->formOptions();

        return Inertia::render('Master/RekeningPage', [
            'rekening' => $rekening,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
    {
        $banks = DB::table('rekening')
            ->groupBy('nama_bank')
            ->pluck('nama_bank');

        $tujuanRekening = ['Penerimaan Invoice', 'Daftar Rekening Keluar'];

        $options = (object) [
            'banks' => $banks,
            'tujuanRekening' => $tujuanRekening
        ];

        return $options;
    }

    public function filter(Request $request, $rekeningQuery): Builder
    {
        $rekeningQuery->when($request->get('nama_bank'), function ($query, $nama_bank) {
            $query->whereIn('nama_bank', $nama_bank);
        });

        $rekeningQuery->when($request->get('nomor_rekening'), function ($query, $nomor_rekening) {
            $query->where('nomor_rekening', $nomor_rekening);
        });

        $rekeningQuery->when($request->get('nama_rekening'), function ($query, $nama_rekening) {
            $query->where('nama_rekening', 'like', $nama_rekening . '%');
        });

        $rekeningQuery->when($request->get('tujuan_rekening'), function ($query, $tujuan_rekening) {
            $query->whereIn('tujuan_rekening', $tujuan_rekening);
        });

        return $rekeningQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $rekening = new Rekening;

        $rekening->fill([
            'nama' => $validated->nama,
            'jabatan' => $validated->jabatan,
            'nama_bank' => $validated->nama_bank,
            'nomor_rekening' => $validated->nomor_rekening,
            'nama_rekening' => $validated->nama_rekening,
            'tujuan_rekening' => $validated->tujuan_rekening
        ]);

        $rekening->save();

        return redirect()->back()->with('success', 'Satuan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Rekening $rekening): RedirectResponse
    {
        $validated = $request->safe();

        $rekening->fill([
            'nama' => $validated->nama,
            'jabatan' => $validated->jabatan,
            'nama_bank' => $validated->nama_bank,
            'nomor_rekening' => $validated->nomor_rekening,
            'nama_rekening' => $validated->nama_rekening,
            'tujuan_rekening' => $validated->tujuan_rekening
        ]);

        $rekening->save();

        return redirect()->back()->with('success', 'Rekening berhasil diperbarui!');
    }

    public function destroy(Rekening $rekening): RedirectResponse
    {
        $rekening->delete();

        return redirect()->back()->with('success', 'Rekening berhasil dihapus!');
    }
}
