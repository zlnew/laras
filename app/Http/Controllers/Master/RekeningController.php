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

class RekeningController extends Controller
{
    public function index(Request $request): Response
    {
        $rekeningQuery = DB::table('rekening')
            ->select(
                'id_rekening',
                'nama',
                'jabatan',
                'nama_bank',
                'nomor_rekening',
                'nama_rekening'
            )
            ->where('deleted_at', NULL)
            ->latest('id_rekening');

        if ($request->method() === 'GET' && $request->all()) {
            $rekeningQuery = $this->applyFilters($request, $rekeningQuery);
        }

        $rekening = $rekeningQuery->paginate(10);

        $banks = DB::table('rekening')
            ->select('nama_bank')
            ->groupBy('nama_bank')
            ->get();

        return Inertia::render('Master/Rekening/Index', [
            'rekening' => $rekening,
            'banks' => $banks,
        ]);
    }

    public function applyFilters(Request $request, $rekeningQuery): Builder
    {
        $rekeningQuery->when($request->get('nama_bank'), function ($query, $nama_bank) {
            $query->where('nama_bank', $nama_bank);
        });

        $rekeningQuery->when($request->get('nomor_rekening'), function ($query, $nomor_rekening) {
            $query->where('nomor_rekening', $nomor_rekening);
        });

        $rekeningQuery->when($request->get('nama_rekening'), function ($query, $nama_rekening) {
            $query->where('nama_rekening', 'like', $nama_rekening . '%');
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
            'nama_rekening' => $validated->nama_rekening
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
            'nama_rekening' => $validated->nama_rekening
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
