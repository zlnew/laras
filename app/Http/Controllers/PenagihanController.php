<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penagihan\StoreRequest;
use App\Http\Requests\Penagihan\UpdateRequest;
use App\Models\Penagihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class PenagihanController extends Controller
{
    public function index(Request $request): Response
    {
        $penagihanQuery = DB::table('penagihan')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'penagihan.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('penagihan.deleted_at', NULL);

        if ($request->isMethod('get') && $request->all()) {
            $penagihanQuery = $this->filter($request, $penagihanQuery);
        }

        $penagihan = $penagihanQuery->group_by('penagihan.id_penagihan')
            ->select(
                'penagihan.id_penagihan', 'penagihan.kas_masuk',
                'penagihan.keperluan', 'penagihan.status_pengajuan',
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
            ->orderBy('penagihan.id_penagihan', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PenagihanPage', [
            'penagihan' => $penagihan,
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

        $kasMasuk = ['Utang', 'Setoran Modal'];

        $statusPenagihan = ['Open', 'Closed'];

        $options = (object) [
            'proyek' => $proyek,
            'kasMasuk' => $kasMasuk,
            'statusPenagihan' => $statusPenagihan
        ];

        return $options;
    }

    public function filter($searchRequest, $penagihanQuery) {
        $penagihanQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $penagihanQuery->when($searchRequest->get('status_pengajuan'), function($query, $input) {
            $query->where('penagihan.status_pengajuan', $input);
        });

        $penagihanQuery->when($searchRequest->get('ditolak'), function($query) {
            $query->where('penagihan.status_aktivitas', 'Ditolak');
        });

        return $penagihanQuery;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $penagihan = new Penagihan;

        $penagihan->fill([
            'id_proyek' => $validated->id_proyek,
            'keperluan' => $validated->keperluan,
            'kas_masuk' => $validated->kas_masuk
        ]);

        $penagihan->save();

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil dibuat!');
    }

    public function update(UpdateRequest $request, Penagihan $penagihan): RedirectResponse
    {
        $validated = $request->safe();

        $penagihan->keperluan = $validated->keperluan;
        $penagihan->kas_masuk = $validated->kas_masuk;

        $penagihan->save();

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil diperbarui!');
    }

    public function destroy(Penagihan $penagihan): RedirectResponse
    {
        $penagihan->delete();

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil dihapus!');
    }
}