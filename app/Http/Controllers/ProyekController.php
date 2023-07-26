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
use stdClass;

class ProyekController extends Controller
{
    public function index(Request $request): Response
    {
        $proyekQuery = DB::table('proyek')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('proyek.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery = $this->filter($request, $proyekQuery);
        }

        $proyek = $proyekQuery
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran', 'proyek.pengguna_jasa',
                'proyek.penyedia_jasa', 'proyek.durasi',
                'proyek.waktu_mulai', 'proyek.waktu_selesai',
                'proyek.nilai_kontrak', 'proyek.pic',
                'proyek.status_proyek', 'rekening.id_rekening',
                'rekening.nama_bank', 'rekening.nomor_rekening',
                'rekening.nama_rekening'
            )
            ->orderBy('proyek.id_proyek', 'desc')
            ->get();

        $rekening = DB::table('rekening')
            ->where('deleted_at', null)
            ->select(
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )->get();
        
        $filterOptions = $this->createOptions();

        return Inertia::render('Main/ProyekPage', [
            'proyek' => $proyek,
            'rekening' => $rekening,
            'filterOptions' => $filterOptions
        ]);
    }

    private function createOptions(): stdClass {
        $penggunaJasaOptions = DB::table('proyek')
            ->groupBy('pengguna_jasa')
            ->pluck('pengguna_jasa');
        
        $tahunAnggaranOptions = DB::table('proyek')
            ->groupBy('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $picOptions = DB::table('proyek')
            ->groupBy('pic')
            ->pluck('pic');
        
        $rekeningOptions = DB::table('proyek')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('proyek.id_rekening', '!=', NULL)
            ->groupBy('proyek.id_rekening')
            ->select(
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )->get();
    
        $options = new stdClass;

        $options->pengguna_jasa = $penggunaJasaOptions;
        $options->tahun_anggaran = $tahunAnggaranOptions;
        $options->pic = $picOptions;
        $options->rekening = $rekeningOptions;

        return $options;
    }

    private function filter($searchRequest, $proyekQuery) {
        $proyekQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', '%' . $input . '%');
        });

        $proyekQuery->when($searchRequest->get('tahun_anggaran'), function($query, $input) {
            $query->whereIn('proyek.tahun_anggaran', $input);
        });
        
        $proyekQuery->when($searchRequest->get('pengguna_jasa'), function($query, $input) {
            $query->whereIn('proyek.pengguna_jasa', $input);
        });

        $proyekQuery->when($searchRequest->get('waktu_mulai'), function($query, $input) {
            $query->where('proyek.waktu_mulai', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('waktu_selesai'), function($query, $input) {
            $query->where('proyek.waktu_selesai', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_min'), function($query, $input) {
            $query->where('proyek.nilai_kontrak', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_max'), function($query, $input) {
            $query->where('proyek.nilai_kontrak', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('pic'), function($query, $input) {
            $query->whereIn('proyek.pic', $input);
        });

        $proyekQuery->when($searchRequest->get('rekening'), function($query, $input) {
            $query->whereIn('proyek.id_rekening', $input);
        });

        $proyekQuery->when($searchRequest->get('status_proyek'), function($query, $input) {
            $query->where('proyek.status_proyek', $input);
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
            'id_rekening' => $validated->id_rekening,
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
            'id_rekening' => $validated->id_rekening,
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
