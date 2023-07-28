<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanDana\StoreRequest;
use App\Http\Requests\PengajuanDana\UpdateRequest;
use App\Models\PengajuanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PengajuanDanaController extends Controller
{
    public function index(Request $request): Response
    {
        $pengajuanDanaQuery = DB::table('pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pengajuan_dana.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $pengajuanDanaQuery = $this->filter($request, $pengajuanDanaQuery);
        }

        $pengajuanDana = $pengajuanDanaQuery->group_by('pengajuan_dana.id_pengajuan_dana')
            ->select(
                'pengajuan_dana.id_pengajuan_dana',
                'pengajuan_dana.keperluan', 'pengajuan_dana.status_pengajuan',
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
            ->orderBy('keuangan.id_keuangan', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PengajuanDanaPage', [
            'pengajuanDana' => $pengajuanDana,
            'formOptions' => $formOptions
        ]);
    }

    private function formOptions(): stdClass
    {
        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('rap', 'rap.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->where('rap.status_rap', '400')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $statusPengajuanDana = ['Open', 'Closed'];

        $options = (object) [
            'proyek' => $proyek,
            'statusPengajuanDana' => $statusPengajuanDana
        ];

        return $options;
    }

    public function filter($searchRequest, $pengajuanDanaQuery) {
        $pengajuanDanaQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $pengajuanDanaQuery->when($searchRequest->get('status_pengajuan'), function($query, $input) {
            $query->where('pengajuan_dana.status_pengajuan', $input);
        });

        $pengajuanDanaQuery->when($searchRequest->get('ditolak'), function($query) {
            $query->where('pengajuan_dana.status_aktivitas', 'Ditolak');
        });

        return $pengajuanDanaQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        DB::transaction(function() use ($request) {
            $validated = $request->safe();
    
            $pengajuanDana = new PengajuanDana;
            $pengajuanDana->fill([
                'id_proyek' => $validated->id_proyek,
                'keperluan' => $validated->keperluan,
            ]);
            $pengajuanDana->save();
        });

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, PengajuanDana $pengajuanDana): RedirectResponse
    {
        $validated = $request->safe();

        $pengajuanDana->keperluan = $validated->keperluan;

        $pengajuanDana->save();

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil diperbarui!');
    }

    public function destroy(PengajuanDana $pengajuanDana): RedirectResponse
    {
        $pengajuanDana->delete();

        return redirect()->back()->with('success', 'Pengajuan Dana berhasil dihapus!');
    }
}
