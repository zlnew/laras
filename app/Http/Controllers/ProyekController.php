<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyek\StoreRequest;
use App\Http\Requests\Proyek\UpdateRequest;
use App\Models\Proyek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProyekController extends Controller
{
    public function index(Request $request): Response
    {
        $proyekQuery = DB::table('proyek')
            ->where('deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery = $this->filter($request, $proyekQuery);
        }

        $proyek = $proyekQuery
            ->select(
                'id_proyek', 'nama_proyek',
                'tahun_anggaran', 'pengguna_jasa',
                'waktu_mulai', 'waktu_selesai',
                'nilai_kontrak', 'pic',
                'status_proyek'
            )
            ->orderBy('id_proyek', 'desc')->paginate(10);

        return Inertia::render('Proyek/Index', [
            'daftar_proyek' => $proyek,
        ]);
    }

    private function filter($searchRequest, $proyekQuery) {
        $proyekQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('nama_proyek', 'like', '%' . $input . '%');
        });

        $proyekQuery->when($searchRequest->get('tahun_anggaran'), function($query, $input) {
            $query->where('tahun_anggaran', $input);
        });
        
        $proyekQuery->when($searchRequest->get('pengguna_jasa'), function($query, $input) {
            $query->where('pengguna_jasa', 'like', '%' . $input . '%');
        });

        $proyekQuery->when($searchRequest->get('waktu_mulai'), function($query, $input) {
            $query->where('waktu_mulai', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('waktu_selesai'), function($query, $input) {
            $query->where('waktu_selesai', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_min'), function($query, $input) {
            $query->where('nilai_kontrak', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_max'), function($query, $input) {
            $query->where('nilai_kontrak', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('pic'), function($query, $input) {
            $query->where('pic', $input);
        });

        $proyekQuery->when($searchRequest->get('status_proyek'), function($query, $input) {
            $query->where('status_proyek', $input);
        });

        return $proyekQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $proyek = new Proyek;

        $proyek->fill([
            'nama_proyek' => $validated->nama_proyek,
            'tahun_anggaran' => $validated->tahun_anggaran,
            'pengguna_jasa' => $validated->pengguna_jasa,
            'nilai_kontrak' => $validated->nilai_kontrak,
            'waktu_mulai' => $validated->waktu_mulai,
            'waktu_selesai' => $validated->waktu_selesai,
            'pic' => $validated->pic,
            'slug' => Str::slug($validated->nama_proyek),
        ]);

        $proyek->save();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Proyek $proyek): RedirectResponse
    {
        $validated = $request->safe();

        $proyek->fill([
            'nama_proyek' => $validated->nama_proyek,
            'tahun_anggaran' => $validated->tahun_anggaran,
            'pengguna_jasa' => $validated->pengguna_jasa,
            'nilai_kontrak' => $validated->nilai_kontrak,
            'waktu_mulai' => $validated->waktu_mulai,
            'waktu_selesai' => $validated->waktu_selesai,
            'pic' => $validated->pic,
            'slug' => Str::slug($validated->nama_proyek),
        ]);

        $proyek->save();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Proyek $proyek): RedirectResponse
    {
        $proyek->delete();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil dihapus!');
    }
}
