<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penagihan\StoreRequest;
use App\Http\Requests\Penagihan\UpdateRequest;
use App\Models\DetailPenagihan;
use App\Models\Penagihan;
use App\Models\Timeline;
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

        $penagihan = $penagihanQuery->groupBy('penagihan.id_penagihan')
            ->select(
                'penagihan.id_penagihan',
                'penagihan.kas_masuk', 'penagihan.keperluan',
                'penagihan.status_penagihan', 'penagihan.status_aktivitas',
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
            ->orderBy('penagihan.id_penagihan', 'desc')
            ->get();

        $formOptions = $this->formOptions();
            
        return Inertia::render('Keuangan/PenagihanPage', [
            'penagihan' => $penagihan,
            'formOptions' => $formOptions
        ]);
    }

    public function formOptions(): stdClass
    {
        $proyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $currentProyek = DB::table('proyek')
            ->leftJoin('rab', 'rab.id_proyek', '=', 'proyek.id_proyek')
            ->leftJoin('penagihan', 'penagihan.id_proyek', '=', 'proyek.id_proyek')
            ->where('proyek.deleted_at', null)
            ->where('rab.deleted_at', null)
            ->where('penagihan.deleted_at', null)
            ->where('rab.status_rab', '400')
            ->where('penagihan.id_proyek', '!=', null)
            ->groupBy('proyek.id_proyek')
            ->select(
                'proyek.id_proyek', 'proyek.nama_proyek',
                'proyek.tahun_anggaran'
            )
            ->get();

        $options = (object) [
            'proyek' => $proyek,
            'currentProyek' => $currentProyek
        ];

        return $options;
    }

    public function filter($searchRequest, $penagihanQuery) {
        $penagihanQuery->when($searchRequest->get('id_proyek'), function($query, $input) {
            $query->whereIn('proyek.id_proyek', $input);
        });

        $penagihanQuery->when($searchRequest->get('kas_masuk'), function($query, $input) {
            $query->where('penagihan.kas_masuk', $input);
        });

        $penagihanQuery->when($searchRequest->get('status_penagihan'), function($query, $input) {
            $query->where('penagihan.status_penagihan', $input);
        });

        $penagihanQuery->when($searchRequest->get('ditolak') === 'true', function($query) {
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

    public function submit(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {    
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diajukan',
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->status_aktivitas = 'Diajukan';
            $penagihan->tanggal_pengajuan = now();
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Penagihan/Invoice berhasil diajukan!');
    }

    public function confirm(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            // Update The Detail Penagihan Status
            DetailPenagihan::where('id_penagihan', $penagihan->id_penagihan)
                ->whereIn('id_detail_penagihan', $request->post('group_of_id_detail_penagihan'))
                ->update(['status_diterima' => '400']);

            // Checking if all Penagihan is completed
            $detailPenagihanQuery = DetailPenagihan::query()
                ->where('id_penagihan', $penagihan->id_penagihan);

            $totalDetailPenagihan = $detailPenagihanQuery->get()->count();
            $totalDetailPenagihanDiterima = $detailPenagihanQuery->where('status_diterima', '400')->get()->count();

            $status_pencairan = '100';
            $status_aktivitas = 'Dibuat';

            if ($totalDetailPenagihan === $totalDetailPenagihanDiterima) {
                $status_pencairan = '400';
                $status_aktivitas = 'Diterima';
            }

            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Diterima',
            ]);
            $timeline->save();

            // Update The Penagihan Status
            $penagihan->status_penagihan = $status_pencairan;
            $penagihan->status_aktivitas = $status_aktivitas;
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi Penerimaan berhasil diterima!');
    }

    public function reject(Request $request, Penagihan $penagihan): RedirectResponse
    {
        DB::transaction(function () use ($request, $penagihan) {
            // Create A Timeline
            $timeline = new Timeline;
            $timeline->fill([
                'user_id' => $request->user()->id,
                'model_id' => $penagihan->id_penagihan,
                'model_type' => get_class($penagihan),
                'catatan' => $request->post('catatan'),
                'status_aktivitas' => 'Ditolak'
            ]);
            $timeline->save();
    
            // Update A Penagihan Status
            $penagihan->status_aktivitas = 'Ditolak';
            $penagihan->save();
        });

        return redirect()->back()->with('success', 'Verifikasi Penerimaan berhasil ditolak!');
    }
}