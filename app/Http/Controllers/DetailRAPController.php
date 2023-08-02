<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRAP\ImportRequest;
use App\Http\Requests\DetailRAP\StoreRequest;
use App\Http\Requests\DetailRAP\UpdateRequest;
use App\Imports\RAPItemImport;
use App\Models\DetailRAP;
use App\Models\RAP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class DetailRAPController extends Controller
{
    public function index(RAP $rap): Response
    {
        $rap = DB::table('rap')
            ->leftJoin('proyek', 'proyek.id_proyek', '=', 'rap.id_proyek')
            ->leftJoin('users', 'users.id', '=', 'proyek.id_user')
            ->leftJoin('rekening', 'rekening.id_rekening', '=', 'proyek.id_rekening')
            ->where('rap.deleted_at', null)
            ->where('rap.id_rap', $rap->id_rap)
            ->select(
                'rap.id_rap',
                'rap.status_rap', 'rap.status_aktivitas',
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

        $detailRap = DB::table('detail_rap')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'detail_rap.id_satuan')
            ->where('detail_rap.deleted_at', null)
            ->where('detail_rap.id_rap', $rap->id_rap)
            ->select(
                'detail_rap.id_detail_rap', 'detail_rap.uraian',
                'detail_rap.volume', 'detail_rap.harga_satuan',
                'detail_rap.status_uraian', 'detail_rap.keterangan',
                'detail_rap.id_rap', 'detail_rap.id_satuan',
                'satuan.nama_satuan'
            )
            ->orderBy('detail_rap.id_detail_rap', 'asc')
            ->get();

        $rab = DB::table('rab')
            ->where('deleted_at', null)
            ->where('id_proyek', $rap->id_proyek)
            ->select('id_rab', 'tax', 'additional_tax')
            ->first();

        $detailRab = DB::table('detail_rab')
            ->where('deleted_at', null)
            ->where('id_rab', $rab->id_rab)
            ->select('volume', 'harga_satuan',)
            ->get();

        $timeline = DB::table('timeline')
            ->leftJoin('users', 'users.id', '=', 'timeline.user_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('timeline.deleted_at', null)
            ->where('timeline.model_id', $rap->id_rap)
            ->select(
                'timeline.created_at', 'timeline.catatan',
                'timeline.status_aktivitas', 'users.name as user_name',
                'roles.name as user_role'
            )
            ->orderBy('timeline.created_at', 'asc')
            ->get();

        $formOptions = $this->formOptions();

        return Inertia::render('Main/DetailRAPPage', [
            'rap' => $rap,
            'detailRap' => $detailRap,
            'rab' => $rab,
            'detailRab' => $detailRab,
            'timeline' => $timeline,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
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

    public function store(StoreRequest $request, RAP $rap): RedirectResponse
    {
        $validated = $request->safe();

        $detailRap = new DetailRAP;

        $detailRap->fill([
            'id_rap' => $rap->id_rap,
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'status_uraian' => $validated->status_uraian,
            'keterangan' => $validated->keterangan
        ]);

        $detailRap->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dibuat!');
    }

    public function update(UpdateRequest $request, DetailRAP $detailRap): RedirectResponse
    {
        $validated = $request->safe();

        $detailRap->fill([
            'id_satuan' => $validated->id_satuan,
            'uraian' => $validated->uraian,
            'volume' => $validated->volume,
            'harga_satuan' => $validated->harga_satuan,
            'status_uraian' => $validated->status_uraian,
            'keterangan' => $validated->keterangan
        ]);

        $detailRap->save();

        return redirect()->back()->with('success', 'Uraian RAP berhasil diperbarui!');
    }

    public function destroy(DetailRAP $detailRap): RedirectResponse
    {
        $detailRap->delete();

        return redirect()->back()->with('success', 'Uraian RAP berhasil dihapus!');
    }

    public function import(ImportRequest $request, RAP $rap): RedirectResponse
    {
        $validated = $request->safe();

        Excel::import(new RAPItemImport($rap->id_rap), $validated->file);

        return redirect()->back()->with('success', 'Uraian RAP berhasil diimport!');
    }
}
