<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Satuan\StoreRequest;
use App\Http\Requests\Satuan\UpdateRequest;
use App\Models\Satuan;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SatuanController extends Controller
{
    public function index(Request $request): Response
    {
        $satuanQuery = DB::table('satuan')
            ->select('id_satuan', 'nama_satuan')
            ->where('deleted_at', NULL)
            ->latest('id_satuan');

        if ($request->method() === 'GET' && $request->all()) {
            $satuanQuery = $this->applyFilters($request, $satuanQuery);
        }

        $satuan = $satuanQuery->paginate(10);

        return Inertia::render('Master/Satuan/Index', [
            'satuan' => $satuan,
        ]);
    }

    public function applyFilters(Request $request, $satuanQuery): Builder
    {
        $satuanQuery->when($request->get('nama_satuan'), function ($query, $nama_satuan) {
            $query->where('nama_satuan', 'like', $nama_satuan . '%');
        });

        return $satuanQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $satuan = new Satuan();

        $satuan->nama_satuan = $validated->nama_satuan;

        $satuan->save();

        return redirect()->back()->with('success', 'Satuan berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Satuan $satuan): RedirectResponse
    {
        $validated = $request->safe();

        $satuan->nama_satuan = $validated->nama_satuan;

        $satuan->save();

        return redirect()->back()->with('success', 'Satuan berhasil diperbarui!');
    }

    public function destroy(Satuan $satuan): RedirectResponse
    {
        $satuan->delete();

        return redirect()->back()->with('success', 'Satuan berhasil dihapus!');
    }
}
