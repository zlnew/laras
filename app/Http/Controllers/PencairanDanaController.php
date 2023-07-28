<?php

namespace App\Http\Controllers;

use App\Http\Requests\PencairanDana\StoreRequest;
use App\Http\Requests\PencairanDana\UpdateRequest;
use App\Models\PencairanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PencairanDanaController extends Controller
{
    public function index(Request $request): Response
    {
        $pencairanDana = DB::table('pencairan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengagjuan_dana.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('pencairan_dana.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $pencairanDana = $this->filter($request, $pencairanDana);
        }

        $pencairanDana = $pencairanDana->group_by('pencairan_dana.id_pencairan_dana')
            ->select(
                'pencairan_dana.id_pencairan_dana',
                'pencairan_dana.keperluan', 'pencairan_dana.status_pengajuan',
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
            
        return Inertia::render('Keuangan/PencairanDanaPage', [
            'pencairanDana' => $pencairanDana,
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

        $pengajuanDana = DB::table('pengajuan_dana')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'pengajuan_dana.id_proyek')
            ->where('pengajuan_dana.deleted_at', null)
            ->where('pengajuan_dana.status_pengajuan', '400')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran', 'pengajuan_dana.keperluan'
            )
            ->get();

        $statusPencairanDana = ['Open', 'Closed'];

        $options = (object) [
            'proyek' => $proyek,
            'pengajuanDana' => $pengajuanDana,
            'statusPencairanDana' => $statusPencairanDana
        ];

        return $options;
    }

    public function filter($searchRequest, $pencairanDana) {
        $pencairanDana->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $pencairanDana->when($searchRequest->get('status_pencairan'), function($query, $input) {
            $query->where('pencairan_dana.status_pencairan', $input);
        });

        $pencairanDana->when($searchRequest->get('ditolak'), function($query) {
            $query->where('pencairan_dana.status_aktivitas', 'Ditolak');
        });

        return $pencairanDana;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $pencairanDana = new PencairanDana;

        $pencairanDana->fill([
            'id_proyek' => $validated->id_proyek,
            'keperluan' => $validated->keperluan,
        ]);

        $pencairanDana->save();

        return redirect()->back()->with('success', 'Pencairan Dana berhasil dibuat!');
    }

    public function update(UpdateRequest $request, PencairanDana $pencairanDana): RedirectResponse
    {
        $validated = $request->safe();

        $pencairanDana->keperluan = $validated->keperluan;

        $pencairanDana->save();

        return redirect()->back()->with('success', 'Pencairan Dana berhasil diperbarui!');
    }

    public function destroy(PencairanDana $pencairanDana): RedirectResponse
    {
        $pencairanDana->delete();

        return redirect()->back()->with('success', 'Pencairan Dana berhasil dihapus!');
    }
}
