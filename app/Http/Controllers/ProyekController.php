<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyek\StoreRequest;
use App\Http\Requests\Proyek\UpdateRequest;
use App\Models\Proyek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class ProyekController extends Controller
{
    public function index(Request $request): Response
    {
        $proyekQuery = DB::table('proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('proyek.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $proyekQuery = $this->filter($request, $proyekQuery);
        }

        $proyek = $proyekQuery
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.nomor_kontrak', 'proyek.tanggal_kontrak',
                'proyek.pengguna_jasa', 'proyek.penyedia_jasa',
                'proyek.tahun_anggaran', 'proyek.nomor_spmk',
                'proyek.tanggal_spmk', 'proyek.nilai_kontrak',
                'proyek.tanggal_mulai', 'proyek.durasi',
                'proyek.tanggal_selesai', 'user.id as id_user',
                'user.name as user_name', 'proyek.status_proyek',
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )
            ->orderBy('proyek.id_proyek', 'desc')
            ->get();
        
        $formOptions = $this->formOptions();

        return Inertia::render('Main/ProyekPage', [
            'proyek' => $proyek,
            'formOptions' => $formOptions
        ]);
    }

    private function formOptions(): stdClass {
        $penggunaJasaOptions = DB::table('proyek')
            ->groupBy('pengguna_jasa')
            ->pluck('pengguna_jasa');

        $penyediaJasaOptions = DB::table('proyek')
            ->groupBy('penyedia_jasa')
            ->pluck('penyedia_jasa');
        
        $tahunAnggaranOptions = DB::table('proyek')
            ->groupBy('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $picOptions = DB::table('proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->groupBy('proyek.id_user')
            ->select('proyek.id_user', 'users.name')
            ->get();
        
        $rekeningOptions = DB::table('proyek')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('proyek.id_rekening', '!=', NULL)
            ->groupBy('proyek.id_rekening')
            ->select(
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )->get();
    
        $options = (object) [
            'pengguna_jasa' => $penggunaJasaOptions,
            'penyedia_jasa' => $penyediaJasaOptions,
            'tahun_anggaran' => $tahunAnggaranOptions,
            'pic' => $picOptions,
            'rekening' => $rekeningOptions,
        ];

        return $options;
    }

    private function filter($searchRequest, $proyekQuery) {
        $proyekQuery->when($searchRequest->get('nama_proyek'), function($query, $input) {
            $query->where('proyek.nama_proyek', 'like', '%' . $input . '%');
        });

        $proyekQuery->when($searchRequest->get('nomor_kontrak'), function($query, $input) {
            $query->where('proyek.nomor_kontrak', $input);
        });

        $proyekQuery->when($searchRequest->get('tanggal_kontrak'), function($query, $input) {
            $query->where('proyek.tanggal_kontrak', $input);
        });

        $proyekQuery->when($searchRequest->get('pengguna_jasa'), function($query, $input) {
            $query->whereIn('proyek.pengguna_jasa', $input);
        });

        $proyekQuery->when($searchRequest->get('penyedia_jasa'), function($query, $input) {
            $query->whereIn('proyek.penyedia_jasa', $input);
        });

        $proyekQuery->when($searchRequest->get('tahun_anggaran'), function($query, $input) {
            $query->whereIn('proyek.tahun_anggaran', $input);
        });

        $proyekQuery->when($searchRequest->get('nomor_spmk'), function($query, $input) {
            $query->where('proyek.nomor_spmk', $input);
        });

        $proyekQuery->when($searchRequest->get('tanggal_spmk'), function($query, $input) {
            $query->where('proyek.tanggal_spmk', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_min'), function($query, $input) {
            $query->where('proyek.nilai_kontrak', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('nilai_kontrak_max'), function($query, $input) {
            $query->where('proyek.nilai_kontrak', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('tanggal_mulai'), function($query, $input) {
            $query->where('proyek.tanggal_mulai', '>=', $input);
        });

        $proyekQuery->when($searchRequest->get('tanggal_selesai'), function($query, $input) {
            $query->where('proyek.tanggal_selesai', '<=', $input);
        });

        $proyekQuery->when($searchRequest->get('pic'), function($query, $input) {
            $query->whereIn('proyek.user_id', $input);
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
            'nomor_kontrak' => $validated->nomor_kontrak,
            'tanggal_kontrak' => $validated->tanggal_kontrak,
            'pengguna_jasa' => $validated->pengguna_jasa,
            'penyedia_jasa' => $validated->penyedia_jasa,
            'tahun_anggaran' => $validated->tahun_anggaran,
            'nomor_spmk' => $validated->nomor_spmk,
            'tanggal_spmk' => $validated->tanggal_spmk,
            'nilai_kontrak' => $validated->nilai_kontrak,
            'tanggal_mulai' => $validated->tanggal_mulai,
            'durasi' => $validated->durasi,
            'tanggal_selesai' => $validated->tanggal_selesai,
            'id_user' => $validated->id_user,
            'id_rekening' => $validated->id_rekening,
        ]);

        $proyek->save();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Proyek $proyek): RedirectResponse
    {
        $validated = $request->safe();

        $proyek->fill([
            'nama_proyek' => $validated->nama_proyek,
            'nomor_kontrak' => $validated->nomor_kontrak,
            'tanggal_kontrak' => $validated->tanggal_kontrak,
            'pengguna_jasa' => $validated->pengguna_jasa,
            'penyedia_jasa' => $validated->penyedia_jasa,
            'tahun_anggaran' => $validated->tahun_anggaran,
            'nomor_spmk' => $validated->nomor_spmk,
            'tanggal_spmk' => $validated->tanggal_spmk,
            'nilai_kontrak' => $validated->nilai_kontrak,
            'tanggal_mulai' => $validated->tanggal_mulai,
            'durasi' => $validated->durasi,
            'tanggal_selesai' => $validated->tanggal_selesai,
            'id_user' => $validated->id_user,
            'id_rekening' => $validated->id_rekening,
        ]);

        $proyek->save();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Proyek $proyek): RedirectResponse
    {
        $proyek->delete();

        return redirect()->route('proyek')->with('success', 'Proyek berhasil dihapus!');
    }

    public function close(Proyek $proyek): RedirectResponse
    {
        $proyek->status_proyek = '400';
        $proyek->save();

        return redirect()->route('proyek')->with('success', 'Status Proyek berhasil ditutup!');
    }
}
