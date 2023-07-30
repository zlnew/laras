<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAB\StoreRequest;
use App\Http\Requests\DetailRAB\UpdateRequest;
use App\Http\Requests\DetailRAB\ImportRequest;
use App\Imports\RABItemImport;
use App\Models\DetailRAB;
use App\Models\RAB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class DetailRABController extends Controller
{
    public function index(RAB $rab): Response
    {
        $rab = DB::table('rab')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rab.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('rab.deleted_at', null)
            ->where('rab.id_rab', $rab->id_rab)
            ->select(
                'rab.id_rab',
                'rab.tax', 'rab.additional_tax',
                'rab.status_rab', 'rab.status_aktivitas',
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.nomor_kontrak', 'proyek.tanggal_kontrak',
                'proyek.pengguna_jasa', 'proyek.penyedia_jasa',
                'proyek.tahun_anggaran', 'proyek.nomor_spmk',
                'proyek.tanggal_spmk', 'proyek.nilai_kontrak',
                'proyek.tanggal_mulai', 'proyek.durasi',
                'proyek.tanggal_selesai', 'users.id as id_user',
                'users.name as pic', 'proyek.status_proyek',
                'rekening.id_rekening', 'rekening.nama_bank',
                'rekening.nomor_rekening', 'rekening.nama_rekening'
            )
            ->first();

        $detailRab = DB::table('detail_rab')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rab.id_satuan')
            ->where('detail_rab.deleted_at', null)
            ->where('detail_rab.id_rab', $rab->id_rab)
            ->select(
                'detail_rab.id_detail_rab', 'detail_rab.uraian',
                'detail_rab.volume', 'detail_rab.harga_satuan',
                'detail_rab.keterangan', 'detail_rab.id_rab',
                'detail_rab.id_satuan', 'satuan.nama_satuan'
            )
            ->orderBy('detail_rab.id_detail_rab', 'asc')
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $rab->id_rab)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->orderBy('timeline.created_at', 'asc')
            ->get();

        $formOptions = $this->formOptions();
        
        return Inertia::render('Main/DetailRABPage', [
            'rab' => $rab,
            'detailRab' => $detailRab,
            'timeline' => $timeline,
            'formOptions' => $formOptions
        ]);
    }

    private function formOptions(): stdClass
    {
        $satuan = DB::table('satuan')
            ->where('deleted_at', null)
            ->select('id_satuan', 'nama_satuan')
            ->get();

        $options = (object) [
            'satuan' => $satuan,
        ];

        return $options;
    }

    public function store(StoreRequest $request, RAB $rab): RedirectResponse
    {
        $validated = $request->safe();

        $detailRab = new DetailRAB;

        $detailRab->fill([
            'id_rab' => $rab->id_rab,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $detailRab->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAB $detailRab): RedirectResponse
    {
        $validated = $request->safe();

        $detailRab->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'keterangan' => $validated->keterangan,
        ]);

        $detailRab->save();

        return redirect()->back()->with('success', 'Uraian RAB berhasil diperbarui!');
    }

    public function destroy(DetailRAB $detailRab): RedirectResponse
    {
        $detailRab->delete();

        return redirect()->back()->with('success', 'Uraian RAB berhasil dihapus!');
    }

    public function import(ImportRequest $request, RAB $rab): RedirectResponse
    {
        $validated = $request->safe();

        Excel::import(new RABItemImport($rab->id_rab), $validated->file);

        return redirect()->back()->with('success', 'Uraian RAB berhasil diimport!');
    }
}