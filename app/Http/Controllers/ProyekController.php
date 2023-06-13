<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyek\StoreRequest;
use App\Http\Requests\Proyek\UpdateRequest;
use App\Models\Proyek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProyekController extends Controller
{
    public function index(Request $request): Response
    {
        $daftarProyek = Proyek::query();
        $daftarProyek = $daftarProyek->latest('id_proyek')->get();

        return Inertia::render('Proyek/Index', [
            'daftarProyek' => $daftarProyek,
        ]);
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
